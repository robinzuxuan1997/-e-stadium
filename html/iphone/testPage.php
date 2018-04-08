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

    foreach ($x as $a)
    {
	if ($a->getTeamID() == $game->getTeamID()) 
        {
            $homescore = $a->getFinalScore();
            $home1Q = $a->getScoreFirstQ() >= 0 ? $a->getScoreFirstQ() : 0;
            $home2Q = $a->getScoreSecondQ() >= 0 ? $a->getScoreSecondQ() : 0;
            $home3Q = $a->getScoreThirdQ() >=0 ? $a->getScoreThirdQ() : 0;
            $home4Q = $a->getScoreFourthQ() >=0 ? $a->getScoreFourthQ() : 0;
            $home5Q = $homescore - ($home4Q + $home3Q + $home2Q + $home1Q);
	}
	elseif ($a->getTeamID() == $game->getVisitorID())
        {
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

<!DOCTYPE html> 
<html> 
    <head> 
	<title>eStadium: Georgia Tech</title> 
	<meta name="viewport" cntent="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0-rc.1/jquery.mobile-1.2.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0-rc.1/jquery.mobile-1.2.0-rc.1.min.js"></script>
        
        <script>
            $(document).bind("mobileinit", function(){
            //apply overrides here
            console.log("mobileinit");
            //setTimeout(function(){$.mobile.selectmenu.prototype.options.nativeMenu = true;},0);
            //$.mobile.autoInitialize = false;
            });
        </script>
        
        <script type="text/javascript">
            var server_name = "<?=$path->getWebRoot();?>";
            server_name=server_name.substring(0,server_name.length-1);
        </script>
        <script type="text/javascript" src="scripts/videos.js"></script>
        <script type="text/javascript" src="scripts/main.js"></script>
        <script type="text/javascript" src="scripts/drivetracker.js"></script>
        <script type="text/javascript" src="scripts/stats.js"></script>
        <script type="text/javascript" src="scripts/playbyplay.js"></script>
        <script type="text/javascript" src="src.js"></script>
        <link rel="stylesheet" href="homepage.css"/>
        <link rel="stylesheet" href="style.css"/>
        <link href="/GT_logo_small.gif" type="image/x-icon" rel="Shortcut Icon">
       
        <?php
            if ($scroll!="no")
                echo '<script type="text/javascript" src="lib/jquery.mobile.scrollview.js"></script>';
        ?>
    </head>
    <body>
        <div id="content">
            write something
            <div id="header">eStadium</div>
                <div class="ehire-ad">
                    <a href="http://www.ehire.com">
                        <img class="ipad-icon" src="ad/ipad.png" width="32" height="40"/>
                        Win an iPad from eHire
                        <img class="ehire-logo" src="ad/ehirelogo.png" width="32" height="32"/>
                    </a>
                </div>
            <div id="footer">
		<div id="footer-top">
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
			<?php
                            include 'pages/playbyplay.php'
                        ?>
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
<!--            <div data-role="page">
                    <div data-role="header">
                        <h1>My Title</h1>
                    </div>
                    <div data-role="content">	
                        <p>Hello world</p>		
                    </div>
                </div>-->
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