<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_boiler_facts");

$setup = new Setup();
$setup->loadCurrent();
$game = new Game($setup->getActiveGameID());
$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());
$homeid = $home->getID();
$awayid = $away->getID();
$homeacr = $home->getAcronym();
$awayacr = $away->getAcronym();

$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Boiler Facts</u><br></font></center>
<ul>
<?/*  <li><a class="mainmenu" href="<?=$path->getPath("page_schedule")?>">Season Schedule</a></li> */?>
  <li><a class="mainmenu" href="<?=$path->getPath("page_coach_bio")?>?teamid=<?=$homeid?>"><?=$homeacr?> Coach Biographies</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_player_bio")?>?teamid=<?=$homeid?>"><?=$homeacr?> Player Biographies</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_coach_bio")?>?teamid=<?=$awayid?>"><?=$awayacr?> Coach Biographies</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_player_bio")?>?teamid=<?=$awayid?>"><?=$awayacr?> Player Biographies</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_mobile_song")?>">Hail Purdue Lyrics</a></li>
<?/*  <li><a class="mainmenu" href="<?=$path->getPath("page_rules_regulations")?>">Rules and Regulations</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_trivia")?>">Trivia Game</a></li> */?>
</ul>

<?
$p->close();
?>
