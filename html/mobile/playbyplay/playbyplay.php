<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_roster"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_drive"));

$p = new Page("mobile", "public", "page_playbyplay_text");

Check::videoAccess($p);

$p->register("view_quarter", "hidden", array("setget" => "none"));
$p->register("gameid", "hidden", array("setget" => "none"));

$setup = new Setup();
$setup->loadCurrent();

if (!Game::idExists($gameid)) {
      $gameid = $setup->getActiveGameID();
}
$game = new Game($gameid);
$gameid = $game->getID();
$hometeam = new Team($game->getTeamID());
$awayteam = new Team($game->getVisitorID());

$pl = new Play();
$qnums = $pl->findUniqueQuartersByGameID($gameid);
if (!is_array($qnums)) $qnums = array();
if (Check::notInt($view_quarter)) {
      if (count($qnums) < 1) {
            $view_quarter = 1;
      } else {
            $view_quarter = $qnums[count($qnums)-1];
      }
}

$r = new Roster();
$x = $r->findPlayersByTeamIDSeasonID($game->getTeamID(), $setup->getActiveSeasonID());
$x2 = $r->findPlayersByTeamIDSeasonID($game->getVisitorID(), $setup->getActiveSeasonID());
$players = array();
while ($r = $x->getOne()) {
      array_push($players, array( "lname" => strtolower(trim($r->getLName())),
                  "fname" => strtolower(trim($r->getFName())),
                  "id" => strtolower(trim($r->getID())),
                  "number" => strtolower(trim($r->getNumber()))));
}
while ($r = $x2->getOne()) {
      array_push($players, array( "lname" => strtolower(trim($r->getLName())),
                  "fname" => strtolower(trim($r->getFName())),
                  "id" => strtolower(trim($r->getID())),
                  "number" => strtolower(trim($r->getNumber()))));
}

$pl = new Play();

$x = $pl->findPlaysByGameIDQuarter($gameid, $view_quarter);

while ($pl = $x->getOne()) {
      if (Check::isInt($pl->getQuarter())) {
            if (!is_array($quarters[$pl->getQuarter()])) {
                  $quarters[$pl->getQuarter()] = array();
            }
            $text = $pl->getText();
            foreach ($players as $r) {
                  $text = preg_replace("/($r[lname], *$r[fname])/i",
                              "<a href=\"" . $path->getPath("page_player_bio") . "?playerid=$r[id]\">$1 (#$r[number])</a>",
                              $text);
                  $text = preg_replace("/($r[fname] *$r[lname])/i",
                              "<a href=\"" . $path->getPath("page_player_bio") . "?playerid=$r[id]\">$1 (#$r[number])</a>",
                              $text);
            }
            $v = new Video();
            $a = $v->findIDByPlayIDPlayText($pl->getID(), $pl->getText());
            
            if (!($vid = $a->getOne())) { // play doesn't exist in the DB anymore, one last try with just text
                  $a = $v->findIDByPlayText($pl->getText());
                  $vid = $a->getOne();
            }

            $driveindex = $pl->getDriveNo();
            $d = new Drive();
            $driveid = $d->findDriveIDByDriveIndexGameID($driveindex, $gameid);
            $d = new Drive($driveid);
            if ($d->getTeamID() == $hometeam->getID()) {
                  $team = $hometeam->getAcronym();
            } else {
                  $team = $awayteam->getAcronym();
            }
            //$text .= "(<a href=" . $path->getPath("page_gameviz") . "?gameid=$gameid&driveid=$driveid>Drive $team"."$driveindex</a>) ";

            if ($vid) { // found a video to go with this play!
                  if ($_REQUEST[rise] != 1) { // hack to make sure video links don't show up in RISE system
                        $text .= " <a target=\"_blank\" href=\"" . Check::constructVideoLink($vid->getVideoPath(), $vid->getVideoFileName()) . "\"><img src='/images/video_Icon.png' width='15px' height='15px' alt=''>Video</a>";
                  }
            }

            array_push($quarters[$pl->getQuarter()], array("text" => $text));
      }
}

?>

<marquee><small><center>Scroll down to read details | brought to you by <a href="http://www.att.com" target="_blank" style="color: white;">AT&amp;T</a></center></small></marquee>

<ul class="rounded">
      <?foreach($qnums as $q) {?>
      <li   class="arrow"><a class="normal" href="<?=$p->pageName()?>?view_quarter=<?=$q?>">Quarter <?=$q?></a></li>
            <?}?>
</ul>




<?
$alt = 0;
if (!is_array($quarters) || count($quarters) < 1) {?>
There are no plays at this time.
      <?} else {?>

<div>

            <?
            foreach($quarters as $qnum => $q) {?>

      <ul class="rounded"><li>Plays for Quarter <?=$qnum?></li></ul>

      <ul class="rounded">
                        <?foreach($q as $play) {?>
            <li>
                  <font class="playByPlay"><?=$play[text]?></font>
            </li>
                              <?}?>
      </ul>

                  <?}?>
</div>
      <?}?>

<script type="text/javascript">
      $(document).ready(function(){
            $('div#playbyplaycontent li.arrow a').click(function(){
                  link = $(this).attr("href");

                  $('div#playbyplaycontent').load(link);
            });

            $('div#videos_content a.video img').click(function(){
                  this.parent.click();
            });

      })

</script>