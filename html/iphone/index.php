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
$s = new Setup();
$s->loadCurrent();
$p = new Page("mobile", "public", "page_index_iphone");
if (isset($_REQUEST['gameid'])) {
    $gameid = $_REQUEST['gameid'];
} else 
	$gameid = $s->getActiveGameID();

$game = new Game($gameid);

$homeid = $game->getTeamID();
$awayid = $game->getVisitorID();
$home = new Team($homeid);
$away = new Team($awayid);

$homeacrnym = $home->getAcronym();
$awayacrnym = $away->getAcronym();

$homelogo = '/images/team_logos/'.$home->getLogoPath();
$awaylogo = '/images/team_logos/'.$away->getLogoPath();

$gt = new GameTotal();
$x = $gt->findGameTotalsByGameID($game->getID(), true);

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
<link rel="apple-touch-icon" href="/GT_logo_small.gif" />
<link rel="apple-touch-startup-image" href="images/background.png" />
<title>eStadium: Georgia Tech</title>

<link rel="stylesheet" href="lib/jquery.mobile.scrollview.css"/>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
<link rel="stylesheet" href="style.css"/>

<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>-->

<?php
$scroll="no";
if ($scroll=="no")
	echo "<link rel=\"stylesheet\" href=\"noscroll.css\"/>\n";
else
	echo "<link rel=\"stylesheet\" href=\"scroll.css\"/>\n";

?>

<link rel="stylesheet" href="homepage.css"/>

<script src="http://code.jquery.com/jquery-1.5.js"></script>
<script type="text/javascript" src="src.js"></script>

<script>
	$(document).bind("mobileinit", function(){
	  //apply overrides here
	  console.log("mobileinit");
	  //setTimeout(function(){$.mobile.selectmenu.prototype.options.nativeMenu = true;},0);
	  //$.mobile.autoInitialize = false;
	});
</script>
<script type="text/javascript" src="lib/modernizr-1.7.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>

<script type="text/javascript" src="lib/jquery.easing.1.3.js"></script>
<?php
if ($scroll!="no")
    echo '<script type="text/javascript" src="lib/jquery.mobile.scrollview.js"></script>';
?>

<script type="text/javascript">
	var server_name = "<?=$path->getWebRoot();?>";
	server_name=server_name.substring(0,server_name.length-1);
</script>

<script type="text/javascript" src="scripts/videos.js"></script>
<script type="text/javascript" src="scripts/main.js"></script>
<script type="text/javascript" src="scripts/drivetracker.js"></script>
<script type="text/javascript" src="scripts/stats.js"></script>
<script type="text/javascript" src="scripts/playbyplay.js"></script>

<link href="/GT_logo_small.gif" type="image/x-icon" rel="Shortcut Icon">
<script type="text/javascript">

$(function(){
/*
	$("#iphone-nav li a").click(function(){
		$(this).css("background-color","white");
		$(this).css("color","black");
		$(this).css("text-shadow","none");
		$(this).css("text-decoration","none");
	});
*/

$("iphone-nav-2 td").click(function(){

	window.location=$(this).find("a").attr("href"); 
	return false;
});

</script>
</head>
<body>
    <!--For Google Analytics: Refer to Eugene for more info-->
    <?php include_once("analyticstracking.php") ?>
<div id="content">
                       <!-- <div class="ehire-ad">
                                <a href="http://drishopper-ep.com/">
                                <img class="ipad-icon" src="ad/ipad.png" width="32" height="40"/>
                                Win an iPad from eHire
                                <img class="ehire-logo" src="ad/ehirelogo.png" width="32" height="32"/>
                                </a>
                        </div>-->
	<div id="header">eStadium</div>
	<div id="footer">
		<div id="footer-top">
			<!--<div class="goleft pagetrans">-->
			<!--	<a href="#homepage">&#9664</a>-->
			<!--</div>-->
			<!--<div class="footcenter">-->
		
				<div class="foot-top-pages">
				    <div align="center">
				<table id="iphone-nav-2">
				<tr>
				<td><a href="#homepage">Home</a></td>
				<td><a href="#playbyplay">Play By Play</a></td>
				<td><a href="#stats">Stats</a></td>
				<td><a href="#drivetracker">Drive Tracker</a></td>
				</table>
				</div>
				</div>
			<!--</div>-->
			<!--<div class="goright pagetrans">-->
			<!--	<a href="#playbyplay">&#9654</a>-->
			<!--</div>	-->
</div>
		<div id="footer-bottom">
			<div class="home">
					<div class="home-score"><?=$homescore;?></div>
					<image class="home-logo" width="32" height="32"  src="<?=$homelogo;?>"/>
					<image class="possession hidden" width="16" height="16" src="/images/PossessionIcon.png"/>
			</div>
			<div class="game-period">
				<div class="game-quarter"></div>
				<div class="game-time"></div>
			</div>
			<div class="away">
				<image class="possession hidden" width="16" height="16" src="/images/PossessionIcon.png"/>
				<image class="away-logo" width="32" height="32" src="<?=$awaylogo;?>"/>
				
				<div class="away-score"><?=$awayscore;?></div>	
			</div>
		</div>
	</div>

	<div id="wrapper">
		<div id="homepage" class="page" data-role="page" data-scroll="y">
			<?php
				include 'pages/homepage.php';
			?>
		</div>
		<div id="playbyplay" class="page" data-role="page"  data-scroll="y">
			<?php include 'pages/playbyplay.php' ?>
		</div>
		<div id="stats" data-role="page"  data-scroll="y">
			<?php
				include 'pages/stats.php';
			?>
		</div>
		<div id="drivetracker" data-role="page"  data-scroll="y">
			<?php
				include 'pages/drivetracker.php';
			?>
		</div>
		<div id="button" data-role="page"  data-scroll="y">
			<?php
				include 'pages/button.php';
			?>
		</div>
		
		<div id="drivetrackerQT1" data-role="page"  data-scroll="y">
			<?php
				include 'pages/drivetrackerQT1.php';
			?>
		</div>
		<div id="drivetrackerQT2" data-role="page"  data-scroll="y">
			<?php
				include 'pages/drivetrackerQT2.php';
			?>
		</div>
		<div id="drivetrackerQT3" data-role="page"  data-scroll="y">
			<?php
				include 'pages/drivetrackerQT3.php';
			?>
		</div>
		<div id="drivetrackerQT4" data-role="page"  data-scroll="y">
			<?php
				include 'pages/drivetrackerQT4.php';
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
	
	<?php
	  if ($scroll=="yes"){
	    include("drivedetails.php");
	  }
	?>
	
	<div id="video-layer" class="hidden">
	   <button id="video-close">
	       X
	   </button>
	</div>
</div>
</body>
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
</html>
