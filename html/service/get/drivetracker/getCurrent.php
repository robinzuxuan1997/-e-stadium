<?php
/*
Return the current drive image
Optional arguments:
gameid - defaults to current game id
driveid - defaults to last drives
last15
*/

error_reporting(0);
include 'driveUtils.php';

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

//$imagepath = $path->getPath("page_drivetracker_image") ."?width=315&height=425&driveid=$driveid&gameid=$gameid$last15&nocache=".uniqid("viz_image_", 1);
$imagepath = $path->getPath("page_drivetracker_image") ."?width=315&height=425&driveid=$driveid&gameid=$gameid$last15&nocache=".uniqid("viz_image_", 1);

//http://estadium.gatech.edu/mobile/drvtrk/image.php?width=315&height=425&driveid=1503&gameid=301&last15=true&nocache=viz_image_4cab6f292873e5.03632725


$data = array();
$data['gameid'] = $gameid;
$data['driveid'] = $driveid;
$data['driveindex'] = $driveindex;
$data['homeaway'] = $homeaway;
$data['image'] = $imagepath;
$data['width'] = 315;
$data['height'] = 425;
$data['last15'] = (isset($last15) && $last15);

echo json_encode($data);

?>
