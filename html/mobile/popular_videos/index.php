<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_logdatastreaming"));

$p = new Page("mobile", "public", "page_popular_video");

$p->register("gameid", "hidden", array("setget" => "none"));
$p->register("quarterid", "hidden", array("setget" => "none"));
// Note: if quarterid = 0, assume whole game

$setup = new Setup();
$setup->loadCurrent();
if (Check::notInt($gameid)) {
  $gameid = $setup->getActiveGameID();
} 
$game = new Game($gameid);
$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());
$season = $game->getSeasonID();
$homeacr = $home->getAcronym();
$awayacr = $away->getAcronym();

$log = new LogDataStreaming();
$vid = new Video();

$qids = $vid->findQuartersByGameID($gameid);
if (in_array($quarterid, $qids)) { $quarterids = array($quarterid); }
else                             { $quarterids = $qids; $quarterid = 0;}
 
// Get the list of Videos from the Database that we are interested in
$popular_videos = array();
function compareVideoCounts($a, $b) {
  return $b[count] - $a[count]; // sort descending = b-a, ascending = a-b
}

foreach($quarterids as $qid) {
  $x = $vid->findApprovedVideosByQuarterGameID($qid, $gameid);
  $all_quarter_videos = array();
  while ($v = $x->getOne()) {
    $mms_filename = $path->getPath("link_video_basedir_mms") . $v->getVideoPath() . $v->getVideoFileName();
    $rtsp_filename = $path->getPath("link_video_basedir_rtsp") . $v->getVideoPath() . $v->getVideoFileName();
    $count = $log->countEntriesByFilenames(array($mms_filename, $rtsp_filename));
    $vidid = $v->getID();
    array_push($all_quarter_videos, array("videoid" => $vidid, "count" => $count));
  }
  usort($all_quarter_videos, "compareVideoCounts");
  for($i=0; $i<5 && $i<count($all_quarter_videos); $i++) {
    array_push($popular_videos, $all_quarter_videos[$i]);
  }
}
usort($popular_videos, "compareVideoCounts");

$most_popular_videos = array();

for($i=0; $i<5 && $i<count($popular_videos); $i++) {
  $v = new Video($popular_videos[$i][videoid]);
  if (Session::isMobile()) {
    $linkpath = $path->getPath("link_mobile_video_basedir") . $v->getVideoPath() . $v->getVideoFileName();
    $linkpath = preg_replace("/\.wmv/", ".3gp", $linkpath);
  } else {
    $linkpath = $path->getPath("link_video_basedir") . $v->getVideoPath() . $v->getVideoFileName();
  }
  $text = $v->getPlayText();
  $count = $popular_videos[$i][count];
  if (strlen($text) < 1) { $text = "Recent Play"; }
  array_push($most_popular_videos, array("linkpath" => $linkpath,
                                         "text" => $text,
                                         "count" => $count));
}

// $most_popular_videos now holds the 5 most popular videos according to game or quarter
$vid = new Video();
$quarterids = $vid->findQuartersByGameID($gameid);

$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Most Popular Videos</u></font></center>
<center><b><?=$homeacr?> vs. <?=$awayacr?>, <?=$season?></b><br></center>
<?if (!is_array($quarterids) || count($quarterids) < 1) {?>
  <font class="normal"><br>No highlights are available at this time.</font></center>
<?} else {?>
  <center>
  <?
  if (count($quarterids) > 4) {?><font class="mobile_h1"><br></font><?}?>
  <?for($i=0; $i<count($quarterids); $i++) {?>
    <a href="<?=$p->pageName()?>?gameid=<?=$gameid?>&quarterid=<?=$quarterids[$i]?>">Q<?=$quarterids[$i]?></a> | 
  <?}?>
  <a href="<?=$p->pageName()?>?gameid=<?=$gameid?>&quarterid=0">Game</a>
  <br>
  </center>
  Most popular videos from <?if ($quarterid != 0) {?>Quarter <?=$quarterid?>: <?}
                             else                 {?>this game: <?}?>
  <br>
  <table border=0 width=95%>
    <tr>
      <th>Video</th>
      <th>Description</th>
    </tr>
  <?foreach($most_popular_videos as $v) {?>
    <tr>
      <td><a href="<?=$v[linkpath]?>"><img src="<?=$path->getPath("image_camera_icon")?>"></a></td>
      <?if (preg_match("/:/", $v[text])) {
        // Use the last "$v" item as the authoritative text description.
        $text = split(":", $v[text]);
        $downspot = trim($text[0]) . ": ";
        $desc = "";
        for ($i=1; $i<count($text); $i++) {
          $desc .= trim($text[$i]) . " ";
        }
        $desc = trim($desc);
      } else { // Cases like "Recent Play"
        $downspot = "";
        $desc = $v[text];
      }?>
      <td><b><?=$downspot?></b><?=$desc?></td>
    </tr>
  <?}?>
  </table>
<?}?>

<?
$p->close();
?>
