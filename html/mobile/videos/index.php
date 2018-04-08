<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_boiler_videos");

$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Boiler Video Highlights</u><br><br></font></center>

<ul>
  <li><a class="mainmenu" href="<?=$path->getPath("page_game_videos")?>">Current Game Highlights</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_coach_weekly_show")?>">Tiller Show Highlights</a></li>
  <li><a class="mainmenu" href="<?=$path->getPath("page_askcoach_answers")?>">'Ask the Coach' Answers</a></li>
<?/*  <li><a class="mainmenu" href="<?=$path->getPath("page_archive")?>">Past Game Archives</a></li> */?>
</ul>

<?
$p->close();
?>
