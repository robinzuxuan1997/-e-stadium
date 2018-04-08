<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_web_news");

$p->startTemplate();
?>

<table  cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
      <p class="about-title">e-Stadium News</p>
      <p> <a href="http://opinion.latimes.com/bitplayer/2007/09/purdues-connect.html"> Purdue's connected football field </a> <br>
      <span class="new-source"> Los Angeles Times </span></p>
      <p> <a href="http://www.usatoday.com/sports/columnist/hiestand-tv/2007-09-27-sports-on-tv_N.htm?csp=34&loc=interstitialskip"> Purdue dials up replays (last section) </a> <br>
      <span class="new-source"> USA Today </span></p>
      <p><a href="http://blog.wired.com/underwire/2007/09/purdue-geeks-ou.html"> Purdue Geeks Out its Football Stadium </a> <br>
      <span class="new-source"> Wired Blog Network </span></p>
      <p><a href="http://www.outlookseries.com/news/Science/1985.htm"> eStadium Football Replays</a> <br>
      <span class="new-source"> Outlook Series.com </span></p>
      <p> <a href="http://www.insideindianabusiness.com/newsitem.asp?id=25659"> Football Fans Can Use Cell Phones to See Replays </a><br>
      <span class="new-source"> Inside INdiana Business </span></p>
      <p><a href="http://news.uns.purdue.edu/x/2007b/070926KrogmeierEstadium.html"> Purdue fans dial up football replays on cell phones </a> <br>
      <span class="new-source"> news.purdue.edu </span> </p>
      <p><a href="<?=$path->getPath("page_news_mid_2006")?>" target="_blank">eStadium Expands Wireless Connectivity</a><br/></p>
      <p><a href="http://purduesports.collegesports.com/genrel/093005aad.html" target="_blank">The game in the palm of your hands</a><br/>
      <span class="new-source">PurdueSports.com</span> </p>
      <!--
      <p><a href="http://www.forbes.com/2003/11/03/1103purduepinnacor_print.html" target="_blank">Wireless system hailed as model</a><br/>
      <span class="new-source">Forbes.com</span> </p>
      <p><a href="http://www.stadia.tv/archive/user/archive_article.tpl?id=20040728165331" target="_blank">Ross-Ade called 'seat of learning'</a><br/>
      <span class="new-source">Stadia Magazine</span> </p>
      <p><a href="http://news.uns.purdue.edu/UNS/html4ever/030906.Bottum.eathletics.html" target="_blank">Cisco gift to help support wireless prototype</a><br/>
      <span class="new-source">Purdue News Service</span> </p>
      <p><a href="http://www.purdueexponent.org/interface/bebop/showstory.php?date=2003/09/30&section=features&storyid=estadium" target="_blank">Early trials promising for 'interactive game program'</a><br/>
      <span class="new-source">The Purdue Exponent</span> </p>
      <p><a href="http://www.siggraph.org/s2005/main.php?f=conference&p=web&s=application&PHPSESSID=3b9a97ad56881ea00727ea7220888fab#estadium" title="e-Stadium presented at SIGGRAPH 2005" target="_blank">e-Stadium presented at SIGGRAPH 2005</a></p>
     -->
    </td>
    <td valign="top">
      <p class="about-title"> eStadium@Jeff </p>
        <p><a href="<?=$path->getPath("page_news_jeff_booster");?>"> Jeff Students Lead the Nation with new eStadium project </a><br>
        <span class="new-source"> Jefferson High School Booster </span></p>
        <p><a href="http://web.mac.com/jacklinkproductions/eStadium@Jeff_Podcast/Podcast/Entries/2007/9/8_eStadium%40Jeff_The_Movie.html"> eStadium@Jeff The Movie (First Game) </a> <br>
        <span class="new-source"> Jacklink Productions </span></p>
        <p><a href="<?=$path->getPath("page_news_jeff_tv_18_1")?>"> High-Tech Bronchos Launch eStadium </a><br>
        <span class="new-source"> WLFI TV18 </span> </p>
        <p><a href="http://web.mac.com/jacklinkproductions/eStadium@Jeff_Podcast/Podcast/Entries/2007/8/31_eStadium%40Jeff_on_FOX_59.html"> eStadium@Jeff on Fox59 </a><br>
        <span class="new-source"> FOX 59 Indianapolis </span></p>
        <p><a href="<?=$path->getPath("page_news_jeff_purdue")?>"> Jeff Football Fans to witness wireless first </a><br>
        <span class="new-source"> Purdue University News Service </span></p>
        <p><a href="http://web.mac.com/jacklinkproductions/eStadium@Jeff_Podcast/Podcast/Entries/2007/8/21_National_eSchool_News_Report.html"> eStadium makes school sports more interactive </a><br>
        <span class="new-source"> eSchool News Online </span></p>
        <p><a href="http://web.mac.com/jacklinkproductions/eStadium@Jeff_Podcast/Podcast/Entries/2007/8/10_eStadium%E2%80%99s_First_Try!.html"> eStadium@Jeff's First Try! </a><br>
        <span class="new-source"> Jacklink Productions </span></p>
        <p><a href="http://web.mac.com/jacklinkproductions/eStadium@Jeff_Podcast/Podcast/Entries/2007/8/10_eStadium%40Jeff_on_News_Channel_TV18.html"> Jeff Students Launch eStadium@Jeff </a><br>
        <span class="new-source"> WLFI TV18 </span></p>
        <p>For more information on eStadium@Jeff, please visit: 
          <a href="http://jeff.ecn.purdue.edu"> http://www.estadiumjeff.com </a> </p>
    </td>
  </tr>
</table>
<br><br>
<?
$p->close();
?>
