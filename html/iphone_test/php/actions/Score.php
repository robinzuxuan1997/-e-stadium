<?php
include_once("../../../../include/Page/class_path.php");
//include_once(realpath(dirname(__FILE__) . "../../../../include/Page/class_path.php"));

$path = new Path();
include_once($path->getFilePath("class_scoring_drive"));
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
  }
  elseif ($a->getTeamID() == $game->getVisitorID()) {
    $awayscore = $a->getFinalScore();
  }
}
if (!$homescore) $homescore = "0";
if (!$awayscore) $awayscore = "0";


$pl = new Play();
$rp = $pl->findMostRecentPlayByGameID($game->getID());
$hasball = $rp->getHasBall();

$homeball = "";
$awayball = "";
if($hasball == "H"){
    $homeball = '<img src="php/actions/images/ball.png" height="15" width="25"/>';
}
else if($hasball == "V"){
    $awayball = '<img src="php/actions/images/ball.png" height="15" width="25"/>';
}


echo '<ul id="infogame" class="edgetoedge centered">
                <li>
                    <div id="score">
                        <span class="home"><span id="homeball">'.$homeball.'</span><span id="homename">'.$homename.'</span>&nbsp;:&nbsp;<span id="homescore">'.$homescore.'</span></span> &nbsp;|&nbsp;
                        <span class="away"><span id="awayball">'.$awayball.'</span><span id="awayname">'.$awayname.'</span>&nbsp;:&nbsp;<span id="awayscore">'.$awayscore.'</span></span>
                    </div>
                </li>
</ul><!--end of infoscore ul-->';

}
?>
