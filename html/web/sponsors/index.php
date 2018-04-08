<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("web", "public", "page_web_sponsors");

$p->startTemplate();
?>

<table  align=center cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td>
      <center><br><h1>Thank you to our sponsors!</h1></center>
      <hr>
      <center><br><h1><u>Black and Gold Partners</u></h1></center>
      <table cellpadding=10 border=0 width=60% align=center><tr><td>
        <center><a href="http://www.motorola.com">
        <img src="<?=$path->getPath("image_motorola_logo")?>"><br>
        Motorola</a></center></td><td>
        Motorola has donated equipment and worked closely with eStadium&#153;
        team to develop a Rich Immersive Sports Experience (RISE).  Motorola became 
        a Black and Gold partner in Fall 2007.</td></tr><tr><td>

        <center><a href="http://www.verizon.com">
        <img src="<?=$path->getPath("image_verizon_logo")?>"><br>
        Verizon</a></center></td><td>
        Verizon is a current eStadium&#153; Black and Gold partner,
        providing support from 2005-2008.</td></tr>

     </table>
     <hr>
     <center><br><h1><u>Foundations</u></h1></center>
       <table cellpadding=10 border=0 width=60% align=center><tr><td>
         <center><a href="http://www.motorola.com/giving">
         <img src="<?=$path->getPath("image_motorola_logo")?>"><br>
         Motorola Foundation</a></center></td><td>
         The Motorola Foundation supports eStadium through <a href="http://cwsaweb.ecn.purdue.edu/">CWSA</a>'s
         <a href="http://cobweb.ecn.purdue.edu/~vip/">Vertically Integrated Projects (VIP)</a> Program, an 
         innovative approach to undergraduate and graduate research and education.
         </td></tr>
       </table>
        
     <hr>
     <center><br><h1><u>Corporate Supporters</u></h1></center>
      <table cellpadding=10 border=0 width=60% align=center><tr><td>
        <center><a href="http://www.cisco.com">
        <img src="<?=$path->getPath("image_cisco_logo")?>"><br>
        Cisco</a></center></td><td>
        Cisco was the first eStadium&#153; Black and Gold partner.
        Their support helped launch the project in
        2001.</td></tr><tr><td>

        <center><a href="http://www.raytheon.com">
        <img src="<?=$path->getPath("image_raytheon_logo")?>"><br>
        Raytheon</a></center></td><td>
        Raytheon has provided funding for the eStadium&#153; Cognitive Radio
        sub-team through the <a href="http://www.serc.net/web/index.asp">Software Engineering Research Center (SERC)</a>.</td></tr><tr><td>

        <center><a href="http://www.hp.com">
        <img src="<?=$path->getPath("image_hp_logo")?>"><br>
        Hewlett-Packard</a></center></td><td>
        Hewlett-Packard donated 15 PDA's for fan use during the IU game
        last season.</td></tr><tr><td>
        
        <center><a href="http://www.intel.com">
        <img src="<?=$path->getPath("image_intel_logo")?>"><br>
        Intel</a></center></td><td>
        Intel donated the initial set of 65 PDA's for the eStadium&#153; project
        for research and fan use.</td></tr>
      </table>
    </td>
  </tr>
</table>
<br><br>
<?
$p->close();
?>
