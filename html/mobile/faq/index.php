<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_faq");

$p->startTemplate();
?>
<center>
  <font class="mobile_h1"><u>e-Stadium FAQ</u><br></font>
</center>
<a href="#top"></a>

<p><b>What is this project about?</b><br>
E-Stadium "A Living Lab" is a partnership among ITaP (Vice President Jim Bottum), Purdue's Center for Wireless Systems and Applications (directed by Catherine Rosenberg), and Intercollegiate Athletics (Morgan Burke, Athletic Director). To facilitate real world learning, Purdue has created the concept of the "living laboratory." The living laboratory uses the "city" of Purdue University as a unique environment for experimentation while serving in its traditional role. The goal of e-Stadium is to provide a practical learning experience for Purdue students in the analysis, architecture, design, and application development for wireless networking technologies. As a result, Boilermaker football fans participating in the project will enjoy an enhanced fan experience while at Ross-Ade Stadium.</p>

<p><b>What am I able to do with this handheld computer?</b><br>
Boilermaker football fans will be able to enjoy up-to-the-minute game statistics, player and coach biographies, other game scores, trivia, food locator, current weather conditions, and more. Participants will be asked to participate in a brief survey about their enhanced spectator experience.</p>

<p><b>How does wireless technology work?</b><br>
Wireless access points are connected to Purdue's wired network. These wireless access points emanate radio signals in a similar manner to garage door openers and non-cellular cordless phones. The signals are strong enough to be received up to 50 to 100 feet from each access point (and possibly further, if the access point is equipped with an external antenna). These signals can be received by laptops and PDA's that are equipped with a standard 802.11b wireless card.</p>

<p><b>How many access points are in the Pavilion?</b><br>
There are currently 11 access points inside the Pavilion and 4 outside to cover the club seating section. More will be added to the stadium in the future.</p>

<p><b>What is the coverage of an access point?</b><br>
Typical indoor range for an AP will be from 50 to 100 feet, while outdoors a signal can extend up to 100 yards, but this is dependant on many factors. In most situations, surrounding structural elements will decrease an AP's effective rangeâintervening walls, floors, or ceilings between an AP and a user will generally dampen the signal, for example. Conversely, some AP's may be equipped with signal-boosting antennas, which can increase their effective range significantly. If you are attempting to use a wireless connection in an area where signal strength is weak, moving your device just a few feet may improve your reception dramatically.</p>

<p><b>Can I use my own PDA at a game?</b><br>
Yes, as long as the PDA has an 802.11b wireless card installed and either Pocket PC (preferred) or Windows CE operating systems. What is 802.11b and where can I purchase a card?</p>
<br><br>
802.11b is simply the designation for the particular kind of wireless networking protocol. 802.11b is proven, award-winning technology that is widely available on the market today. A card may be purchased at most electronics supply stores for around $50.

<p><b>May I purchase a PDA at the game?</b><br>
PDA's are utilized on a voluntary basis each game. None are available for purchase; however, handhelds are available at most major electronics stores. Prices generally start around $200 for base units and vary depending on make, model and features.</p>

<p><b>Is there/will there be a fee to use the service?</b><br>
None are planned at this time.</p>

<p><b>May I use email?</b><br>
At this time, receiving or sending email is not possible due to the security limitations and liabilities of the e-Stadium project. A chat application is being planned for the future.</p>

<p><b>Why am I unable to go elsewhere on the internet?</b><br>
Security has been established to ensure maximum performance. Opening the channels outside the e-Stadium environment would also open the door for someone from the outside to access the application thereby compromising security.</p>

<p><b>Is this the first stadium in the country to mass deploying wireless devices?</b><br>
We are unaware of any other university stadiums that are deploying the technology to enhance fan experience. Some of the professional team stadiums are beginning to use wireless technology. The most popular application to date seems to be with concession stands where a waiter/waitress takes a food order at a fans seat, the order is wirelessly transmitted to the vendor stand and another person delivers the order to the fan.</p>

<p><b>Will we be able to do this at Purdue?</b><br>
Possibly, there are many future applications for this technology which we will be exploring.</p>

<?
$p->close();
?>
