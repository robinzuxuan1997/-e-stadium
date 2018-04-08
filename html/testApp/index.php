<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once(realpath(dirname(__FILE__) . "/../../include/Page/class_path.php"));
$path = new Path();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<title>eStadium: Georgia Tech</title>
<script
	src="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojo/dojo.xd.js"
	djConfig="parseOnLoad:true, preventBackButtonFix: false"></script>
<script type="text/javascript">
var server_name = "<?=$path->getWebRoot();?>";
server_name=server_name.substring(0,server_name.length-1);
</script>
<script type="text/javascript" src="main.js"></script>
<script type="text/javascript" src="drivetracker/script.js"></script>
<script type="text/javascript" src="videos/script.js"></script>
<script type="text/javascript" src="stats/script.js"></script>
<script type="text/javascript" src="otherscores/script.js"></script>
<script type="text/javascript" src="playbyplay/script.js"></script>
<script type="text/javascript" src="scoreboard/scoreboard.js"></script>

<link href="/GT_logo_small.gif" type="image/x-icon" rel="Shortcut Icon">

<link rel="apple-touch-icon" href="/GT_logo_small.gif" />
<link rel="apple-touch-startup-image" href="images/background.png" />

<link rel="stylesheet" type="text/css"
	href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dijit/themes/claro/claro.css" />
<link rel="stylesheet" type="text/css" href="main.css" />
<link rel="stylesheet" type="text/css" href="css/iphone_overwrite.css" />

<?php
include_once 'device_detect.php';

echo '<meta name="viewport"
                  content="width=device-width; user-scalable=0; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0;" />';
echo '<meta name="apple-mobile-web-app-capable" content="yes"/>';
echo '<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />';

//if (DeviceDetect::isAndroid()) {
//	echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/android/android.css" />';
//} else {
echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//}
//if (DeviceDetect::isandroid() or DeviceDetect::isipad() or 1) {

//	echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone-app.css" />';

//I comment this out. It seams that the android css is not working as expected for now.
//
//	if (DeviceDetect::isiphone()) {
//		echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//	} else if (DeviceDetect::isipad()) {
//		echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//	} else if (DeviceDetect::isAndroid()) {
//		echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/android/android.css" />';
//	} else {
//		echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//	}
//} else {
//	echo '<link type="text/css" media="screen" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojox/mobile/themes/iphone/iphone.css" />';
//}
//}
?>

<link rel="stylesheet" type="text/css" href="scoreboard/scoreBorad.css" />
</head>
<body class="claro">
<div id="main" dojoType="dojox.mobile.View" selected="true"
	keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading">eStadium sponsored by eHire</h1>
<?php
include 'extras/ehire_promo.php';
?> <?php
include 'scoreboard/scoreBoard.php';
?>
<ul dojoType="dojox.mobile.EdgeToEdgeList">
	<!--<li dojoType="dojox.mobile.ListItem"
		icon="images/main_icons/Home.png" rightText="current view">
	Home</li>-->
	<li dojoType="dojox.mobile.ListItem"
		icon="images/main_icons/Videos.png" moveTo="#videos"
		onClick="loadVideosView(currentQuarter)">Videos</li>
	<li dojoType="dojox.mobile.ListItem" icon="images/main_icons/Stats.png"
		moveTo="#stats" onclick="loadStatsView(currentQuarter)">Stats</li>
	<li dojoType="dojox.mobile.ListItem"
		icon="images/main_icons/DriveTracker.png" moveTo="#drivetracker"
		onclick="loadDriveTrackerView()">Drive Tracker</li>
	<li dojoType="dojox.mobile.ListItem"
		icon="images/main_icons/PlayByPlay.png" moveTo="#playbyplay"
		onclick="loadPlayByPlayView(currentQuarter)">Play By Play</li>
	<li dojoType="dojox.mobile.ListItem"
		icon="images/main_icons/OtherScores.png" moveTo="#otherscores"
		onclick="loadOtherScoresView()">Other Scores</li>
</ul>
<div class="pad_bot"></div>
</div>

