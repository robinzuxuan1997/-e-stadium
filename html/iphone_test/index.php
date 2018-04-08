
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
      <head>
            <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
            <title>eStadium: Georgia Tech</title>


            <script src="jqtouch/jqtouch/jquery.1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
            <script src="jqtouch/jqtouch/jqtouch.js" type="application/x-javascript" charset="utf-8"></script>
            <script src="this.js" type="text/javascript" charset="utf-8"></script>

            <link type="text/css" media="screen" rel="stylesheet" href="jqtouch/jqtouch/jqtouch.css" />
            <link type="text/css" media="screen" rel="stylesheet" href="jqtouch/themes/acf1/theme.css" />
            <link type="text/css" media="screen" rel="stylesheet" href="this.css" />
            <link type="text/css" media="screen" rel="stylesheet" href="scoreBorad.css" />
            

            <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojo/dojo.xd.js"></script>
            <script type="text/javascript" src="scoreBoard.js"></script>

      </head>
      <body>

            <!--desrciption of this div needed-->
            <div id="home" class="current">
                  <div class="toolbar">
                        <h1>eStadium</h1>
                        <a class="button slideup" id="infoButton" href="#about">About</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>

                  <ul class="rounded">
                        <li class="arrow"><a href="#videos">Videos</a> <!--<small class="counter">0 new</small>--></li>
                        <li class="arrow"><a href="#statspage">Stats</a></li>
                        <li class="arrow"><a href="#drivetracker" id="drivetrackerlink">Drive Tracker</a></li>
                        <li class="arrow"><a href="#playbyplay">Play by Play</a></li>
                        <li class="arrow"><a href="#otherscores">Other Scores</a></li>
                        <li class="arrow"><a href="#weather">Weather/Radar</a></li>
                  </ul>
                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->

            </div><!--end of home div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="about" class="selectable">
                  <p><strong>eStadium</strong><br />Version 0.2 beta<br />
                        <a href="http://www.estadium.gatech.edu">By the eStadium VIP team</a></p>
                  <p><em>All the game information<br /> for football fans!</em></p>
                  <p>With eStadium, you can watch instant replays, track live statistics, and more,
                        all from your mobile device!</p>
                  <p><br /><br /><a href="#" class="grayButton goback">Close</a></p>
                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of about div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="videos">
                  <div class="toolbar">
                        <h1>Videos</h1>
                        <a class="back" href="#home">Home</a>
                        <a class="button flip" id="saveButton" href="#videotype">settings</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>
             
                  <div id="videos_content">
                        <center><h2>Videos Highlights</h2> </center>
                  </div>

                  <div>
                        <?php include 'templates/videos.php'; ?>
                  </div>
                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->


            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="videotype">
                  <div class="toolbar">
                        <h1>Video Type</h1>
                        <a class="back" href="#videos" id="saveVideoSettings">Save</a>
                  </div>

                  <form action="">
                        <ul class="edit rounded">
                              <li><input type="radio" name="videotype" value="dmmp4" title="Download, Mobile mp4"/></li>
                              <li><input type="radio" name="videotype" value="ds3gp" title="Download, Small 3gp"/></li>
                              <li><input type="radio" name="videotype" value="dpcmp4"title="Download, PC mp4"/></li>
                              <li><input type="radio" name="videotype" value="dsmp4" title="Download, Small mp4"/></li>
                              <li><input type="radio" name="videotype" value="dm3gp" title="Download, Mobile 3gp"/></li>
                              <li><input type="radio" name="videotype" value="smmp4" title="Stream, Mobile mp4"/></li>
                              <li><input type="radio" name="videotype" value="ss3gp" title="Stream, Small 3gp"/></li>
                              <li><input type="radio" name="videotype" value="ssmp4" title="Stream, Small mp4"/></li>
                              <li><input type="radio" name="videotype" value="sm3gp" title="Stream, Mobile 3gp"/></li>
                        </ul>
                  </form>
            </div><!--end of videotype div-->
            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="statspage">
                  <div class="toolbar">
                        <h1>Stats</h1>
                        <a class="back" href="#home">Home</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>

                  <div id="statscontent">
                        <ul class="rounded">
                              <li class="forward"><a class="dissolve" href="#gtplayerstats"><span class="score_board_home_acronym">GT</span> Player Stats</a></li>
                              <li class="forward"><a class="dissolve" href="#vsplayerstats"><span class="score_board_visitor_acronym">VS</span> Player Stats</a></li>
                        </ul>
                        <div id="statscontentall"></div>
                  </div>
                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="gtplayerstats">
                  <div class="toolbar">
                        <h1><span class="score_board_home_acronym">GT</span> Player Stats</h1>
                        <a class="back" href="#stats">Stats</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>
                  <div id="gtplayerstats_content"></div>

                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of gt player stats div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="vsplayerstats">
                  <div class="toolbar">
                        <h1><span class="score_board_visitor_acronym">VT</span> Player Stats</h1>
                        <a class="back" href="#stats">Stats</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>
                  <div id="vsplayerstats_content"></div>

            </div><!--end of vs player stats div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="drivetracker">
                  <div class="toolbar">
                        <h1>Drive Tracker</h1>
                        <a class="back" href="#home">Home</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>
                  <div id="drivetrackercontent"></div>
                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="playbyplay">
                  <div class="toolbar">
                        <h1>Play by Play</h1>
                        <a class="back" href="#home">Home</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>

                  <div>
                        <?php include 'templates/playbyplay.php'; ?>
                  </div>

                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->

            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="otherscores">
                  <div class="toolbar">
                        <h1>Other Scores</h1>
                        <a class="back" href="#home">Home</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>

      
                  <center><div id="otherscorescontent"></div></center>

                 <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->


            <!--------------------------------------------------------------------------------------------------------------------->

            <!--desrciption of this div needed-->
            <div id="weather">
                  <div class="toolbar">
                        <h1>Weather/Radar</h1>
                        <a class="back" href="#home">Home</a>
                  </div>

                  <?php
                  include 'scoreBoard.php';
                  ?>

                  <center><div id="weathercontent"></div></center>

                  <!-- <div class="info">
                        <a href="http://www.ehire.com/contest/" target="_blank"><img src="http://estadium.gatech.edu/images/ehire.png" alt=""/></a>
                  </div>
                  <div class="info">
                        <p>Add this page to your home screen to view the custom icon, startup screen, and full screen mode.</p>
                  </div> --->
            </div><!--end of videos div-->

      </body>
</html>