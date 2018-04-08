<?

$valid_access_code = "2009";

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game"));

///////////////////////////////////////////////////
// Register Form variables
///////////////////////////////////////////////////

$p = new Page("mobile", "public", "page_video_highlights");

Check::videoAccess($p);

$p->register("gameid", "hidden", array("setget" => "none"));
$p->register("quarter", "hidden", array("setget" => "none"));
$p->register("opennewpage", "hidden", array("setget" => "none"));


///////////////////////////////////////////////////
// Extraneous Setup
///////////////////////////////////////////////////

// Set the gameid to the current game if there is no specific game passed in the address
$setup = new Setup();
$setup->loadCurrent();
if (Check::notInt($gameid)) {
  $gameid = $setup->getActiveGameID();
}
$game = new Game($gameid);
$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());
$season = $game->getSeasonID();
$homeacr = $home->getAcronym();
$awayacr = $away->getAcronym();

$view = "index";
////////////////////////////////////////////////////
// Setup variables for next view
////////////////////////////////////////////////////

if ($view == "index") {
  // Set the quarter to the latest quarter if there is no specific valid quarter in the address
  $v = new Video();
  $quarters = $v->findQuartersByGameID($gameid);
  foreach($quarters as $q) {
    if ($quarter == $q) {
      $found = true;
      break;
  } }
  if (!$found) $quarter = $q; // set to last (max) quarter
  
  // Get the list of Videos from the Database that we are interested in
  $v = new Video();
  $x = $v->findApprovedVideosByQuarterGameID($quarter, $gameid, true);
  function videoCompare($a,$b) {
    $apath = $a->getVideoPath();
    $bpath = $b->getVideoPath();
    $afilename = $a->getVideoFilename();
    $bfilename = $b->getVideoFilename();
    preg_match("/([0-9]+)(_([0-9]+))?/", $afilename, $amatches);
    preg_match("/([0-9]+)(_([0-9]+))?/", $bfilename, $bmatches);
    $afile = $amatches[1];
    $bfile = $bmatches[1];
    $aangle = $amatches[3];
    $bangle = $bmatches[3];
    if ($apath != $bpath)   return (strcmp($apath,$bpath))   ? 1 : -1;
    if ($afile != $bfile)   return ($afile < $bfile)   ? 1 : -1;
    if ($aangle != $bangle) return ($aangle < $bangle) ? 1 : -1;
    return 0;
  }
  usort($x, "videoCompare");

  $videos = array();
  foreach($x as $v) {
    preg_match("/([0-9]+)(_([0-9]+))?/", $v->getVideoFileName(), $matches);
    $videonumber = $matches[1];
    $anglenumber = $matches[3];
    $last_video = count($videos) - 1;
    $qarr = $videos[$last_video];
    if (is_array($qarr) && $qarr[0][videonumber] == $videonumber) {
      // Add a new angle to this set of videos
      array_push($videos[$last_video],
           array("path" => $v->getVideoPath(),
                 "filename" => $v->getVideoFileName(),
                 "videonumber" => $videonumber,
                 "anglenumber" => $anglenumber+1,
                 "text" => $v->getPlayText()));
    } else {
      // Add a new video as the first angle
      array_push($videos,
                 array(array("path" => $v->getVideoPath(),
                             "filename" => $v->getVideoFileName(),
                             "videonumber" => $videonumber,
                             "anglenumber" => $anglenumber+1,
                             "text" => $v->getPlayText())));
} } }


/////////////////////////////////////////////////////////////
// Include template based on view
/////////////////////////////////////////////////////////////

switch($view) {
  case "index": include($path->getFilePath("template_video_gameday_index")); break;
}


