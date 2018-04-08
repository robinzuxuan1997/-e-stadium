<?
include_once(realpath(dirname(__FILE__) . "/../../include/Page/class_path.php"));
$path = new Path();
header("Location: " . $path->getPath("page_index"));
/*
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
<center><font class="mobile_h1"><u>Welcome to eStadium!</u></font></center>
<center><p>With eStadium, you can watch instant replays, track live statistics, and more, 
all from your mobile device!  To begin, simply click one of the icons below.</p></center>

<table border="0"><tr><td width="20px"> </td><td>
  <a href="<?=$path->getPath("page_index")?>"><img border="0" src="<?=$path->getPath("image_icon_home")?>"></a>&nbsp; 
    <a href="<?=$path->getPath("page_index")?>">Home</a><br/>Back to this page.<br/>

  <a href="<?=$path->getPath("page_game_videos")?>"><img border="0" src="<?=$path->getPath("image_icon_camera")?>"></a>&nbsp; 
    <a href="<?=$path->getPath("page_game_videos")?>">Videos</a><br/>Replay videos as they happen.<br/>

  <a href="<?=$path->getPath("page_archive")?>?view=gamelist&gameid=<?=$gameid?>"><img border="0" src="<?=$path->getPath("image_icon_stats")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_archive")?>?view=gamelist&gameid=<?=$gameid?>">Stats</a><br/>Live team and player statistics.<br/>

  <a href="<?=$path->getPath("page_gameviz")?>"><img border="0" src="<?=$path->getPath("image_icon_field")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_gameviz")?>">Drive Viz</a><br/>Watch drive progressions live!<br/>

  <a href="<?=$path->getPath("page_playbyplay_text")?>"><img border="0" src="<?=$path->getPath("image_icon_pbp")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_playbyplay_text")?>">Play-by-play</a><br/>Up-to-the-minute play-by-play text.<br/>

  <a href="<?=$path->getPath("page_other_scores")?>"><img border="0" src="<?=$path->getPath("image_icon_football")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_other_scores")?>">Other Games</a><br/>ESPN Mobile's College Football Scores<br/>

  <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$homeid?>"><img border="0" src="<?=$path->getPath("image_icon_home_helmet")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$homeid?>"><?=$homename?> Bios</a><br/>Coach and player bios for <?=$homename?>.<br/>

  <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$awayid?>"><img border="0" src="<?=$path->getPath("image_icon_away_helmet")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_bio_select")?>?teamid=<?=$awayid?>"><?=$awayname?> Bios</a><br/>Coach and player bios for <?=$awayname?><br/>

  <a href="<?=$path->getPath("page_weather")?>"><img border="0" src="<?=$path->getPath("image_icon_weather")?>"></a>&nbsp;
    <a href="<?=$path->getPath("page_weather")?>">Weather/Radar</a><br/>Live weather and radar image<br/>

</td></tr></table>
<?
$p->close();
?>

*/
