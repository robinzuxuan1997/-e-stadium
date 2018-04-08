<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_scripts_global_settings"));

GlobalSettings::load("site_links"); // creates $SETTINGS array

$p = new Page("normal", "public", "page_admin_quarter_watch");

$setup = new Setup();
$setup->loadCurrent();

/////////////////////////////////////////////////////////////////////
// Register Form Variables
/////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////
// Decide state based on view
/////////////////////////////////////////////////////////////////////

switch($view) {
  default: $state = "show_index";
}

/////////////////////////////////////////////////////////////////////
// Perform action based on state, decide next view
/////////////////////////////////////////////////////////////////////

if ($state == "show_index") {
  $view = "index";
}
else {
  $view = "undefined";
}

/////////////////////////////////////////////////////////////////////
// Load template variables
/////////////////////////////////////////////////////////////////////

if ($view == "index") {
  $pl = new Play();
  $play_quarter = $pl->findMaxQuarterByGameID($setup->getActiveGameID());
  if (!$play_quarter) $play_quarter = 1;

  $v = new Video();
  $video_quarter = $v->findMaxQuarterByGameID($setup->getActiveGameID());
  if (!$video_quarter) $video_quarter = 1;
}


/////////////////////////////////////////////////////////////////////
// Include template based on view
/////////////////////////////////////////////////////////////////////
switch($view) {
  case "index": include($path->getFilePath("template_admin_quarter_watch_index"));
    break;
  default: include($path->getFilePath("template_undefined"));
}
