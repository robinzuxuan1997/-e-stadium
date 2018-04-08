<?php
require '../../jsonwrapper/jsonwrapper.php';
include_once("../../../../include/Page/class_path.php");
//include_once(realpath(dirname(__FILE__) . "../../../../include/Page/class_path.php"));

$path = new Path();
//include_once($path->getFilePath("class_scoring_drive"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game_total"));
include_once($path->getFilePath("class_play"));

if(isset ($_REQUEST['gameid'])){

$gameid = $_REQUEST['gameid'];
$game = new Game($gameid);

$homeid = $game->getTeamID();
$awayid = $game->getVisitorID();

$home = new Team($homeid);
$away = new Team($awayid);

$homename = $home->getAcronym();
$awayname = $away->getAcronym();

$gt = new GameTotal();
$x = $gt->findGameTotalsByGameID($game->getID(), true);

foreach ($x as $a) {
            if ($a->getTeamID() == $game->getTeamID()) {
                  $homescore = $a->getFinalScore();
                  $homeFQ = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
                  $homeSQ = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
                  $homeTQ = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
                  $home4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
                  $home5Q = $homescore - ($home4Q + $homeTQ + $homeSQ + $homeFQ);
            }
            elseif ($a->getTeamID() == $game->getVisitorID()) {
                  $awayscore = $a->getFinalScore();
                  $awayFQ = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
                  $awaySQ = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
                  $awayTQ = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
                  $away4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
                  $away5Q = $awayscore - ($away4Q + $awayTQ + $awaySQ + $awayFQ);
            }
}

if (!$homescore) $homescore = 0;
if (!$awayscore) $awayscore = 0;


$pl = new Play();
$rp = $pl->findMostRecentPlayByGameID($game->getID());
$hasball = $rp->getHasBall();

$homeball = false;
$awayball = false;

if($hasball == "H"){
    $homeball = true;
}
else if($hasball == "V"){
    $awayball = true;
}

$quarter = $rp->getQuarter();
	$time = $rp->getClock();
	$text = $rp->getText();
	$end_game_text =  ("End of game");
	$end_half_text =  ("End of half");

//Get the time and display it on the header
//if ($time) $time_prev = $time;
//if ($time==null) $time = $time_prev;
if ($quarter > 4) $time = "";

else{
}
$OT_value = $quarter - 4;

if ($quarter > 4) $quarter_text = "OT #" . $OT_value;
if ($quarter == 4) $quarter_text = "4th";
if ($quarter == 3) $quarter_text = "3rd";
if ($quarter == 2) $quarter_text = "2nd";
if ($quarter == 1) $quarter_text = "1st";


//If a game has ended, display Final
if ((strlen(strstr($text,$end_game_text))>0)&&($home_t!=$away_t)){
      $quarter_text = "Final";
      $time = "";
}
if (strtotime($game->getStart())+14400 < (strtotime("now"))) {
	$quarter_text = "Final";
}

//Tell if it is halftime

if ($quarter == 2 && strlen(strstr($text,$end_half_text))>0) {
      $quarter_text = "Halftime";
      $time = "";
}

//----------------------------------------------------------------------------

$data = array();
$homeData = array();
$visitorData = array();

$homeData['total'] = $homescore;
$homeData['firstQ'] = $homeFQ;
$homeData['secondQ'] = $homeSQ;
$homeData['thirdQ'] = $homeTQ;
$homeData['fourthQ'] = $home4Q;
$homeData['overQ'] = $home5Q;
$homeData['hasBall'] = $homeball;

$visitorData['total'] = $awayscore;
$visitorData['firstQ'] = $awayFQ;
$visitorData['secondQ'] = $awaySQ;
$visitorData['thirdQ'] = $awayTQ;
$visitorData['fourthQ'] = $away4Q;
$visitorData['overQ'] = $away5Q;
$visitorData['hasBall'] = $awayball;

$data['homeData'] = $homeData;
$data['visitorData'] = $visitorData;
$data['quarter'] = $quarter;

echo json_encode($data);
}
?>
