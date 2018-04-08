<?php
/* for debugging
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/
?>
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once(realpath(dirname(__FILE__) . "/../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_venue"));
$p = new Page("web", "public", "page_dashboard");
$s = new Setup();
$s->loadCurrent();
if (isset($_REQUEST['gameid'])) {
    $gameid = $_REQUEST['gameid'];
} else 
	$gameid = $s->getActiveGameID();

$game = new Game($gameid);
$homeid = $game->getTeamID();
$awayid = $game->getVisitorID();
$home = new Team($homeid);
$venue = new Venue();
$away = new Team($awayid);
//$venue = new Venue();my
//$ven = $venue->findVenueByGameID($game->getID(), true);


$homeacrnym = $home->getAcronym();
$awayacrnym = $away->getAcronym();

$homelogo = '/../images/team_logos/'.$home->getLogoPath();
$awaylogo = '/../images/team_logos/'.$away->getLogoPath();

$gt = new GameTotal();
$x = $gt->findGameTotalsByGameID($game->getID(), true);

$ven = new Venue();

$venuetest = $ven->findVenueByGameID($game->getID(), true);

foreach ($x as $a) {
	if ($a->getTeamID() == $game->getTeamID()) {
      $homescore = $a->getFinalScore();
      $home1Q = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
      $home2Q = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
      $home3Q = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
      $home4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
      $home5Q = $homescore - ($home4Q + $home3Q + $home2Q + $home1Q);
	}
	elseif ($a->getTeamID() == $game->getVisitorID()) {
      $awayscore = $a->getFinalScore();
      $away1Q = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
      $away2Q = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
      $away3Q = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
      $away4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
      $away5Q = $awayscore - ($away4Q + $away3Q + $away2Q + $away1Q);
	}
}

if (!$homescore) $homescore = 0;
if (!$awayscore) $awayscore = 0;

$pl = new Play();
$rp = $pl->findMostRecentPlayByGameID($game->getID());

$hasball = $rp->getHasBall();

$homeball = false;
$awayball = false;

if ($hasball == "H") {
    $homeball = true;
} else if ($hasball == "V") {
    $awayball = true;
}

$quarter = $rp->getQuarter();
$time = $rp->getClock();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="/../GT_logo_small.gif" />
<link rel="apple-touch-startup-image" href="../images/background.png" />
<title>eStadium: Georgia Tech</title>

<link rel="stylesheet" href="../iphone/lib/jquery.mobile.scrollview.css"/>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
<link rel="stylesheet" href="../iphone/style.css"/>
<?php
$scroll="no";
if ($scroll=="no")
	echo "<link rel=\"stylesheet\" href=\"../iphone/noscroll.css\"/>\n";
else
	echo "<link rel=\"stylesheet\" href=\"../iphone/scroll.css\"/>\n";

?>

<link rel="stylesheet" href="../homepage.css"/>
<link rel="stylesheet" href="dashboard_style.css"/>

<script src="http://code.jquery.com/jquery-1.5.js"></script>
<script type="text/javascript" src="../iphone/src.js"></script>

<script>
	$(document).bind("mobileinit", function(){
	  //apply overrides here
	  console.log("mobileinit");
	  //setTimeout(function(){$.mobile.selectmenu.prototype.options.nativeMenu = true;},0);
	  //$.mobile.autoInitialize = false;
	});
</script>
<script type="text/javascript" src="../iphone/lib/modernizr-1.7.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>

<script type="text/javascript" src="../iphone/lib/jquery.easing.1.3.js"></script>
<?php
if ($scroll!="no")
    echo '<script type="text/javascript" src="../iphone/lib/jquery.mobile.scrollview.js"></script>';
?>

<script type="text/javascript">
	var server_name = "<?=$path->getWebRoot();?>";
	server_name=server_name.substring(0,server_name.length-1);
</script>

<script type="text/javascript" src="../iphone/scripts/videos.js"></script>
<script type="text/javascript" src="../iphone/scripts/main.js"></script>
<script type="text/javascript" src="../iphone/scripts/drivetracker.js"></script>
<script type="text/javascript" src="../iphone/scripts/stats.js"></script>
<script type="text/javascript" src="../iphone/scripts/playbyplay.js"></script>

<!--dashboard scripts-->
<script type="text/javascript" src="./scripts/offense.js"></script>
<script type="text/javascript" src="./scripts/teamstats.js"></script>
<script type="text/javascript" src="./scripts/defense.js"></script>
<script type="text/javascript" src="./scripts/playbyplay.js"></script>
<script type="text/javascript" src="./scripts/specialteams.js"></script>

<!-- timer script -->
<script type="text/javascript" src="./timer.js"></script>
<script type="text/javascript" src="./refresh.js"></script>

<script>
	
	var gameid = <?=($gameid?$gameid:0);?>;
	//gameid=399;
	var homeid = <?=($homeid?$homeid:0);?>;
	var awayid = <?=($awayid?$awayid:0);?>;
	var scroll = "<?=$scroll;?>";
	var homeacrynm = "<?=$homeacrnym;?>";
	var awayacrynm = "<?=$awayacrnym;?>";

	homeHasBall = <?=($homeball?1:0);?>;
	awayHasBall = <?=($awayball==true?true:0);?>;
	currentQuarter = <?=($quarter?$quarter:0);?>;
	
	var home = {
	   id: homeid,
	   get hasball(){
	     return homeHasBall;  
	   },
	   set hasball(val){
	     homeHasBall = val;  
	   },
	   acrynm: homeacrynm,
	   color: {
	      dark: "<?=$home->getColor1();?>",
	      light: "<?=$home->getColor2();?>", 
	   },
	   logo: "<?=$homelogo;?>"
	}
	var away = {
	   id: awayid,
	   acrynm: awayacrynm,
	   get hasball(){
	     return awayHasBall;  
	   },
	   set hasball(val){
	     awayHasBall = val;  
	   },
	   color: {
	      dark: "<?=$away->getColor1();?>",
	      light: "<?=$away->getColor2();?>", 
	   },
	   logo: "<?=$awaylogo;?>"
	}
	var ajax = true;
	
	if (!ajax){
		$.ajax = function(){};	
	}
</script>



<link href="../GT_logo_small.gif" type="image/x-icon" rel="Shortcut Icon">
</head>
<body onLoad="swStart('beg2','+');">

<table border="0" cellpadding="10" cellspacing="0">
 <tr>
  <td>

<table width="500" border="1" cellpadding="0" cellspacing="0">
 <tr>
  <td width="120" align="center">
	<table border="1" cellpadding="0" cellspacing="0" width="120" class="teamscore">
	 <tr>
	  <td colspan="2" align="center"><?=$home->getName();?></td>
	 </tr>
	 <tr>
	  <td align="center">
		<image class="home-logo" width="32" height="32" src="<?=$homelogo;?>"/>
		<image class="possession hidden" width="16" height="16" src="../iphone/images/PossessionIcon.png"/>
	  </td>
	  <td align="center">
		<div class="home-score"><?=$homescore;?></div>
	  </td>
	 </tr>
	</table>
  </td>
  <td width="260" align="center">
	<div id="footer">
	<!--<div id="footer-bottom">-->
	<div class="game-period">
		<div class="game-quarter"></div>
		<div class="game-time"></div>
	</div>
	</div>
	<!--</div>-->
  </td>
  <td width="120" align="center">

	<table border="1" cellpadding="0" cellspacing="0" width="120" class="teamscore">
	 <tr>
	  <td colspan="2" align="center"><?=$away->getName();?></td>
	 </tr>
	  <td align="center">
		<image class="possession hidden" width="16" height="16" src="../iphone/images/PossessionIcon.png"/>
		<image class="away-logo" width="32" height="32" src="<?=$awaylogo;?>"/>
	  </td>
	  <td align="center">
		<div class="away-score"><?=$awayscore;?></div>
	  </td>
	 </tr>
	</table>

  </td>
 </tr>
</table>
<br />
<table width="500" border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" class="dash-qscore-table">
<tr>
	<td width="100%"></td>
	<td class="qscore">1</td>
	<td class="qscore">2</td>
	<td class="qscore">3</td>
	<td class="qscore">4</td>
	<td class="ot hidden">OT</td>
	<td class="qscore">T</td>
</tr>
<tr>
	<td width="100%"><?=$home->getName();?></td>
	<td class="qscore">&nbsp;<?=$home1Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$home2Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$home3Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$home4Q;?>&nbsp;</td>
	<td class="ot hidden"><?=$home5Q;?>&nbsp;</td>
	<td class="qscore"><?=$homescore;?>&nbsp;</td>
	
</tr>
<tr>
	<td width="100%"><?=$away->getName();?></td>
	<td class="qscore">&nbsp;<?=$away1Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$away2Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$away3Q;?>&nbsp;</td>
	<td class="qscore">&nbsp;<?=$away4Q;?>&nbsp;</td>
	<td class="ot hidden"><?=$away5Q;?>&nbsp;</td>
	<td class="qscore"><?=$awayscore;?>&nbsp;</td>
</tr>
</table>

  </td>
  <td valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="400">
	 <tr>
	  <td>
	  <?php
	  foreach ($venuetest as $v)
		{
			echo "Kickoff time: ".$v->getKickoffTime()."<br />";
			echo "End of Game: ".$v->getEndOfGame()."<br />";
			echo "Total elapsed time: ".$v->getTotalElapsedTime()."<br />";
			echo "Attendance: ".$v->getAttendance()."<br />";
			echo "Temperature: ".$v->getTemperature()."<br />";
			echo "Wind: ".$v->getWind()."<br />";
			echo "Weather: ".$v->getWeather()."<br />";
			echo "</td><td>";
			echo "Referee: ".$v->getReferee()."<br />";
			echo "Umpire: ".$v->getUmpire()."<br />";
			echo "Linesman: ".$v->getLinesman()."<br />";
			echo "Line judge: ".$v->getLineJudge()."<br />";
			echo "Back judge: ".$v->getBackJudge()."<br />";
			echo "Field judge: ".$v->getFieldJudge()."<br />";
			echo "Side judge: ".$v->getSideJudge()."<br />";
			echo "</td>";
		}
		?>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
</table>

<hr />
<div class="page-list-indicators"></div>
    <center>
	<div id="dash-nav">
		<ul class="dash-nav-list">
			<li><a href="#gamestats" class="dummy gamestats">Game Status</a></li>
			<li><a href="#scoring" class="dummy" onClick="swReset('beg2');swStart('beg2','+');">Scoring Summary</a></li>
			<li><a href="#teamstats" class="dummy">Team Stats</a></li>
			<li><a href="#gamestats" class="dummy offense">Offense</a></li>
			<li><a href="#defense" class="dummy">Defense</a></li>
			<li><a href="#specialteams" class="dummy">Special Teams</a></li>
			<li><a href="#drivetracker" class="dummy">Drive Tracker</a></li>
			<li><a href="#dashplaybyplay" class="dummy">Play By Play</a></li>
			<!-- swReset(id), swStart(id, '+'), swStop(id) -->
			<li><table cellpadding="0" cellspacing="0" style="margin-top:-2px"><tr>
			<td valign="top" style="padding-right:10px;">
			<div id="refreshbutton"><input type="button" value="Refresh" style="padding: 4px 4px 4px 4px;border:none;background:#E0AA0F;color:#000000;font-weight:bold;cursor:pointer;text-decoration:none;font-family:helvetica;font-size:1em" onClick="doPageUpdate();"><div>
			</td><td>
			<div id="dashtimer" style="font-weight:bold;padding-right:5px;">Time Since Last Refresh: </div></td><td><div id="beg2" style="font-weight:bold">00:00:00:000</div></td>
			</tr></table>
			</li>
		</ul>
	</div>
    </center>

<br />
<br />


<div id="wrapper">
		<div id="gamestats" class="page" data-role="page" data-scroll="y">
			<?php
				include 'gamestats.php';
			?>
		</div>
		<div id="scoring" class="page" data-role="page"  data-scroll="y">
			<?php include 'scoring.php' ?>
		</div>
		<div id="teamstats" data-role="page"  data-scroll="y">
			<?php
				include 'teamstats.php';
			?>
		</div>
		<div id="offense" data-role="page"  data-scroll="y">
			<?php
				include 'gamestats.php';
			?>
		</div>
		<div id="defense" data-role="page"  data-scroll="y">
			<?php
				include 'defense.php';
			?>
		</div>
		<div id="specialteams" data-role="page"  data-scroll="y">
			<?php
				include 'specialteams.php';
			?>
		</div>
		<div id="drivetracker" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/drivetracker.php';
			?>
		</div>
		<div id="dashplaybyplay" data-role="page"  data-scroll="y">
			<?php
				include 'playbyplay.php';
			?>
		</div>
		<div id="button" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/button.php';
			?>
		</div>
		
		<div id="drivetrackerQT1" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/drivetrackerQT1.php';
			?>
		</div>
		<div id="drivetrackerQT2" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/drivetrackerQT2.php';
			?>
		</div>
		<div id="drivetrackerQT3" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/drivetrackerQT3.php';
			?>
		</div>
		<div id="drivetrackerQT4" data-role="page"  data-scroll="y">
			<?php
				include '../iphone/pages/drivetrackerQT4.php';
			?>
		</div>

		<!--
		<div id="otherscores" data-role="page"  data-scroll="y">
			<ul>
				<li>Other Scores</li>
			</ul>
		</div>
		<div id="weather" data-role="page"  data-scroll="y">
			<ul>
				<li>Weather</li>
			</ul>
		</div>
		<div id="askthecoach" data-role="page"  data-scroll="y">
			<ul>
				<li>Ask the Coach</li>
			</ul>
		</div>
		<div id="concessions" data-role="page"  data-scroll="y">
			<ul>
				<li>Concessions</li>
			</ul>
		</div>
		<div id="tugofwar" data-role="page"  data-scroll="y">
			<ul>
				<li>Tug Of War</li>
			</ul>
		</div>
		-->
	</div>
	
	<div id="menu-cont" class="hidden">
		
		<div id="menu" >
		  <div id="menu-content" data-scroll="y">
		  <ul data-role="listview" data-theme="g">
		  	<li class="homepageitem">
		  		<a href="#homepage">
		  			Homepage
		  		</a>
		  	</li>
		  	<li class="playbyplayitem">
		  		<a href="#playbyplay">
		  			Play By Play
		  		</a>
		  	</li>
		  	<li class="statsitem">
		  		<a href="#stats">
		  			Stats
		  		</a>
		  	</li>
		  	<li class="drivetrackeritem">
		  		<a href="#drivetracker">
		  			Drive Tracker
		  		</a>
		  	</li>

		  	<!--
		  	<li class="otherscoresitem">
		  		<a href="#otherscores">
		  			Other Scores
		  		</a>
		  	</li>
		  	-->
		  	<!--
		  	<li class="weatheritem">
		  		<a href="#weather">
		  			Weather
		  		</a>
		  	</li>
		  	<li class="askthecoachitem">
		  		<a href="#askthecoach">
		  			Ask the Coach
		  		</a>
		  	</li>
		  	<li class="concessionsitem">
		  		<a href="#concessions">
		  			Concessions
		  		</a>
		  	</li>
		  	<li class="tugofwaritem">
		  		<a href="#tugofwar">
		  			Tug of War
		  		</a>
		  	</li>
		  	-->
		  </ul>
		  </div>
		</div>
	</div>






</body>


</html>
