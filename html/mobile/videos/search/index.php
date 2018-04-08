<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_roster"));

///////////////////////////////////////////////////
// Register Form variables
///////////////////////////////////////////////////

$p = new Page("mobile", "public", "page_video_search");

Check::videoAccess($p);

// Set the gameid to the current game if there is no specific game passed in the address
$p->register("gameid", "hidden", array("setget" => "none"));
$setup = new Setup();
$setup->loadCurrent();
if (!Game::idExists($gameid)) { 
  $gameid = $setup->getActiveGameID();
}
$game = new Game($gameid);

$p->register("playerid", "select", 
             array("setget" => "none",
                   "error_message" => "Player",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("Roster",
                                                          false,
                                                          "findPlayersByTeamIDSeasonID",
                                                          array($game->getTeamID(), $setup->getActiveSeasonID()),
                                                          array("lname" => "getLName",
                                                                "fname" => "getFName",
                                                                "number" => "getNumber",
                                                                "id" => "getID",
                                                                "value" => "getID"))));
$p->register("playtype", "select",array("setget" => "none",
                                        "error_message" => "Play type",
                                        "get_choices_array_func" => "getPlaySearchTypeChoices"));
$p->register("search_by_player", "submit", array("setget" => "none", "value" => "Search"));
$p->register("search_by_playtype", "submit", array("setget" => "none", "value" => "Search"));

///////////////////////////////////////////////////
// Extraneous Setup
///////////////////////////////////////////////////

$home = new Team($game->getTeamID());
$away = new Team($game->getVisitorID());
$season = $game->getSeasonID();
$homeacr = $home->getAcronym();
$awayacr = $away->getAcronym();
$bio = $_REQUEST[bio];
if ($bio ==1) {
  $view = "index";
}
/////////////////////////////////////////////////////
// Decide state based on view
/////////////////////////////////////////////////////

switch($view) {
  case "index":     if ($p->submitIsSet("search_by_player"))   $state = "player_search";
                elseif ($bio == 1)                             $state = "player_search";
                elseif ($p->submitIsSet("search_by_playtype")) $state = "playtype_search";
                else                                           $state = "undefined";
    break;
  case "video_list":
  default: $state = "show_index";
}

////////////////////////////////////////////////////
// Perform processing based on state
////////////////////////////////////////////////////

if ($state == "show_index") {
  $view = "index";
}
elseif ($state == "player_search") {
  $pl = new Roster($playerid);
  $playtext = $pl->getLName();
  $search_type_message = "Videos for " . $pl->getFName() . " " . $pl->getLName();
  $view = "video_list";
}
elseif ($state == "playtype_search") {
  $playtext = $playtype;
  $playtype = strtolower($playtype);
  $playtype[0] = strtoupper($playtype[0]);
  $search_type_message = "$playtype videos";
  $view = "video_list";
}
else {
  $view = "undefined";
}

////////////////////////////////////////////////////
// Setup variables for next view
////////////////////////////////////////////////////

if ($view == "index") {
  $p->getChoices();
  for($i=0; $i<count($playerid_choices); $i++) {
    $pl = $playerid_choices[$i];
    $playerid_choices[$i][text] = "$pl[fname] $pl[lname] #$pl[number]";
  }
}
elseif ($view == "video_list") {
  // Get the list of Videos from the Database that we are interested in
  $v = new Video();
  $x = $v->findApprovedVideosByGameidPlaytextSearch($gameid, $playtext, true);
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
  case "index": include($path->getFilePath("template_video_search_index")); break;
  case "video_list": include($path->getFilePath("template_video_search_list")); break;
}


