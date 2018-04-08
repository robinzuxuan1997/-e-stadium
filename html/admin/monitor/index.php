<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));



//$p = new Page("normal", "admin", "page_admin_monitor");
$p = new Page("normal", "public", "page_admin_monitor");

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

//$p->startTemplate();
?>

<head>
  <meta http-equiv='refresh' content='60' />
<title> eStadium Stats Dashboard </title>
</head>
 <frameset cols='15%,22%,19%,14%,15%, 15%'>

    <frame noresize  src='/admin/monitor/gamevids/index.php' />
    <frame noresize  src='/admin/monitor/gameviz/index.php' />
    <frame noresize  src='/admin/monitor/playbyplay/index.php' />
    <frame noresize  src='/admin/monitor/archive/index.php?view=gamelist&gameid=<?=$game->getID()?>' />
    <frame noresize src='/admin/monitor/playerstats/index.php?gameid=<?=$game->getID()?>&teamid=<?=$homeid?>' />
    <frame noresize  src='/admin/monitor/playerstats/index.php?gameid=<?=$game->getID()?>&teamid=<?=$awayid?>' /> 

  </frameset> 