<!-------------------------------------------------------------------------------------------->

<div id="videos" dojoType="dojox.mobile.View" keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="home" moveTo="#main">Videos</h1>
<?php
include 'extras/ehire_promo.php';
?> <?php
include 'scoreboard/scoreBoard_small.php';
?>
<div class="pad_bot"></div>
<h3 dojoType="dojox.mobile.RoundRect" id="videos-quarter">Quarter:</h3>
<div dojoType="dojox.mobile.RoundRect" id="videos-filter" hide>
	<table>
		<tr>
			<td>Type:</td>
			<td class="videos-filter-cols">
				<select onchange="videosScript.changeVideosFilter()" id="video_filters">
					<option value="all">All</option>
					<option value="touchdown">Touchdown</option>
					<option value="fieldgoal">Field Goal</option>
					<option value="rush">Rush</option>
					<option value="pass">Pass</option>
					<option value="penalty">Penalty</option>
					<option value="fumble">Fumble</option>
					<option value="interception">Interception</option>
				</select>
			</td>
			<td>
				<li dojoType="dojox.mobile.Button" class="search-btn"
					onclick="videosScript.searchByType(event)">Search</li>
			</td>
		</tr>
		<tr>
			<td>Player:</td>
			<td class="videos-filter-cols">
				<select id="video_players">
					
				</select>
			</td>
			<td>
				<li dojoType="dojox.mobile.Button" class="search-btn" 
					onclick="videosScript.searchPlayer(event)">Search</li>
			</td>
		</tr>
	</table>
</div>
<div id="videosContent"></div>
<div class="pad_bot"></div>
</div>

<!-------------------------------------------------------------------------------------------->


<div id="stats" dojoType="dojox.mobile.View" keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="home" moveTo="#main">Stats</h1>
<?php
include 'extras/ehire_promo.php';
?> <?php
include 'scoreboard/scoreBoard_small.php';
?>
<div class="pad_bot"></div>
<div id="statsContent">
<ul dojoType="dojox.mobile.EdgeToEdgeList">
	<li dojoType="dojox.mobile.RoundRect">
	<ul dojoType="dojox.mobile.EdgeToEdgeList">
		<li dojoType="dojox.mobile.ListItem"
			icon="images/main_icons/Stats.png" moveTo="#visitorplayerstats"
			onclick="loadVisitorPlayerStats()"><span class="score_board_visitor_acronym"></span>
		Players Stats</li>
		<li dojoType="dojox.mobile.ListItem"
			icon="images/main_icons/Stats.png" moveTo="#homeplayerstats"
			onclick="loadHomePlayerStats()"><span class="score_board_home_acronym"></span>
		Players Stats</li>
	</ul>
	<?php include 'stats/stats.php';?></li>
</ul>
</div>
<div class="pad_bot"></div>
</div>

<!--  -->

<div id="visitorplayerstats" dojoType="dojox.mobile.View"
	keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="Stats" moveTo="#stats">Players
Stats</h1>
	<?php
	include 'extras/ehire_promo.php';
	?> <?php
	include 'scoreboard/scoreBoard_small.php';
	?>
<div class="pad_bot"></div>
<div id="statsContent">
<ul dojoType="dojox.mobile.EdgeToEdgeList">
	<li dojoType="dojox.mobile.RoundRect"><?php include 'stats/visitorplayerstats.php';?>
	</li>
</ul>
</div>
<div class="pad_bot"></div>
</div>

<!--  -->

<div id="homeplayerstats" dojoType="dojox.mobile.View"
	keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="Stats" moveTo="#stats">Players
Stats</h1>
	<?php
	include 'extras/ehire_promo.php';
	?> <?php
	include 'scoreboard/scoreBoard_small.php';
	?>
<div class="pad_bot"></div>
<div id="statsContent">
<ul dojoType="dojox.mobile.EdgeToEdgeList">
	<li dojoType="dojox.mobile.RoundRect"><?php include 'stats/homeplayerstats.php';?>
	</li>
</ul>
</div>
<div class="pad_bot"></div>
</div>

