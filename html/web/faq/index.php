<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_web_faq");

$p->startTemplate();
?>

<p class="about-title">FAQ</p>
<p>- What is this project about? </p>
  <p>E-Stadium "A Living Lab" is a partnership among ITaP, Purdue's Center for Wireless Systems and Applications, and Intercollegiate Athletics.  To facilitate real world learning, Purdue has created the concept of the "living laboratory."  The living laboratory uses the "city" of Purdue University as a unique environment for experimentation while serving in its traditional role.  The goal of e-Stadium is to provide a practical learning experience for Purdue students in the analysis, architecture, design, and application development for wireless networking technologies.  As a result, Boilermaker football fans participating in the project will enjoy an enhanced fan experience while at Ross-Ade Stadium.</p>
  <p>- What am I able to do with a mobile wireless device? </p>
  <p>Boilermaker football fans will be able to enjoy up-to-the-minute game statistics, player and coach biographies, other game scores, video highlights, trivia, buddy finder/chats, food locator, current weather conditions, and more.</p>
  <p>- How many wireless access points are in the stadium? </p>
  <p>There are currently 15 access points in the pavilion, 4 in the south scoreboard covering the southern half section of the stands, and a Vivato system covering the north parking lot and part of the golf course.</p>
  <p>- What is the coverage of an access point? </p>
  <p>Typical indoor range for an AP will be from 50 to 100 feet, while outdoors a signal can extend up to 100 yards, but this is dependant on many factors. The Vivato system, for instance, is engineered to achieve a range of almost 4 Km.  In most situations, surrounding structural elements will decrease an AP's effective range - intervening walls, floors, or ceilings, for example.  If you are attempting to use a wireless connection in an area where signal strength is weak, moving your device just a few feet may improve your reception dramatically. </p>
  <p>- Can I use my own PDA at a game? </p>
  <p>Yes, as long as the PDA has an 802.11b wireless card installed.</p>
  <p>- What is 802.11b and where can I purchase a card ? </p>
  <p>802.11b is simply the designation for the particular kind of wireless networking protocol. 802.11b is proven, award-winning technology that is widely available on the market today. A card may be purchased at most electronics supply stores for around $50. </p>
  <p>- May I purchase a PDA at the game? </p>
  <p>PDA's are utilized on a voluntary basis each game. None are available for purchase; however, handhelds are available at most major electronics stores. Prices generally start around $200 for base units and vary depending on make, model and features. </p>
  <p>- Why am I unable to go elsewhere on the internet? </p>
  <p>Security has been established to ensure maximum performance. Opening the channels outside the e-Stadium environment would also open the door for someone from the outside to access the application thereby compromising security. </p>
  <p>- May I use email? </p>
  <p>At this time, receiving or sending email is not possible due to the security limitations. </p>
  <p>- Is this the first stadium in the country to mass deploying wireless devices? </p>
  <p>We are unaware of any other university stadiums that are deploying the technology to enhance fan experience. Some of the professional team stadiums are beginning to use wireless technology. The most popular application to date seems to be with concession stands where a waiter/waitress takes a food order at a fans seat, the order is wirelessly transmitted to the vendor stand and another person delivers the order to the fan. </p>
<table cellspacing="5" cellpadding="0">
  <tr>
    <td>
      <table cellspacing="0" cellpadding="0">
        <tr>
          <td width="5" bgcolor="#ffffff"></td>
          <td bgcolor="#ffffff">PDA SpecIfic Questions </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
        
<table cellspacing="0" cellpadding="4">
  <tr>
    <td class="bodyText" valign="top">
      <table cellspacing="0" cellpadding="0">
        <tr>
          <td width="32"><img height="32" src="/eStadImages/sitepic3.jpg" width="32"></td>
          <td width="236">= Go to the e-Stadium home page. </td>
          <td width="32"><img height="32" src="/eStadImages/sitepic5.jpg" width="32"></td>
          <td width="220">= Stop loading a page. </td>
        </tr><tr>
          <td><img height="32" src="/eStadImages/sitepic4.jpg" width="32"></td>
          <td>= Back a page. </td>
          <td><img height="32" src="/eStadImages/sitepic6.jpg" width="32"></td>
          <td>= Refresh the current page. </td>
        </tr>
      </table>
      <p>- How do I turn on the keyboard to enter text? </p>
      <table cellspacing="0" cellpadding="2">
        <tr>
          <td valign="bottom" width="270"><img height="80" src="/eStadImages/sitepic7.jpg" width="160"></td>
          <td valign="bottom" width="20"></td>
          <td valign="bottom" width="230"><img height="92" src="/eStadImages/sitepic8.jpg" width="95"></td>
        </tr><tr>
          <td valign="top">Using the stylus, press the keyboard button in the bottom, right of the screen. </td>
          <td valign="top"></td>
          <td valign="top">Use the stylus to enter data. </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>- How do I type a symbol such as "@" that normally is above a number on the keyboard ? </p>
<p>Using the stylus in keyboard mode, press the ShIft button. All symbols appear in the top row of the keyboard. </p>
<p>- What should I do when the PDA powers off or goes dim? </p>
<p>Tap the screen with the stylus or press the power button. </p>
<p>- How do you get back to the e-Stadium main page from ESPN? </p>
<p>Click on the home button at the bottom of the internet window. </p>
<p>- How do I log in to play trivia? </p>
<p>There are two options. First, clicking on Guest Login does not require an ID or password. When using a guest login, trivia scores will be lost once the Logout button is clicked or the device loses the wireless connection. Second, for those wishing to play trivia in the future and pick up where they previously left off, creating a login is necessary. Click on "Create New Login Name" at the bottom of the login page. Once the login is registered, participants may login using the created name and password. After a login answers a question, the questions will not be repeated. A new login or guest login must be used to start the trivia from the beginning. <br></p>


<?
$p->close();
?>
