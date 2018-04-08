<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));

//$p = new Page("normal", "admin", "page_admin_monitor");
//$p = new Page("normal", "public", "page_admin_monitor");

$setup = new Setup();
$setup->loadCurrent();

$game = new Game($setup->getActiveGameID());
$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());

if ($_REQUEST[team] == "away") {
  $teamid = $away->getID();
} else {
  $teamid = $home->getID();
}
$awayid = $away->getID();
$homeid = $home->getID();

?>

<head>
  <!---<meta http-equiv="refresh" content="15" />-->

</head>
  <frameset cols="15%,20%,20%,15%,15%, 15%">
    <frame src="<?="http://estad4.vip.gatech.edu/mobile/videos/gamevids/index.php"?>?ajax&gameid=<?=$game->getID()?>&teamid=<?=$awayid?>&noheader=true&opennewpage=true" />
    <frame src="<?=$path->getPath("page_gameviz")?>?ajax&noheader=true" />
    <frame src="<?=$path->getPath("page_playbyplay_text")?>?ajax&noheader=true" />
    <frame src="<?=$path->getPath("page_archive")?>?ajax&view=gamelist&gameid=<?=$game->getID()?>&noheader=true" />
    <frame src="<?=$path->getPath("page_playerstats")?>?ajax&gameid=<?=$game->getID()?>&teamid=<?=$homeid?>&noheader=true" />
    <frame src="<?=$path->getPath("page_playerstats")?>?ajax&gameid=<?=$game->getID()?>&teamid=<?=$awayid?>&noheader=true" />
  </frameset>
