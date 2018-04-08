<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_other_video"));
include_once($path->getFilePath("class_video_type"));
include_once($path->getFilePath("class_season"));
include_once($path->getFilePath("class_setup"));

// Extraneous Setup
$p = new Page("mobile", "public", "page_tiller_highlights");

// type is either TILLER_HIGHLIGHT or TILLER_ASKCOACH
$p->register("type", "hidden", array("setget" => "none"));
$p->register("season", "hidden", array("setget" => "none"));
if ($type == "highlights") {
  $type = "TILLER_HIGHLIGHT";
} elseif ($type == "askcoach") {
  $type = "ASKCOACH_ANSWERS";
}
$vt = new VideoType();
$vts = $vt->findVideoTypeByIdentText($type);
$typeid = $vts->getID();
if (!Season::idExists($season)) {
  $setup = new Setup();
  $setup->loadCurrent();
  $season = trim($setup->getActiveSeasonID());
}
// Register Form Variables

$p->register("episodeid", "select", array("setget" => "none",
                                          "error_message" => "Episode",
                                          "get_choices_array_func" => "getCoachEpisodeChoices",
                                          "get_choices_array_func_args" => array($typeid, $season),
                                          "form_autosubmit" => "episodeForm"));
$p->register("submit1", "submit", array("setget" => "none", "value" => "Go"));

// Determine state based on view

switch($view) {
  default: $state = "show_index";
}

// Perform action based on state, decide next view

if ($state == "show_index") {
  if ($type == "TILLER_HIGHLIGHT") {
    $view = "index_highlights";
  } elseif ($type == "ASKCOACH_ANSWERS") {
    $view = "index_askcoach";
  } else {
    $view = "undefined";
  }
} else {
  $view = "undefined";
}

// Setup view variables for next view

if ($view == "index_askcoach" || $view == "index_highlights") {
  $p->getChoices();
  $o = new OtherVideo();
  if (!Season::idExists($season)) {
    $setup = new Setup();
    $setup->loadCurrent();
    $season = trim($setup->getActiveSeasonID());
  }
  $vt = new VideoType();
  $vts = $vt->findVideoTypeByIdentText($type);
  $typeid = $vts->getID();
  if (!$o->groupingExistsByTypeIDSeason($episodeid, $typeid, $season)) {
    $episodeid = $episodeid_choices[0][value]; // use latest episode
  }
  if (Check::isInt($vts->getID())) {
    $v = new OtherVideo();
    $vs = $v->findVideosByGroupingTypeIDSeasonOrdered($episodeid, $vts->getID(), $season);
    $videos = array();
    while ($v = $vs->getOne()) {
      if (count($videos) < 1) { // first time through the loop
        $game = new Game($v->getGameID());
        $away = new Team($game->getVisitorID());
        $episode_num = $v->getGrouping();
        $away_acr = $away->getAcronym();
        $gamedate = Check::formatDate($game->getStart(), 1, 3);
      }
      array_push($videos, array("file" => $v->getVideoPath() . $v->getVideoFileName(),
                                "desc" => $v->getDescription()));
    }
  } else {
    $errmsg = "The video type requested does not exist";
  } 
}

switch($view) {
  case "index_askcoach": include($path->getFilePath("template_tillershow_askcoach")); break;
  case "index_highlights": include($path->getFilePath("template_tillershow_highlights")); break;
  default: include($path->getFilePath("template_undefined"));
}
