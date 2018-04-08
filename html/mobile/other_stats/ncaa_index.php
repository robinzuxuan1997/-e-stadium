<?php
//include('../../mobile_device_detect.php');
//mobile_device_detect('http://estad4.vip.gatech.edu/iphone',true,true,true,true,true,'http://estad4.vip.gatech.edu/mobile',false);


include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_page"));

// Setup Page

// get games;
$g = new Game();
$games = $g->findActiveGames();
?>
<table width="320" align=center>
<?php
$gray = FALSE;
$bgcolor = "FFFFFF";
while($game=$games->getOne()){
	$home = new Team($game->getHomeID());
	$away = new Team($game->getVisitorID());

$pl = new Play();
      $rp = $pl->findMostRecentPlayByGameID($game->getID());
$quarter = $rp->getQuarter();
	$time = $rp->getClock();
$text = $rp->getText();
	$end_game_text =  ("End of game");
	$end_half_text =  ("End of half");

$OT_value = $quarter - 4;

$gamedate = $game->getStart();
$gamedateint = strtotime($gamedate);


if ($quarter > 4) $quarter_text = " OT #" . $OT_value;
if ($quarter == 4) $quarter_text = "4th";
if ($quarter == 3) $quarter_text = "3rd";
if ($quarter == 2) $quarter_text = "2nd";
if ($quarter == 1) $quarter_text = "1st";

if ($quarter > 4) $time = "";


if ((strlen(strstr($text,$end_game_text))>0)&&($hometotal!=$awaytotal)){
$quarter_text = "Final";
$time = "";
}

if ($quarter == 2 && strlen(strstr($text,$end_half_text))>0) {
$quarter_text = "Half";
$time = "";
}


$hometotal = $game->findGameTotalByTeamid($game->getHomeID());
$awaytotal = $game->findGameTotalByTeamid($game->getVisitorID());



	if($gray){
		$bgcolor="DDDDDD";
		$gray = FALSE;
	} else {
		$bgcolor ="FFFFFF";
		$gray = TRUE;
	}
	if ($gamedateint+419 < (strtotime("now"))) {
	if ($gamedateint+14400 < (strtotime("now"))) {
	$quarter_text = "Final";
$time = "";
}
	echo "<tr style=\"background-color: $bgcolor;\"><td><b>".$away->getName()." ".$awaytotal->getFinalScore()." </b> <br> <b>".$home->getName()." ".$hometotal->getFinalScore()."</b></td><td width = 30><center><b> ".$quarter_text." <br>".$time."</b></center></td> <td> ".$game->getStart()."  </td><td><a href=\"".$path->getWebPath("page_archive")."?view=gamelist&gameid=".$game->getID()."\"><img border=\"0\" src=\"icon_stats_autogen.gif\"></img></a> </td><td><a href=\"".$path->getWebPath("page_drivetracker")."?view=gamelist&gameid=".$game->getID()."\"><img border=\"0\" src=\"icon_field_autogen.gif\"> </img></a> </td><td><a href=\"".$path->getWebPath("page_playbyplay_text")."?view=gamelist&gameid=".$game->getID()."\"><img border=\"0\" src=\"icon_pbp_autogen.gif\"> </img></a> </td>";
	
}
	else {
echo "<tr style=\"background-color: $bgcolor;\"><td width = 180><b>".$away->getName()." ".$awaytotal->getFinalScore()." </b> <br> <b>".$home->getName()." ".$hometotal->getFinalScore()."</b></td><td width = 30><center></center></td> <td> ".$game->getStart()." </td><td> </td><td> </td><td> </td>";
	
}
	



}


?>
</table>

