<?php
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_page"));

//////////////////////////////////////////////////
// Setup Page object
//////////////////////////////////////////////////

$p = new Page("mobile", "public", "page_gameviz");

//////////////////////////////////////////////////
// Register Form variables
//////////////////////////////////////////////////


$p->register("gameid", "hidden", array());
if (!Game::idExists($gameid)) {
  $setup = new Setup();
  $setup->loadCurrent();
  $gameid = $setup->getActiveGameID();
}
$p->register("driveid", "hidden", array());
if (!Drive::idExists($driveid)) {
  $d = new Drive();
  $driveid = $d->findMaxDriveIndexDriveidByGameid($gameid);
}
$game = new Game($gameid);
$hometeam = new Team($game->getTeamID());
$awayteam = new Team($game->getVisitorID());

/////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////

$d = new Drive($driveid);
$driveindex = $d->getDriveIndex();

//////////////////////////////////////////////////
// Start template
//////////////////////////////////////////////////

$p->startTemplate(true); // no header
?>
<a href="<?=$p->pageName()?>?gameid=<?=$gameid?>">
  <img src="<?=$path->getPath("page_gameviz_image")?>?driveid=<?=$driveid?>&gameid=<?=$gameid?>">
</a><br>
* Note: click the image to refresh.<br>
<a href="<?=$path->getPath("page_gameviz")?>?gameid=<?=$gameid?>">Choose another drive</a><br>

<center><font class="mobile_h1"><u>Legend</u><br></font></center>
<p>
   <img src="run-legend.gif">&nbsp;Running Play<br>
   <img src="pass-legend.gif">&nbsp;Passing Play<br>
   <img src="pen-legend.gif">&nbsp;Accepted Penalty<br>
   <img src="punt-legend.gif">&nbsp;Punt<br><br>
  
   <img src="stop.gif">&nbsp;Incomplete Pass<br>
   <img src="cop_up.gif">&nbsp;Change of Possession<br><br>
   <img src="fg.gif">&nbsp;Field Goal Good<br>
   <img src="fg-ng.gif">&nbsp;Field Goal No Good<br>
</p>

<?
$p->close();
?>

