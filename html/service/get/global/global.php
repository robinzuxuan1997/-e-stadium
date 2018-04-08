<?php
# deal with the eStadium current design, so we don't have to re-type it

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));

if (isset($_REQUEST['gameid']))
{
    $gameid = $_REQUEST['gameid'];
}
else
{
    $s = new Setup();
    $s->loadCurrent();
    $gameid = $s->getActiveGameID();
}

$game = new Game($gameid);

$data = array();


$data['gameId'] = $gameid = $game->getID();

$data['homeId'] = $homeid = $game->getTeamID();
$data['visitorId'] = $awayid = $game->getVisitorID();

$home = new Team($homeid);
$away = new Team($awayid);

$data['homeName'] = $home->getName();
$data['visitorName'] = $away->getName();

$data['homeAcronym'] = $home->getAcronym();
$data['visitorAcronym'] = $away->getAcronym();

$data['homeLogoPath'] = '/images/team_logos/'.$home->getLogoPath();
$data['visitorLogoPath'] = '/images/team_logos/'.$away->getLogoPath();

?>
