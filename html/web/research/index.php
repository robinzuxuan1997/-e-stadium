<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_web_research");

$p->startTemplate();
?>
<table width="100%" border=0>
  <tr>
    <td>
      <center>
        <font size="3">
        Providing video replays during games is only a small portion of eStadium. 
        <br>
        This research project is actually made up of several subteams.
        </font>
    </td>
  </tr>
  <tr>
    <td>
      <center>
      <table class="maincontent">
        <tr>
          <th> Research Papers Written </th>
          <td></td>
          <th> Web Applications </th>
        </tr>
        <tr>
          <td width=45%> 
            <table>
              <tr>
                <td> <a href="<?=$path->getWebPath("paper_eStadium")?>"> eStadium: The Mobile Wireless Football Experience </a> <br />
                Aaron Ault, James V. Krogmeier, Steven R. Dunlop, and Edward J. Coyle </td>
              </tr>
              <tr>
                <td> <a href="<?=$path->getWebPath("paper_Sensor_Nets")?>"> Optimizing AES for Embedded Devices and Wireless Sensor Networks </a> <br />
                Shammi Didla, Aaron Ault and Saurabh Bagchi</td>
              </tr>
              <tr> 
                <td> <a href="<?=$path->getWebPath("paper_chinacom")?>">eStadium: a Wireless "Living Lab" for Safety and Infotainment Applications  </a> <br/>
                 Xuan Zhong and Edward J. Coyle</td>
              </tr>
              <tr>
                <td> <a href="<?=$path->getWebPath("paper_Tridentcom")?>"> The Development and eStadium Testbeds for Research and Development of Wireless Services for Large-scale Sports Venues </a> <br />
                Xuan Zhong, Hoi-Ho Chan, Timothy J. Rogers, Catherine P. Rosenberg and Edward J. Coyle</td>
              </tr>
            </table>
          </td>
          <td width=10%></td>
          <td width=45% valign=top> Web Apps provides the content currently available on estadium.purdue.edu.
               This subteam also develops new tools and works to keep all current applications
               up to date and working as fast as possible. This is the "face" of eStadium.</td>
        </tr>
        <tr>
          <td> <br/> </td>
        </tr>
        <tr>
          <th> RISE </th>
          <td> </td>
          <th> Tracking </th>
        </tr>
        <tr>
          <td width=50% valign=top> RISE stands for Rich Immersive Sports Experience. This team is working 
                         with Motorola to create the ultimate sports experience. The goal is to
                           to design a system to push 
                           content to your TV, Phone, and Computer simultaneously</td>
          <td width=10%> </td>
          <td width=50% valign=top> This subteam is workign to creat an accurate indoor tracking system using the MSP430 microcontrollor
                         from Texas Instruments. While GPS works in a large-scale outdoor setting, this team is striving to create
                         a system that can know exactly where a person is located at any given time. This is most useful when applied
                         to locating emergency personnel and avoiding conjested areas</td>
        </tr>
        <tr>
          <td> <br/> </td>
        </tr>
        <tr>
          <th> Cognitive Radios </th>
          <td></td>
          <th> Sensor Networks</th>
        </tr>
        <tr>
          <td valign=top> Cognitive Radios is designing, testing, and installing a wireless access point
               algoritm that automatically switches channels based on wireless interference and 
               access point usage</td>
          <td> </td>
          <td width=45% valign=top> Sensor Nets involves a MSP430 microcontrollor and is working to create a system to 
               sense various things.</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
$p->close();
?>
