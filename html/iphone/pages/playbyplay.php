<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
    </head>
	<body>-->
		<div id="playbyplay-quarter">
		<span id="quarter-label">Quarter:</span>
	<select onchange="playsScript.changeQuarter()" id="quarter-choices"
		 data-native-menu="true">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>
	
	<span class="toggle-filter">
		<div onclick="playsScript.showFilters()" data-role="button">Filter</div>
	</span>
</div>
<div id="playbyplay-filter" hide>
	<table>
		<tr>
			<td>Type:</td>
			<td class="playbyplay-filter-cols">
				<select onchange="playsScript.changeVideosFilter()" id="playbyplay_filters" data-native-menu="true">
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
				<div class="search-btn"  data-role="button"
					onclick="playsScript.searchByType(event)">Search</div>
			</td>
		</tr>
		<tr>
			<td>Player:</td>
			<td class="playbyplay-filter-cols">
				<select id="playbyplay_players" data-native-menu="true">
					
				</select>
			</td>
			<td>
				<div class="search-btn" data-role="button"
					onclick="playsScript.searchPlayer(event)">Search</div>
			</td>
		</tr>
	</table>
</div>
<div id="playbyplayContent"></div>
<!--	</body>
</html>-->