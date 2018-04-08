<?php
if(!isset($_REQUEST["teamid"]) || !isset($_REQUEST['gameid'])){
	echo '{"fail"}';
	die(); // can't function w/o it
}

// deal with the eStadium current design, so we don't have to re-type it
require realpath(dirname(__FILE__) . '/../../jsonwrapper/jsonwrapper.php');
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
$g = new Game($_REQUEST['gameid']);

$total 		= $g->findGameTotalByTeamid($_REQUEST['teamid']);
$defense 	= $g->findTeamDefenseByTeamID($_REQUEST['teamid']);
?>
