<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));

$p = new Page("mobile", "public", "page_gameday");

$setup = new Setup();
$setup->loadCurrent();

$game = new Game($setup->getActiveGameID());
$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());

$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Game Day Experience</u><br><br></font></center>
<ul>
  <li><a class="mainmenu" href="<?=$path->getPath("page_game_videos")?>">Current Game Videos</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_video_search")?>">Video Search</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_playbyplay_text")?>">Play-By-Play</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_gameviz")?>">Drive Visualization</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_archive")?>?view=gamelist&gameid=<?=$game->getID()?>">Team Stat Comparison</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_playerstats")?>?gameid=<?=$game->getID()?>&teamid=<?=$home->getID()?>"><?=$home->getAcronym()?> Player Stats</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_playerstats")?>?gameid=<?=$game->getID()?>&teamid=<?=$away->getID()?>"><?=$away->getAcronym()?> Player Stats</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_weather")?>">Weather/Radar</a></li>
</ul>

<?
$p->close();
?>
