<?php
error_reporting(1);

include 'driveUtils.php';
include_once($path->getFilePath("class_viz_play"));
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
  $driveindex = $d->getDriveIndex();
  
  /*
  function getStartTime() { return $this->StartTime; }
  function getEndTime() { return $this->EndTime; }
  function getTotalTime() { return $this->TotalTime; }
  function getStartSpot() { return $this->StartSpot; }
  function getEndSpot() { return $this->EndSpot; }
  function getTotalYards() { return $this->TotalYards; }
  function getPlayCount() { return $this->PlayCount; }
  function getStartPlay() { return $this->StartPlay; }
  function getEndPlay() { return $this->EndPlay; }
  function getTeamID() { return $this->TeamID; }
  */
  
  array_push($drives, array("driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                            ));
}
$data = array();
$data['drives'] = $drives;

echo json_encode($data);

?>
