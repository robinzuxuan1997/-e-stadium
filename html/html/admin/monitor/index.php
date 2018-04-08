<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));

$p = new Page("normal", "admin", "page_admin_monitor");
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

?>

<head>
  <meta http-equiv="refresh" content="15" />
</head>
<frameset rows="140px,80%">
  <frame src="<?=$path->getPath("page_big_header_image")?>" />
  <frameset cols="20%,20%,20%,20%,20%">
    <frame src="<?=$path->getPath("page_game_videos")?>?gameid=<?=$game->getID()?>&teamid=<?=$awayid?>&noheader=true&opennewpage=true" />
    <frame src="<?=$path->getPath("page_gameviz")?>?noheader=true" />
    <frame src="<?=$path->getPath("page_playbyplay_text")?>?noheader=true" />
    <frame src="<?=$path->getPath("page_archive")?>?view=gamelist&gameid=<?=$game->getID()?>&noheader=true" />
    <frame src="<?=$path->getPath("page_playerstats")?>?gameid=<?=$game->getID()?>&teamid=<?=$homeid?>&noheader=true" />
<?/*    <frame src="<?=$path->getPath("page_playerstats")?>?gameid=<?=$game->getID()?>&teamid=<?=$awayid?>&noheader=true" /> */?>
  </frameset>
</frameset>
<?
?>
