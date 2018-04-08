<?

include_once 'vip_redirect.php';

include_once(realpath(dirname(__FILE__) . "/../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));

$p = new Page("mobile", "public", "page_index");

$s = new Setup();
$s->loadCurrent();
$game = new Game($s->getActiveGameID());
$gameid = $game->getID();
$homeid = $game->getTeamID();
$awayid = $game->getVisitorID();
$home = new Team($homeid);
$away = new Team($awayid);
$homename = $home->getName();
$awayname = $away->getName();

$p->startTemplate();
?>
<script type="text/javascript">
function DoNav(Url)
  {
  document.location.href = Url;
  }
  </script>


<center>
  <!--<p><font class="mobile_h1"><u>Welcome to eStadium!</u></font></p>
</center>
<center><p>With eStadium, you can watch instant replays, track live statistics, and more,
all from your mobile device!  To begin, simply click one of the icons below with your browser, or use your keypad to select an icon.</p>-->

<!-- <p><u><b>Quick Tip:</b></u> Skip moving through all the links above on any page by pressing the "0" key
    on your mobile device.</p></center>-->

<table border="0" width="318">

<tr onclick="DoNav('<?=$path->getPath("page_index")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  &nbsp;<img border="0" src="<?=$path->getPath("image_icon_home")?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_index")?>"><font size = 3><b>Home</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Back to this page.<br/><br/></td></tr>


<tr onclick="DoNav('<?=$path->getPath("page_game_videos")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
 &nbsp; <a href="<?=$path->getPath("page_game_videos")?>"><img border="0" src="<?=$path->getPath("image_icon_camera")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_game_videos")?>"><font size = 3><b>Videos</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Replay videos as they happen.<br/><br/></td></tr>

<tr onclick="DoNav('<?= $path->getWebPath("page_archive") ?>?view=gamelist&gameid=<?= $game->getID() ?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  &nbsp;<a href="<?= $path->getWebPath("page_archive") ?>?view=gamelist&gameid=<?= $game->getID() ?>"><img border="0" src="<?=$path->getPath("image_icon_stats")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_archive")?>?view=gamelist&gameid=<?=$gameid?>"><font size = 3><b>Stats</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Live team and player statistics.<br/><br/></td></tr>

<tr onclick="DoNav('<?=$path->getPath("page_gameviz")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  &nbsp;<a href="<?=$path->getPath("page_gameviz")?>"><img border="0" src="<?=$path->getPath("image_icon_field")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_gameviz")?>"><font size = 3><b>Drive Tracker</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Watch drive progressions live!<br/><br/></td></tr>

<tr onclick="DoNav('<?=$path->getPath("page_playbyplay_text")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  &nbsp;<a href="<?=$path->getPath("page_playbyplay_text")?>"><img border="0" src="<?=$path->getPath("image_icon_pbp")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_playbyplay_text")?>"><font size = 3><b>Play-by-Play</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Up-to-the-minute play-by-play text.<br/><br/></td></tr>

<tr onclick="DoNav('<?=$path->getPath("page_other_scores")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
 &nbsp; <a href="<?=$path->getPath("page_other_scores")?>"><img border="0" src="<?=$path->getPath("image_icon_football")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_other_scores")?>"><font size = 3><b>Other Games</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>View other sports scores.<br/><br/></td></tr>

 <!-- <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$homeid?>"><img border="0" src="<?=$path->getPath("image_icon_home_helmet")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$homeid?>"><?=$homename?> Bios</a><br/>Coach and player bios for <?=$homename?>.<br/>

<tr onclick="DoNav('<?=$path->getPath("page_bio_select")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$awayid?>"><img border="0" src="<?=$path->getPath("image_icon_away_helmet")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$awayid?>"><?=$awayname?> Bios</a><br/>Coach and player bios for <?=$awayname?><br/>
-->
<tr onclick="DoNav('<?=$path->getPath("page_weather")?>');" onmouseout="this.style.background='white';" onmouseover="this.style.background='#DED9DA';this.style.cursor='pointer'"><td>
  &nbsp;<a href="<?=$path->getPath("page_weather")?>"><img border="0" src="<?=$path->getPath("image_icon_weather")?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=$path->getPath("page_weather")?>"><font size = 3><b>Weather/Radar</b></a> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size = 2>Live weather information with radar.<br/><br/></td></tr>
</table>

 

<?
$p->close();
?>
