<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_about");

$p->startTemplate();
?>
<center>
  <font class="mobile_h1"><u>eStadium</u><br></font>
  <i>"A Living Lab"</i><br>
</center>

<p>As a Yellow Jacket football fan at Bobby Dodd Stadium you will be able to enjoy 
up-to-the-minute statistics, player and coach biographies, and other wireless 
"infotainment" using our personal digital assistants (PDAs) while cheering on 
the Jackets. The prototype, known as e-Stadium, is a partnership among the Office of Information Technology (OIT), 
Georgia Tech's Arbutus Center, 
and the Georgia Tech Athletic Association.</p>

<p>eStadium is part of Georgia Tech's "Living Lab". Traditionally, a laboratory is a
room or building equipped for scientific experimentation, research, or learning.
To facilitate "real world" learning, Georgia Tech has created the concept
of the "living laboratory."  The living laboratory uses the "city" of Georgia Tech as a unique environment for experimentation while serving in its 
traditional role. The goal of eStadium is to provide a practical learning 
experience for Georgia Tech students in the analysis, architecture, design, and 
application development for wireless networking technologies.</p>

<?
$p->close();
?>
