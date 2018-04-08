<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_season"));

$p = new Page("mobile", "public", "page_archive");

$setup = new Setup();
$setup->loadCurrent();

$p->register("seasonid", "hidden", array("setget" => "none"));
$p->register("gameid", "hidden", array("setget" => "none"));

// Hacks for RISE to automatically choose the gameid
$p->register("rise", "hidden", array("setget" => "none"));
if ($rise == 1) {
//  include("/var/es/www/estadium/season_08/site/RISE/get_gameid.php"); // Hack for hardcoded RISE gameid
  $view = "gamelist";
}

// Decide state

switch($view) {
  case "index": if (strlen($seasonid) < 1) $state = "show_index";
                else                       $state = "show_gamelist";
    break;
  case "gamelist": if (strlen($gameid) < 1) $state = "show_index";
                   else                     $state = "show_stats";
    break;
  case "stats": $state = "show_index";
    break;
  default: $state = "show_index";
}

// Process Info from User

if ($state == "show_index") {
  $view = "index";
}
elseif ($state == "show_gamelist") {
  $view = "gamelist";
}
elseif ($state == "show_stats") {
  if (Game::idExists($gameid)) {
    $view =  "stats";
  } else {
    $view = "gamelist";
  }
} else {
  $view = "undefined";
}

// Setup View Variables

if ($view == "index") {
  // create array of past and present seasons
  $s = new Season();
  $past = $s->findPastIDs();
  $present = $s->findPresentID();
  $seasons[0] = $present[0];
// NOTE: This needs to be uncommented when the old season's videos
// have been converted and the database filenames have been fixed.
//  for ($i=0; $i<count($past); $i++) {
//    $seasons[$i+1] = $past[$i];
//  }
}
elseif ($view == "gamelist") {
  if (strlen($seasonid) < 1) {
    $seasonid = $setup->getActiveSeasonID();
  }
  $g = new Game();
  $fgames = $g->findFinishedHomeGamesBySeasonID($seasonid);
  $games = array();
  while ($game = $fgames->getOne()) {
    $home = new Team($game->getTeamID());
    $away = new Team($game->getVisitorID());
    array_push($games, array("id" => $game->getID(),
                             "away" => $away->getAcronym(),
                             "home" => $home->getAcronym()));
  }
}
elseif ($view == "stats") {
  $g = new Game($gameid);
  $season = $g->getSeasonID();
  $home = new Team($g->getTeamID());
  $away = new Team($g->getVisitorID());
  $homeid = $home->getID();
  $awayid = $away->getID();
  foreach (array("away", "home") as $who) {
    $teamvar = $who;
    $team = $$teamvar;

    $acronymvar = $who . "acronym";
    $$acronymvar = $team->getAcronym();

    $logovar = $who . "logo";
    $$logovar = $team->getLogoPath();

    $total = $g->findGameTotalByTeamid($team->getID());
    $defense = $g->findTeamDefenseByTeamID($team->getID());

    $scoresvar = $who . "scores";
    
	if (($total->getScoreFourthQ())+($total->getScoreThirdQ())+($total->getScoreSecondQ())+($total->getScoreFirstQ())!=($total->getFinalScore())) {
$$scoresvar = array("Quarter 1" => $total->getScoreFirstQ(),
                        "Quarter 2" => $total->getScoreSecondQ(),
                        "Quarter 3" => $total->getScoreThirdQ(),
                        "Quarter 4" => $total->getScoreFourthQ(),
			"OT" =>($total->getFinalScore())- (($total->getScoreFourthQ())+($total->getScoreThirdQ())+($total->getScoreSecondQ())+($total->getScoreFirstQ())),                        
"Total Score" => $total->getFinalScore());

}

else
{
$$scoresvar = array("Quarter 1" => $total->getScoreFirstQ(),
                        "Quarter 2" => $total->getScoreSecondQ(),
                        "Quarter 3" => $total->getScoreThirdQ(),
                        "Quarter 4" => $total->getScoreFourthQ(),
"Total Score" => $total->getFinalScore());
}

    $downsvar = $who . "downs";
    $$downsvar = array("first" => $total->getFirstDowns(),
                       "third" => array("attempts" => $total->getConvThirdAtt(),
                                        "successes" => $total->getConvThirdConv()),
                      "fourth" => array("attempts" => $total->getConvFourthAtt(),
                                        "successes" => $total->getConvFourthConv()));

    $yardsvar = $who . "yards";
    $$yardsvar = array("passing" => array("yards" => $total->getPassYds(),
                                          "completions" => $total->getPassComp(),
                                          "attempts" => $total->getPassAtt()),
                       "rushing" => array("yards" => $total->getRushYds(),
                                          "attempts" => $total->getRushAtt()),
                       "penalty" => array("yards" => $total->getPenaltyTot(),
                                          "number" => $total->getPenaltyYds()),
                       "turnovers" => array("fumbles" => $total->getFumbles(),
                                            "interceptions" => $total->getPassInt()));

    $posvar = $who . "time_possession";
    $$posvar = $total->getTimeOfPos();

    $defensevar = $who . "defense";
    $$defensevar = array("fumbles" => array("forced" => $defense->getFf(),
                                            "recovered" => $defense->getFr(),
                                            "yds" => $defense->getFryds()),
                         "inter" => array("num" => $defense->getInter(),
                                          "yds" => $defense->getInteryds()),
                         "tackles" => array("number" => $defense->getTackua() + $defense->getTacka(),
                                            "tfl" => $defense->getTflua() + $defense->getTfla(),
                                            "tflyds" => $defense->getTflyds(),
                                            "sacks" => $defense->getSackua() + $defense->getSacka(),
                                            "sackyds" => $defense->getSackyds()));
  }
}

if(isset ($_REQUEST['smartdevices'])){
      include_once 'smartdevices.php';  
}

else
switch ($view) {
  case "index": include_once($path->getFilePath("template_mobile_archive_index")); break;
  case "gamelist": include_once($path->getFilePath("template_mobile_archive_gamelist")); break;
  case "stats": include_once($path->getFilePath("template_mobile_archive_stats")); break;
  default: include_once($path->getFilePath("template_undefined")); break;
}


