<?php
require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();

include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_team"));

//Get the optional gameid variable
//If it was not passed, get the active game id
//$p->register("gameid", "hidden", array());
if (isset($_REQUEST['gameid']))
	$gameid = $_REQUEST['gameid'];
if (!isset($gameid) || !Game::idExists($gameid)) {
  $setup = new Setup();
  $setup->loadCurrent();

  $gameid = $setup->getActiveGameID();
}
//Get the optional driveid variable
//If it was not passed, get the most recent drive id
//$p->register("driveid", "hidden", array());
if (isset($_REQUEST['driveid']))
	$driveid = $_REQUEST['driveid'];
if (!isset($driveid) || !Drive::idExists($driveid)) {
  $d = new Drive();
  $driveid = $d->findMaxDriveIndexDriveidByGameid($gameid);
  $_REQUEST['last15'] = "true";
}

//Determine area of the field
//$p->register("last15", "hidden", array());
$last15 = $_REQUEST['last15'];
if ($last15!="true") {
  $last15 = "";
}
else {
  $last15 = "&last15=true";
}
$game = new Game($gameid);
$season = $game->getSeasonID();
$hometeam = new Team($game->getTeamID());
$awayteam = new Team($game->getVisitorID());

?>
