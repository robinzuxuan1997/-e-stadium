<?php
require '../../jsonwrapper/jsonwrapper.php';
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();

$data = array();
$legend = array();
$legend['Rush'] = $path->getPath("image_drivetracker_legend_rush");
$legend['Pass'] = $path->getPath("image_drivetracker_legend_pass");
$legend['Incomplete Pass'] = $path->getPath("image_drivetracker_legend_incomplete");

$legend['Penalty'] = $path->getPath("image_drivetracker_legend_penalty");
$legend['Punt or Kickoff'] = $path->getPath("image_drivetracker_legend_kickoff");
$legend['Fumble or Interception'] = $path->getPath("image_drivetracker_legend_fumble");

$data['legend'] = $legend;

echo json_encode($data);
?>
