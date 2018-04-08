<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_scripts_global_settings"));

GlobalSettings::load("site_links"); // creates $SETTINGS array

$p = new Page("normal", "admin", "page_admin_video_assoc");

$setup = new Setup();
$setup->loadCurrent();

/////////////////////////////////////////////////////////////////////
// Register Form Variables
/////////////////////////////////////////////////////////////////////

$p->register(    "save",   "submit", array("value" => "Save"));
$p->register( "refresh",   "submit", array("value" => "Refresh List"));
$p->register( "quarter",   "hidden", array());
$p->register("videoids",   "hidden", array("use_post" => true));

$p->register("approved", "checkbox", array("on_text" => "Approved",
                                           "off_text" => "Pending Approval"));
// Note: play choices will be gotten manually below based on what quarter
// we need to show (most recent or specified)
$p->register(  "playid", "select", array("max_len" => "90",
                                         "error_message" => "Play")); 

$p->register( "new_or_existing", "hidden", array()); // "new" or "existing"

/////////////////////////////////////////////////////////////////////
// Decide state based on view
/////////////////////////////////////////////////////////////////////

switch($view) {
  case "new_index": if ($new_or_existing == "existing") $state = "show_existing_index";
                    elseif ($p->submitIsSet("save"))    $state = "process_new_save";
                    elseif ($p->submitIsSet("refresh")) $state = "show_new_index";
                    else                                $state = "show_new_index";
    break;
  case "existing_index": if ($new_or_existing == "new")      $state = "show_new_index";
                         elseif ($p->submitIsSet("save"))    $state = "process_existing_save";
                         elseif ($p->submitIsSet("refresh")) $state = "show_existing_index";
                         else                                $state = "show_existing_index";
    break;
  default: $state = "show_new_index";
}

/////////////////////////////////////////////////////////////////////
// Perform action based on state, decide next view
/////////////////////////////////////////////////////////////////////

if ($state == "show_new_index") {
  $view = "new_index";
}
elseif ($state == "show_existing_index") {
  $view = "existing_index";
}
elseif ($state == "process_new_save" || $state == "process_existing_save") {
  if (!is_array($videoids)) {
    $p->registerErr("videoids", "INTERNAL ERROR: Videoids is not an array!");
  }
  else {
    // Check each videoid to make sure it exists in the database
    $videos = array();
    foreach($videoids as $vid) {
      $v = new Video($vid);
      if (!$v->idValid()) {
        $p->registerErr("videoids", "INTERNAL ERROR: Videoid '$v' does not exist in the database!");
      } else {
        array_push($videos, $v);
      }
    }
  }

  if ($p->noErrors()) {
    $pl = new Play($playid);
    if ($pl->getID() != "" && $pl->getID() != 0 && !$pl->idValid()) {
      $p->registerErr("playid", "INTERNAL ERROR: Playid '$playid' does not exist in database!");
    }
    elseif ($pl->idValid() && $pl->getQuarter() != $videos[0]->getQuarter()) {
      $p->registerErr("playid", "INTERNAL ERROR: Quarter (".$pl->getQuarter().") for Playid (".$playid.") does not match video quarter (".$videos[0]->getQuarter().")!");
    }
  }

  // Set approved checkbox variable
  if ($approved != "Y") $approved = "N";

  if ($p->noErrors()) {
    // Save each video (angle) with play id and text, making sure to set proper timestamps
    // if this is the first time we've approved or associated the video.
    foreach($videos as $v) {
      if ($v->getApproved != "Y" && $v->getApproved() != "N") { // have not approved yet
        $v->setApprovedTime(Check::formatDate(time(), "epoch", "mysql_datetime"));
      }
      $v->setApproved($approved);

      if ($pl->getID() > 0) { // 0 is non-associated play
        $check_text = trim(preg_replace("/Recent Play/", "", $v->getPlayText()));
        if ($v->getPlayid() < 1) {
          $v->setAssociatedTime(Check::formatDate(time(), "epoch", "mysql_datetime"));
        }
        $v->setPlayid($pl->getID());
        $v->setPlayText($pl->getText());
      } else { // not associating play here
        if ($v->getApproved() == "Y") {
          $v->setPlayText("Recent Play");
        }
      }

      $v->save();
    }
    $msg = "Save Successful";
  } else {
    $msg = "Save Failed!";
    // Need to keep last quarter to handle the case where a save fails and the page quarter
    // would switch between page loads
  }

  if ($state == "process_new_save") {
    $view = "new_index";
  } elseif ($state == "process_existing_save") {
    $view = "existing_index";
  } else {
    $view = "undefined";
  }
}
else {
  $view = "undefined";
}

/////////////////////////////////////////////////////////////////////
// Load template variables
/////////////////////////////////////////////////////////////////////


// First, setup $quarter, $dbvideos based on whether this is new or existing
if ($view == "new_index") {
  $v = new Video();
  $quarters = $v->findQuartersWithNonAssociatedVideosByGameID($setup->getActiveGameID());
  if (count($quarters) < 1) $quarters = array(1);
  if (!in_array($quarter, $quarters)) {// don't have a quarter set that has any videos, so default to oldest quarter
    $quarter = min($quarters);
  }
  $dbvideos = $v->findNonAssociatedVideosByGameIDQuarter($setup->getActiveGameID(), $quarter);
  $opposite_new_or_existing = "existing"; // on new page, show link to go to existing, and vice-versa
  $new_or_existing = "new";
} 
elseif ($view == "existing_index") {
  $v = new Video();
  $quarters = $v->findQuartersWithAssociatedVideosByGameID($setup->getActiveGameID());
  if (count($quarters) < 1) $quarters = array(1);
  if (!in_array($quarter, $quarters)) {// don't have a quarter set above that has any videos, so default to newest quarter
    $quarter = max($quarters);
  }
  $dbvideos = $v->findAssociatedVideosByGameIDQuarter($setup->getActiveGameID(), $quarter);
  $opposite_new_or_existing = "new";
  $new_or_existing = "existing";
}

// Now setup $videos and $play_choices for template, $last_plays for session
if ($view == "new_index" || $view == "existing_index") {
  // Setup videos array like:
  // videos[filenum][angle_index][filename]
  //                             [webpath]
  //                             [approved]
  //                             [videoid]
  //                             [playid] = 0 // 0 is for un-associated play
  $videos = array();
  foreach($dbvideos as $v) {
    $filenum = preg_replace("/_[0-9]+/", "", $v->getVideoFilename());
    if (!is_array($videos[$filenum])) $videos[$filenum] = array(); // first angle for this file number
    array_push($videos[$filenum], array("filename" => $v->getVideoFilename(),
                                        "videoid"  => $v->getID(),
                                        "webpath"  => $v->getVideoPath(),
                                        "approved" => $v->getApproved(),
                                        "playid"   => $v->getPlayID(),
                                        "old_text" => $v->getPlayText()));
  }

  $playid_choices = Choices::getPlaybyPlayChoices($setup->getActiveGameID(), $quarter);
}

/////////////////////////////////////////////////////////////////////
// Include template based on view
/////////////////////////////////////////////////////////////////////
switch($view) {
  case "new_index":
  case "existing_index": include($path->getFilePath("template_admin_video_index"));
    break;
  default: include($path->getFilePath("template_undefined"));
}
