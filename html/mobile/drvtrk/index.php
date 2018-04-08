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
include_once($path->getFilePath("class_style"));


//////////////////////////////////////////////////
// Setup Page object
//////////////////////////////////////////////////

$p = new Page("mobile", "public", "page_drivetracker");

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
$season = $game->getSeasonID();
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
$pl1 = new Play();
$pl2= new Play();
$driveindex = $d->getDriveIndex();
$latestplaydrive = $pl1->findLatestPlayidByDriveIndex($driveindex);
$latestplaygame = $pl2->findLatestPlayidByGameid($gameid);
if ($d->getTeamID() == $hometeam->getID()) {
  $homeaway = $hometeam->getAcronym();
} else {
  $homeaway = $awayteam->getAcronym();
}


//////////////////////////////////////////////////
// Start template
//////////////////////////////////////////////////

$p->startTemplate();

?>
<div id="thiscontent">
<center><font class="mobile_h1">
  &nbsp;&nbsp;<u>Drive: <?=$homeaway?><?=$driveindex?></u>&nbsp;&nbsp;
  <a href="<?=$p->pageName()?>?gameid=<?=$gameid?>&last15=true">Current</a><br>
</font></center><br>

<center><img src="<?=$path->getPath("page_drivetracker_image")?>?width=315&height=425&driveid=<?=$driveid?>&gameid=<?=$gameid?><?=$last15?>&nocache=<?=uniqid("viz_image_", 1)?>" usemap="#drivetracker"></center><br>

<!--Link the videos to the drivetracker plays! -->
<?
$mapname=("../../../html/images/drivetracker/".$season."/G".$gameid."/drvtrk_d".$driveid."_w318_h425_oportrait_n20_lp".$latestplaydrive."_map.html");
$file= fopen($mapname, "r");
if ($last15){
$mapname=("../../../html/images/drivetracker/".$season."/G".$gameid."/drvtrk_l15_w318_h425_oportrait_n20_lp".$latestplaygame."_map.html");
$file= fopen($mapname, "r");
}
$map = fread($file, filesize($mapname)); 

//echo $map; 
 fclose($file);

?>
<center><font class="mobile_h1"><u>Choose another drive:</u></font><br>

<table border=0>
<?
foreach($quarters as $q) {?>
  <tr><th>Q<?=$q?></th><?
  $count = 1;
  foreach ($drives as $d) {
	
    if ($d[quarter] == $q) {
      if (($count%6) == 0) {
        ?><tr><td></td><?
        $count = 1;
      }
      ?><td align="right"><?
      if ($d[driveid] != $driveid) {?>
        <a class="small" style="color:<?=$d[color]?>" href="<?=$p->pageName()?>?driveid=<?=$d[driveid]?>&gameid=<?=$gameid?>"><?=$d[homeaway]?><?=$d[index]?></a>
      <?} else {?>
        <?=$d[homeaway]?><?=$d[index]?>
      <?}
      ?></td><?
      if (((++$count)%6) == 0) {
        ?></tr><?
      }
    }
  }
  // finish out any empty slots in table
  while (($count++ % 6) != 0) {
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
    <td align="left">
      <img src="<?=$path->getPath("image_drivetracker_legend_rush")?>">&nbsp;Rush<br/>
      <img src="<?=$path->getPath("image_drivetracker_legend_pass")?>">&nbsp;Pass<br/>
      <img src="<?=$path->getPath("image_drivetracker_legend_incomplete")?>">&nbsp;Incomplete Pass<br/>
    </td>  
    <td align="left">
      <img src="<?=$path->getPath("image_drivetracker_legend_penalty")?>">&nbsp;Penalty<br/>
      <img src="<?=$path->getPath("image_drivetracker_legend_kickoff")?>">&nbsp;Punt or Kickoff<br/>
      <img src="<?=$path->getPath("image_drivetracker_legend_fumble")?>">&nbsp;Fumble or Interception<br/>
    </td>
  </tr>
</table>
</p>
</center>
</div>
<?
$p->close();
?>