<!-------------------------------------------------------------------------------------------->


<div id="drivetracker" dojoType="dojox.mobile.View"
	keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="home" moveTo="#main">Drive
Tracker</h1>
	<?php
	include 'extras/ehire_promo.php';
	?> <?php
	include 'scoreboard/scoreBoard_small.php';
	?>
<div class="pad_bot"></div>
<div id="drivetrackerContent">
<ul dojoType="dojox.mobile.EdgeToEdgeList" id="drivetracker-edgelist">
	<div dojoType="dojox.mobile.RoundRect" id="drivetracker-driveheading">
	<div>
	<div id="drivetracker-drivename"></div>
	<div class="drivetracker-filler"></div>
	<div dojoType="dojox.mobile.Button" class="drivetracker-refresh"
		id="drivetracker-update" onclick="drivetracker.update(event)">Update</div>
	</div>
	<div id="drivetracker-heading-filler">&nbsp;</div>
	</div>
	<div><img id="drvtrkr_img" /></div>
	<li dojoType="dojox.mobile.RoundRect" id="drivetracker-drivelist">
	Choose Drive:<br />
	<select id="drivetracker-drives"
		onchange="drivetracker.driveChanged(event)">
	</select></li>
	<li dojoType="dojox.mobile.RoundRect" id="drivetracker-legend">
	<table>
		<tr>
			<td align="left"><img
				src="<?=$path->getPath("image_drivetracker_legend_rush")?>">&nbsp;Rush<br />
			<img src="<?=$path->getPath("image_drivetracker_legend_pass")?>">&nbsp;Pass<br />
			<img
				src="<?=$path->getPath("image_drivetracker_legend_incomplete")?>">&nbsp;Incomplete
			Pass<br />
			</td>
			<td align="left"><img
				src="<?=$path->getPath("image_drivetracker_legend_penalty")?>">&nbsp;Penalty<br />
			<img src="<?=$path->getPath("image_drivetracker_legend_kickoff")?>">&nbsp;Punt
			or Kickoff<br />
			<img src="<?=$path->getPath("image_drivetracker_legend_fumble")?>">&nbsp;Fumble
			or Interception<br />
			</td>
		</tr>
	</table>

	</li>
</ul>
</div>
<div class="pad_bot"></div>
</div>

<!-------------------------------------------------------------------------------------------->


<div id="playbyplay" dojoType="dojox.mobile.View" keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="home" moveTo="#main">Play By
Play</h1>
	<?php
	include 'extras/ehire_promo.php';
	?> <?php
	include 'scoreboard/scoreBoard_small.php';
	?>
<div class="pad_bot"></div>
<h3 dojoType="dojox.mobile.RoundRect" id="plays-quarter">Quarter:</h3>
<div id="playbyplayContent"></div>
<div class="pad_bot"></div>
</div>

<!-------------------------------------------------------------------------------------------->


<div id="otherscores" dojoType="dojox.mobile.View" keepScrollPos="false">
<h1 dojoType="dojox.mobile.Heading" back="home" moveTo="#main">Other
Games</h1>
	<?php
	include 'extras/ehire_promo.php';
	?> <?php
	include 'scoreboard/scoreBoard_small.php';
	?>
<div class="pad_bot"></div>
<center>
<div id="sportheader">
<div dojoType="dojox.mobile.Button" value="ncf"
	onclick="otherscores.switchSport(event);">NCAAF</div>
<div dojoType="dojox.mobile.Button" value="nfl"
	onclick="otherscores.switchSport(event);">NFL</div>
<div dojoType="dojox.mobile.Button" value="nhl"
	onclick="otherscores.switchSport(event);">NHL</div>
<div dojoType="dojox.mobile.Button" value="nba"
	onclick="otherscores.switchSport(event);">NBA</div>
<div dojoType="dojox.mobile.Button" value="mlb"
	onclick="otherscores.switchSport(event);">MLB</div>
</div>
</center>
<div id="othergamesContent"></div>
<div class="pad_bot"></div>
</div>

</body>
</html>
