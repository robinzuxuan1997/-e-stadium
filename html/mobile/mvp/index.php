<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_roster"));
include_once($path->getFilePath("class_mvp_vote"));

$p = new Page("mobile", "public", "page_mvp");

$setup = new Setup();
$setup->loadCurrent();
$game = new Game($setup->getActiveGameID());

$p->register("results", "hidden", array("setget" => "none")); // set results=something to see results page

$p->register("playerid", "select", 
             array("setget" => "Playerid",
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
$p->register("voter_name", "textbox",
             array("setget" => "Name",
                   "box_size" => "30",
                   "check_func" => "validShortText",
                   "check_func_args" => array(false),
                   "error_message" => "Name"));
$p->register("voter_email", "textbox",
             array("setget" => "Email",
                   "box_size" => "30",
                   "check_func" => "validShortText",
                   "check_func_args" => array(false),
                   "error_message" => "Email"));

$p->register("submit_vote", "submit", array("value" => "Submit Vote", "setget" => "none"));
$p->register("submit_sortname", "submit", array("value" => "Name", "setget" => "none"));
$p->register("submit_sortnum", "submit", array("value" => "Number", "setget" => "none"));


if ($results) $state = "show_results";
else {
  switch($view) {
    case "index": 
    case "error": if ($p->submitIsSet("submit_vote"))     $state = "process_vote";
             else if ($p->submitIsSet("submit_sortname")) $state = "sort_name";
             else if ($p->submitIsSet("submit_sortnum"))  $state = "sort_num";
             else                                         $state = "undefined";
      break;
    case "success":
    default: $state = "show_index";
  }
}

if ($state == "show_index") {
  $view = "index";
}
else if ($state == "show_results") {
  $view = "results";
}
else if ($state == "sort_name") {
  $sortby = "name";
  $playerid=false;
  $view = "index";
}
else if ($state == "sort_num") {
  $sortby = "num";
  $playerid=false;
  $view = "index";
}
else if ($state == "process_vote") {
  $p->checkVars();
  if ($p->noErrors()) {
    $x = new MVPVote();
    $p->setVars($x);
    $x->setGameid($game->getID());
    $x->save();
    $view = "success";
  } else {
    $view = "error";
  }
} else {
  $view = "undefined";
}

$p->getChoices();
if ($view == "index" || $view == "error") {
  function comparePlayers($a, $b) {
    global $sortby;
    if ($sortby == "name") {
      return strcasecmp($a[lname] . $a[fname], $b[lname] . $b[fname]);
    }
    else {
      if ($a[number] < $b[number]) return -1;
      if ($a[number] == $b[number]) return 0;
      if ($a[number] > $b[number]) return 1;
    }
  }
  usort($playerid_choices, "comparePlayers");
  $tmpchoices = array();
  foreach($playerid_choices as $t) {
    array_push($tmpchoices, array("text" => "$t[fname] $t[lname], #$t[number]",
                             "value" => "$t[id]"));
  }
  $playerid_choices = $tmpchoices;
} 
else if ($view == "success") {
  $r = new Roster($playerid);
  $lname = $r->getLName();
  $fname = $r->getFName();
  $number = $r->getNumber();
  $image = $r->getImagePath();
  if (!file_exists($path->getFilePath("image_player_basedir") . "/$image")) {
    $image = false;
  }
}
else if ($view == "results") {
  $m = new MVPVote();
  $players = $m->findPlayersWithVotesByGameidLimit($game->getID());
  $votes = array();
  while ($player = $players->getOne()) {
    array_push($votes, array("name" => $player->getFullName(),
                             "number" => $player->getNumber(),
                             "playerid" => $player->getID(),
                             "votecount" => $m->countVotesByPlayeridGameid($player->getID(), $game->getID())));
  }
  function compareVotes($a, $b) {
    return $b[votecount] - $a[votecount];
  }

  usort($votes, compareVotes);
  $total_votes = $m->countVotesByGameid($game->getID());
}

switch($view) {
  case "index":
  case "error": include_once($path->getFilePath("template_mvp_index"));
    break;
  case "success": include_once($path->getFilePath("template_mvp_success")); 
    break;
  case "results": include_once($path->getFilePath("template_mvp_results")); 
    break;
  default: include_once($path->getPath("template_undefined")); break;
}

?>


