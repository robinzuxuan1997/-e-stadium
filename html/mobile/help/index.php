<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_help");

$p->startTemplate();
?>
<center>
  <font class="mobile_h1"><u>PDA Help</u><br></font>
</center>
<a href="#top"></a>

<p><b>Button Explanation</b></p>
<p><img src="<?=$path->getPath("image_help10")?>" border="0">Refresh the page</p>
<p><img src="<?=$path->getPath("image_help11")?>" border="0">Bookmark this page</p>
<p><img src="<?=$path->getPath("image_help12")?>" border="0">Go Back</p>
<p><img src="<?=$path->getPath("image_help13")?>" border="0">Show/Hide graphics</p>
<p><img src="<?=$path->getPath("image_help14")?>" border="0">Go to the e-Stadium Homepage</p>

<p><b>How do I enter text?</b></p>
<p>Look at the bottom right corner of the screen and click on the keyboard icon and</p>
<img src="<?=$path->getPath("image_help00")?>" border="0"><br>
<p>Use your stylus to enter data using the keyboard.</p>
<img src="<?=$path->getPath("image_help01")?>" border="0"><br>

<p><b>I can't see any pictures</b></p>
<p>Click on the "Show/Hide Picture button" as shown in the following picture</p>
<img src="<?=$path->getPath("image_help02")?>" border="0"><br>

<p><b>How do I type a symbol such as "@" that normally is above a number on the keyboard?</b></p>
<p>Using the stylus in keyboard mode, press the Shift button.  All symbols appear in the top row of the keyboard.</p>

<p><b>What should I do when the PDA powers off or goes dim?</b></p>
<p>Tap the screen with the stylus or press the power button.</p>

<p><b>How do you get back to the e-Stadium main page from ESPN?</b></p>
<p>Click on the home button at the bottom of the internet window.</p>

<p align="center"><b><a href="#top">Return to top</a></b></p>

<?
$p->close();
?>
