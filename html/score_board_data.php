<?php
include_once("../include/Page/class_path.php");
//include_once(realpath(dirname(__FILE__) . "../include/Page/class_path.php"));

$path = new Path();
include_once($path->getFilePath("class_scoring_drive"));
include_once($path->getFilePath("class_scripts_global_settings"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game_total"));
include_once($path->getFilePath("class_play"));


if(is_null($gameid)) $gameid = $_REQUEST['gameid'];
if($gameid>0) {
      $gameid = $gameid;

      $game = new Game($gameid);
	  	


      $gt = new GameTotal();
  
  

      $homeid = $game->getTeamID();
      $awayid = $game->getVisitorID();

      $home = new Team($homeid);
      $away = new Team($awayid);

      $homeAcro = $home->getAcronym();
      $homename = $home->getName();
      $homeLogo = $home->getLogoPath();



      $awayAcro = $away->getAcronym();
      $awayname = $away->getName();
      $awayLogo = $away->getLogoPath();


      $x = $gt->findGameTotalsByGameID($game->getID(), true);


      foreach ($x as $a) {
            if ($a->getTeamID() == $game->getTeamID()) {
                  $homescore = $a->getFinalScore();
                  $homeFQ = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
                  $homeSQ = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
                  $homeTQ = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
                  $home4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
                  $home_t = $a->getFinalScore();
                  $home5Q = $a->getFinalScore() - ($home4Q + $homeTQ + $homeSQ + $homeFQ);
            }
            elseif ($a->getTeamID() == $game->getVisitorID()) {
                  $awayscore = $a->getFinalScore();
                  $awayFQ = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
                  $awaySQ = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
                  $awayTQ = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
                  $away4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
                  $away_t = $a->getFinalScore();
                  $away5Q = $a->getFinalScore() - ($away4Q + $awayTQ + $awaySQ + $awayFQ);
            }
      }

      if (!$homescore) $homescore = "0";
      if (!$awayscore) $awayscore = "0";


      $pl = new Play();
      $rp = $pl->findMostRecentPlayByGameID($game->getID());
	 
	$hasball = $rp->getHasBall();
	
	if ($hasball == "H") {
$homePossLogo = "PossessionIcon.gif";
$awayPossLogo = "NoPossessionIcon.gif";
}
if ($hasball == "V") {
$awayPossLogo = "PossessionIcon.gif";
$homePossLogo = "NoPossessionIcon.gif";
}
if ($hasball != "H" && $hasball != "V") $hasball = false;
if ($hasball == false) {
$homePossLogo = "NoPossessionIcon.gif";
$awayPossLogo = "NoPossessionIcon.gif";
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

$quarter_text = "";

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
	$time = "";

}
//Display game time and day if its before the game right now
if (strtotime($game->getStart())> (strtotime("now"))) {
	$quarter_text = date('D n/j',(strtotime($game->getStart())));
	$time = date('g:i A',(strtotime($game->getStart())));

}




//Tell if it is halftime

if ($quarter == 2 && strlen(strstr($text,$end_half_text))>0) {
$quarter_text = "Halftime";
$time = "";
}
}

else {
      echo "there were some errors parsing the data";
}
?>

<div id="score_board_container">
      <table width="320" border="0">
            <tr>
		
                  <td width="10">&nbsp;</td>
                 <td width="103" height="40" id="visitor_logo"><img src="/images/team_logos/<?=$awayLogo?>" width="42" height="42"></td> 
                  <td width="69"><font size = "2"><b><?=$quarter_text?></b></font></td>
                  <td width="103" height="40" id="home_logo"><img src="/images/team_logos/<?=$homeLogo?>" width="42" height="42"></td>			

                  <td width="10">&nbsp;</td>
		
           
 </tr>
            <tr>
			
                  <td width="10"><img src="/images/<?=$awayPossLogo?>"></td>
 <td width="103" id="visitor_name"><b><font size = "3"><?=$awayname?></font></td>
                   <td width="69" id="time_left"><font size = "2"><b><?=$time?></b></font></td>
  <td width="103" id="home_name"><b><font size = "3"><?=$homename?></font></td>
     <td width="10"><img src="/images/<?=$homePossLogo?>"></td>
			



            </tr>
<tr>
			
                  
			<td width="10">&nbsp;</td>
		<td width="103" id="away_score"><b><font size = "4"><?=$away_t?></font></b></td>
                 <td width="69">&nbsp;</td>
                <td width="103" id="home_score"><b><font size = "4"><?=$home_t?></font></b></td>

                 <td width="10">&nbsp;</td>			



            </tr>

      </table>
<!--
<br>
      <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
                  <td width="40"><center>&nbsp;</td>
	

            
                 <td width="50"><b><font size = "3">Q1</td>
                  <td width="50"><b><font size = "3">Q2</td>
                  <td width="50"><b><font size = "3">Q3</td>
                  <td width="50"><b><font size = "3">Q4</td>
	           
                  <?php
                  if($quarter > 4){
                      echo '<td width="50"><b><font size = "3">OT</td>';
                  }
                  ?>
		    <td width="60"><b><font size = "3">Total</td>
                              </tr>
            <tr>
		
                  <td width="40" id="visitor_team_init"><b><font size = "3" color="<?=$awayColor?>"><?=$awayAcro?></td>
                  
                  <td  width="50" id="vistor_q1"><font size = "3"><?=$awayFQ?></td>
                  <td width="50" id="vistor_q2"><font size = "3"><?=$awaySQ?></td>
                  <td width="50" id="vistor_q3"><font size = "3"><?=$awayTQ?></td>
                  <td width="50" id="vistor_q4"><font size = "3"><?=$away4Q?></td>
		
                  <?php
                  if($quarter > 4){
                      echo "<td width='50'><font size = '3'>$away5Q</td>";
                  }
		    
                  ?>
             <td width="60" id="vistor_total"><font size = "3"><?=$away_t?></td>
            </tr>
            <tr>
		
                  <td width="40" id="home_team_init"><b><font size = "3" color="<?=$homeColor?>"><?=$homeAcro?></td>
                  
                  <td width="50" id="home_q1"><font size = "3"><?=$homeFQ?></td>
                  <td width="50" id="home_q2"><font size = "3"><?=$homeSQ?></td>
                  <td width="50" id="home_q3"><font size = "3"><?=$homeTQ?></td>
                  <td width="50" id="home_q4"><font size = "3"><?=$home4Q?></td>
		
                  <?php
                  if($quarter > 4){
                      echo "<td width='50'><font size = '3'>$home5Q</td>";
                  }
                  ?>
		    <td width="60" id="home_total"><font size = "3"><?=$home_t?></td>
            </tr>
      </table>
-->
<br>
<br>
</div>
