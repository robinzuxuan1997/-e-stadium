<?php
error_reporting(0);
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_image"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_viz_field"));

$a[width] = $_REQUEST[width];     // pixels
$a[height] = $_REQUEST[height];   // pixels
$a[orient] = $_REQUEST[orient];   // "portrait" or "landscape"
$a[driveid] = $_REQUEST[driveid];
$a[gameid] = $_REQUEST[gameid];
$a[game] = new Game($a[gameid]);
$a[highlight_playid] = $_REQUEST[highlight_playid];
$a[num_possible_plays] = $_REQUEST[num_possible_plays]; // sets play width on image
$a[last15] = $_REQUEST[last15];   // gets the last $num_possible_plays

$a[width] = 318;
$a[height] = 425;
if (!$a[orient]) $a[orient] = "portrait";
if (!$a[num_possible_plays]) $a[num_possible_plays] = 20;
$drive_exists = Drive::idExists($a[driveid]);
$game_exists = Game::idExists($a[gameid]);
$do_last15 = (strlen($a[last15]) > 0);

//////////////////////////////////////////////////
// If there is only a highlight_playid, it will
// just use the drive with that play in it as 
// the driveid
//////////////////////////////////////////////////

if (Check::isInt($a[highlight_playid]) && !$drive_exists && !$do_last15) { // this is really just for RISE at this point
  $pl = new Play($a[highlight_playid]);
  $a[gameid] = $pl->getGameID();
  $dr = new Drive();
  $a[driveid] = $dr->findDriveIDByDriveIndexGameID($pl->getDriveNo(), $a[gameid]);
  $dr->Drive($a[driveid]);
}

if (Drive::idExists($a[driveid])) {
  $dr = new Drive($a[driveid]);
  $a[gameid] = $dr->getGameID();
  $a[game] = new Game($a[gameid]);
} else {
  if (!Game::idExists($a[gameid])) {
    $setup = new Setup();
    $setup->loadCurrent();
    $a[gameid] = $setup->getActiveGameID();
  }
  $a[game] = new Game($a[gameid]);
  $dr = new Drive();
  $a[driveid] = $dr->findMaxDriveIndexDriveidByGameid($a[gameid]);
}
$drive_index = $dr->getDriveIndex();
$pl = new Play();
if ($a[last15]) {
  $a[latest_play] = $pl->findLatestPlayidByGameid($a[gameid]);
} else {
  $a[latest_play] = $pl->findLatestPlayidByDriveIndex($drive_index);
}


// Note: if you pass a driveid and a gameid, the gameid is ignored in favor of whatever
// gameid is on the drive.  Also, if you pass last15, the driveid is ignored except to 
// get a gameid as above.

// Defaults are set in scripts/create_images/gameviz_image.php

$field = new VizField($a);
$a = $field->getParams(); // load with defaults 
unset($field);

$a = Check::constructDriveTrackerFilename($a);
$filepath = $a[filepath];

// If directory does not exist, create it
if (!is_dir($filepath)) {
  exec("mkdir -p $filepath");
}

// Check on completed file.  Three tests: image_exists, compfile_exists, compfile_contents != 1
if (   file_exists($a[writecompleted_filename])                      // writecompleted file exists
    && trim(file_get_contents($a[writecompleted_filename])) != 1) {  // and it's contents are not 1
  // wait 100 microseconds (0.1 milliseconds) and try again
  while (trim(file_get_contents($a[writecompleted_filename])) != 1) { usleep(100); }
} 
elseif (   !file_exists($a[filename])                                        // image does not exist
        && (   !file_exists($a[writecompleted_filename])                     // and either the writecompleted_filename does not exist
            || trim(file_get_contents($a[writecompleted_filename])) == 1)) { // or it exists and its contents are 1, indicating the image should have existed
  file_put_contents($a[writecompleted_filename], "0");
  include($path->getFilePath("page_drivetracker_imagegen")); // this creates the image with the filename of $a[filename]
  file_put_contents($a[writecompleted_filename], "1");
} 
elseif (   file_exists($a[filename])                               // image exists
        && !file_exists($a[writecompleted_filename])) {             // but writecompleted file does not exist
  // error case: noone ever wrote the comp file, but image exists
  file_put_contents($a[writecompleted_filename], "1");
}
else {
  // should only get here if no files needed to be created or modified
}

// At this point image should be guaranteed to exist unless it was not able to be created at all

//$a[filename] = $path->getFileRoot() . "../scripts/create_images/drivetracker/gameviz_autogen.png";
$im = new Image($a[filename], "png");
$im->outputImage("png");
$im->destroy();




?>