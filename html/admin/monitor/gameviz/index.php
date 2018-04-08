<?php
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_style"));

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
  $_REQUEST[last15] = "true";
}
$p->register("last15", "hidden", array());
if ($last15!="true") {
  $last15 = "";
}
else {
  $last15 = "&last15=true";
}
$game = new Game($gameid);
$hometeam = new Team($game->getTeamID());
$awayteam = new Team($game->getVisitorID());

/////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////

// Create drives array for links
$d = new Drive();
$dbdrives = $d->findDrivesByGameid($gameid);
$quarters = $d->findQuartersWithDrivesByGameid($gameid);
$drives = array();
while ($d = $dbdrives->getOne()) {
  if ($d->getTeamID() == $hometeam->getID()) {
    $team = $hometeam->getAcronym();
    $color = "#8B6508";
  } else {
    $team = $awayteam->getAcronym();
    $color = "#000000";
  }
  array_push($drives, array("driveid" => $d->getID(),
                            "index" => $d->getDriveIndex(),
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color));
}
$d = new Drive($driveid);
$driveindex = $d->getDriveIndex();
if ($d->getTeamID() == $hometeam->getID()) {
  $homeaway = $hometeam->getAcronym();
} else {
  $homeaway = $awayteam->getAcronym();
}


//////////////////////////////////////////////////
// Start template
//////////////////////////////////////////////////

$p->startMonitorTemplate();
?>
<center><font class="mobile_h1">
    &nbsp;&nbsp;<u>Drive: <?=$homeaway?><?=$driveindex?></u>&nbsp;&nbsp;
  <a href="<?=$p->pageName()?>?gameid=<?=$gameid?>">Current</a><br>
  
</font></center><br>

<img src="<?=$path->getPath("page_gameviz_image")?>?driveid=<?=$driveid?>&gameid=<?=$gameid?><?=$last15?>&nocache=<?=uniqid("viz_image_", 1)?>"><br>
<br>
<center><font class="mobile_h1"><u>Choose another drive:</u></font><br>
<table border=0>
<?
foreach($quarters as $q) {?>
  <tr><th>Q<?=$q?></th><?
  $count = 1;
  foreach ($drives as $d) {
    if ($d[quarter] == $q) {
      if (($count%8) == 0) {
        ?><tr><td></td><?
        $count = 1;
      }
      ?><td align="right"><?
      if ($d[driveid] != $driveid) {?>
        <a class="mobile_h2" style="color:<?=$d[color]?>" href="<?=$p->pageName()?>?driveid=<?=$d[driveid]?>&gameid=<?=$gameid?>"><?=$d[homeaway]?><?=$d[index]?></a>
      <?} else {?>
        <?=$d[homeaway]?><?=$d[index]?>
      <?}
      ?></td><?
      if (((++$count)%8) == 0) {
        ?></tr><br><?
      }
    }
  }
  // finish out any empty slots in table
  while (($count++ % 8) != 0) {
    ?><td></td><?
  }
  ?></tr><?
}?>
</table>
</center><br>

<center><font class="mobile_h1"><u>Legend</u><br></font>
<p>
<table>
<tr>
<td>
   <img src="run-legend.gif">&nbsp;Running Play<br>
   <img src="pass-legend.gif">&nbsp;Passing Play<br>
   <img src="pen-legend.gif">&nbsp;Accepted Penalty<br>
   <img src="punt-legend.gif">&nbsp;Punt
</td>  
<td>   
   <img src="fg.gif">&nbsp;Field Goal Good<br>
   <img src="fg-ng.gif">&nbsp;Field Goal No Good
</td>
</tr>
<tr>
<td>
   <img src="stop.gif">&nbsp;Incomplete Pass
</td>
<td>
   <img src="cop_up.gif">&nbsp;Fumble/Interception
</td>
</tr>
</table>
</p>
</center>
<?
$p->close();
?>

