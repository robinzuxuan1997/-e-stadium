<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_defense"));
include_once($path->getFilePath("class_player_game_stat"));
include_once($path->getFilePath("class_roster"));

$p = new Page("mobile", "public", "page_playerstats");

// Register GET/POST variables
$p->register("gameid", "hidden", array("setget" => "none"));
$p->register("teamid", "hidden", array("setget" => "none"));

// Extraneous Setup
$setup = new Setup();
$setup->loadCurrent();
$season = $setup->getActiveSeasonID();

// Determine state from view

switch($view) {
  default: $state = "show_index";
}

// Process data based on state
if ($state == "show_index") {
  if (!Team::idExists($teamid) || !Game::idExists($gameid)) {
    $view = "undefined";
  } else {
    $game = new Game($gameid);
    $team = new Team($teamid);
    // check that there is a row in the PlayerGameStats table for this (teamid,gameid)
    $pgs = $game->findPlayerGameStatsByTeamID($teamid);
    $dfs = $game->findDefenseStatsByTeamID($teamid);
    $view = "index";
  }
}
else {
  $view = "undefined";
}
// Setup view variables based on view
if ($view == "index") {
  $teamname = $team->getAcronym();
  $passers = array();
  $rushers = array();
  $receivers = array();
  $punters = array();
  $kickreturners = array();
  $puntreturners = array();
  $defense = array();
  $roster = new Roster();
  while ($player = $pgs->getOne()) {
    // Special case: there is an extraneous "Team" player in the database
    if ($player->getName() == "Team") continue;
    $cp = $player->getPassComp();
    $att = $player->getPassAtt();
    $yds = $player->getPassYds();
    $tds = $player->getPassTds();
    $int = $player->getPassIntrcpt();
    if ($cp || $att || $yds || $tds || $int) {
      array_push($passers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "cp" => $cp, "att" => $att, "yds" => $yds, "tds" => $tds, "int" => $int));
    }
    $att = $player->getRushAtt();
    $yds = $player->getRushYds();
    $tds = $player->getRushTds();
    if ($att || $yds || $tds) {
      array_push($rushers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "att" => $att, "yds" => $yds, "tds" => $tds));
    }
    $rec = $player->getRecCnt();
    $yds = $player->getRecYds();
    $tds = $player->getRecTds();
    if ($rec || $yds || $tds) {
      array_push($receivers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "rec" => $rec, "yds" => $yds, "tds" => $tds));
    }
    $punt = $player->getPuntCnt();
    $yds = $player->getPuntYds();
    $long = $player->getPuntLong();
    if ($punt || $yds || $long) {
      array_push($punters, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "punt" => $punt, "yds" => $yds, "long" => $long));
    }
    $ret = $player->getKickRetCnt();
    $yds = $player->getKickRetYds();
    $long = $player->getKickRetLong();
    if ($ret || $yds || $long) {
      array_push($kickreturners, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "ret" => $ret, "yds" => $yds, "long" => $long));
    }
    $ret = $player->getPuntRetCnt();
    $yds = $player->getPuntRetYds();
    $long = $player->getPuntRetLong();
    if ($ret || $yds || $long) {
      array_push($puntreturners, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "ret" => $ret, "yds" => $yds, "long" => $long));
    }
  }
  while ($d = $dfs->getOne()) {
    $name = $d->getPlayerName();
    if ($name != "TEAM") {
      $tkls = $d->getTackua() + $d->getTacka();
      $tfl = $d->getTflua() + $d->getTfla();
      $tflyds = $d->getTflyds();
      $sks = $d->getSackua() + $d->getSacka();
      $skyds = $d->getSackyds();
      $int = $d->getInter();
      $intyds = $d->getInteryds();
      if ($tkls || $tfl || $tflyds || $sks || $skyds || $int || $intyds) {
        array_push($defense, array("id" => $roster->findPlayeridByNameSeasonID($d->getPlayerName(), $season),"name" => "$name", "tkls" => $tkls, "tfl" => $tfl, "tflyds" => $tflyds, "sks" => $sks, "skyds" => $skyds, "int" => $int, "intyds" => $intyds));
      }
    }
  }
}

// include proper template based on view
switch($view) {
  case "index": include_once($path->getFilePath("template_monitor_playerstats_index")); break;
  default: include_once($path->getFilePath("template_undefined")); break;
}

