<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_news_mid_2006");

$p->startTemplate();
?>
<br>
<h3>eStadium Expands Wireless Connectivity</h3>
<h5>The eStadium project at Purdue University moves forward.</h5>
<hr>

<p>
The eStadium project at Purdue University has recently entered a period of rapid expansion.
Increased wireless coverage, a focus on new wireless devices, additional contant, as well 
as improvements and additions to the current application have had a net effect of moving 
the project forward at a rapid pace.  
</p>

<p>
A new wireless device manufatured by the <i>Vivato</i> corporation has recently been installed
on the north end of Ross-Ade stadium, facing the parking lot.  The Vivato system has the 
capability of serving large amounts of bandwidth to any 802.11b-capable wireless device in 
the north parking lot as well as some areas of the golf course nearby.  It consists of
13 independent 802.11b access points each tied to a separate narrow-beam, high-gain
antenna capable of communication up to 4 Km (according to the manufacturer).  
Pre-game tailgaters and other fans can use their laptop or PDA to access all of the 
exciting new videos and other content in the eStadium application.
</p>

<p>
The recent advent of data delivery services over cellular networks and increased use and capability
of smart phones now enables Purdue football fans to access the eStadium application on their
personal phone.  Simply direct your phone's browser to 
<a href="http://estadium.purdue.edu/mobile">http://estadium.purdue.edu</a> to access the eStadium
application.  The only restriction to accessing content through your phone is that videos
are not available to phones until after midnight of game day due to copyright issues.
</p>

<p>
Recently, new video and application content has been added to the real-time, on-demand instant replay 
videos that fans have enjoyed in the past.  eStadium users now have the ability to view multiple camera 
angles of selected plays.  Video of starting line-ups, Coach Tiller's weekly show, and other Purdue
football videos have been added to enhance the eStadium experience not just during the game, but 
pre- and post-game as well.  Questions submitted to the popular new "Ask the Coach" application 
that are answered on Coach Tiller's weekly show are highlighted as "eStadium Answers" videos as
well.
</p>

<p>
The staff and students associated with the eStadium project are working feverishly to further expand
eStadium's capabilities.  New ideas involving sensor networks, media delivery, and wireless networking
are driving new research and development that will continue to keep eStadium successful and unique.
</p>
<br><br>
<?
$p->close();
?>

