<?
include_once(realpath(dirname(__FILE__) . "/../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_index");

$p->startTemplate();
?>
<table width="100%" bgcolor="#333333" border=0>
  <tr>
    <td>
      <br>
      <center>
      <table width="95%" bgcolor="#333333" cellpadding="0" cellspacing="0" border=0 class="maincontent">
        <tr>
          <td width="5px"></td>
          <td colspan=3></td>
          <td width="5px"></td>
        </tr><tr valign="top">
          <td></td>
          <td class="feature" rowspan="2">
            <img src="<?=$path->getPath('image_main_image2')?>" width="465" height="280" alt="Curtis Painter" border="0" />
          </td>
          <td width="10"></td>
          <td class="news" >
            <table cellpadding="0" cellspacing="0" class="box">
              <tr>
                <td class="round_topleft"></td>
                <td class="box_top_bottom"></td>
                <td class="round_topright"></td>
              </tr><tr>
                <td class="box_side"></td>
                <td class="box_center">
                  <table cellpadding="0" cellspacing="0">
                    <tr>
                      <td id="heading"></td>
                    </tr><tr>
                      <td height="5"></td>
                    </tr><tr>
                      <td>
                        <p><a href="<?=$path->getLinkPath("page_cottonbowl_index")?>">eStadium runs at the Cotton Bowl</a> <br>
                        <span class="new-source"></span></p>
                        <p> <a href="<?=$path->getWebPath("page_news_la_times")?>"> Purdue's connected football field  </a> <br>
                        <span class="new-source"> LA Times </span></p>
                        <p> <a href="<?=$path->getWebPath("page_news_usa_today")?>"> Purdue dials up replays (last section) </a> <br>
                        <span class="new-source"> USA Today </span></p>
                        <p><a href="<?=$path->getWebPath("page_news_wired")?>"> Purdue Geeks Out its Football Stadium </a> <br>
                        <span class="new-source"> Wired Blog Network </span></p>
                        <p><a href="<?=$path->getWebPath("page_news_outlook_series")?>"> eStadium Football Replays</a> <br>
                        <span class="new-source"> Outlook Series.com </span></p>
                        <p><a href="<?=$path->getWebPath("page_news_exponent_9-07")?>"> Purdue fans dial up football replays on cell phones </a> <br>
                        <span class="new-source"> news.purdue.edu </span> </p>
                        <center><a href="<?=$path->getPath("page_web_news")?>">More News</a></center>
                      </td>
                    </tr>
                  </table>
                </td>
                <td class="box_side"></td>
              </tr><tr>
                <td class="round_bottomleft"></td>
                <td class="box_top_bottom"></td>
                <td class="round_bottomright"></td>
              </tr>
            </table>
          </td>
          <td width="5px"></td>
         </tr><tr>
          <td></td>
          <td colspan="1"></td>
          <td width="5px"></td>
        </tr><tr>
          <td></td>
          <td colspan="3" height="6"></td>
          <td width="5px"></td>
        </tr><tr>
          <td></td>
          <td class="textblock" colspan=3>
            <table cellpadding="0" cellspacing="0" id="about_box">
              <tr>
                <td class="round_topleft"></td>
                <td class="box_top_bottom"></td>
                <td class="round_topright"></td>
              </tr><tr>
                <td class="box_side"></td>
                <td id="about-text" class="box_center">
                  <div class="about-title">What is e-Stadium?</div>
                  <p>
                  <img src="<?=$path->getPath('image_pda_hand')?>" align=right> 
                    "Purdue's eStadium is believed to be the first service to offer access to instant replays on cell phones, as well as other features that will make the game-day experience more interactive for fans in the stands. The service is available at no charge to those attending football games at Purdue's Ross-Ade Stadium."
                    <br/>
                    --Steve Tally, Purdue News Service
                    <br/>
                    <br/>
                    "Real-time statistics. Player information. Scores from other games. A food locater. New features this year include letting fans see replays from multiple camera angles, vote for the game's MVP and submit questions to Purdue's football coach for him to answer on his postgame show. One can only imagine what sort of interactivity might come next, as Purdue pushes the boundaries of what fans can do in the bleachers "
                    <br/>
                    --Jon Healey, L.A. Times <br/>
                    <br/>
                    "Purdue University's eStadium is revolutionizing football games just like TiVo revolutionized TV-watching habits. All Boilermaker fans need to do is head to the home games with cell phoneâand foam fingerâin hand."
                    <br/>
                    -- Miyoko Ohtake, Wired Blog Network
                    <br/>
                    <br/>
                    
                   
                      
                </td>
                <td class="box_side"></td>
              </tr><tr>
                <td class="round_bottomleft"></td>
                <td class="box_top_bottom"></td>
                <td class="round_bottomright"></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </center>
    </td>
  </tr><tr>
    <td colspan=5><br><br></td>
  </tr>
</table>
<?
$p->close();
?>
