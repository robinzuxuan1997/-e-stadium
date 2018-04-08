<?
require_once("../global/global.php");
if(!isset($_REQUEST["teamid"]) || !isset($_REQUEST['gameid'])){
        #echo '{"fail"}';
        #die(); // can't function w/o it
        $gameid = $data['gameId'];
        $teamid = $data['homeId'];
} else {
        $gameid = (INT)$_REQUEST['gameid'];
        $teamid = (INT)$_REQUEST['teamid'];
}

require realpath(dirname(__FILE__) . '/../../jsonwrapper/jsonwrapper.php');
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_defense"));
include_once($path->getFilePath("class_player_game_stat"));
include_once($path->getFilePath("class_roster"));
include_once($path->getFilePath("class_field_goal_att"));

// Extraneous Setup
$setup = new Setup();
$setup->loadCurrent();
$season = $setup->getActiveSeasonID();

$game = new Game($gameid);
$team = new Team($teamid);
// check that there is a row in the PlayerGameStats table for this (teamid,gameid)
$pgs = $game->findPlayerGameStatsByTeamID($teamid);
$dfs = $game->findDefenseStatsByTeamID($teamid);
$fga = $game->findFieldGoalAttsByTeamID($teamid);

$teamname = $team->getAcronym();
$fullteamname = $team->getName();

$passers = array();
$rushers = array();
$receivers = array();
$punters = array();
$kickreturners = array();
$puntreturners = array();
$defense = array();
$returns = array();

$kickers = array();
$kickoffers = array();
$roster = new Roster();

while ($player = $pgs->getOne()) {
	// Special case: there is an extraneous "Team" player in the database
	if ($player->getName() == "Team") continue;
	if ($player->getName() == "TEAM") continue;
	$cp = $player->getPassComp();
	$att = $player->getPassAtt();
	$yds = $player->getPassYds();
	$tds = $player->getPassTds();
	$int = $player->getPassIntrcpt();
	$passlong = $player->getPassLong();
	$passsacks = $player->getPassSacks();
	if ($cp || $att || $yds || $tds || $int || $passlong || $passsacks) {
		array_push($passers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "cp" => $cp, "att" => $att, "yds" => $yds, "tds" => $tds, "int" => $int, "long" => $passlong, "sacks" => $passsacks));
	}
	$att = $player->getRushAtt();
	$rushgain = $player->getRushGainedYds();
	$rushloss = $player->getRushLostYds();
	$yds = $player->getRushNetYds();
	$tds = $player->getRushTds();
	$rushlong = $player->getRushLong();
	$rushavg = (intval($att) != 0) ? round(100*intval($yds)/intval($att))/100 : 0;
	if ($att || $yds || $tds || $rushgain || $rushloss || $rushlong) {
		array_push($rushers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "att" => $att, "gain" => $rushgain, "loss" => $rushloss, "yds" => $yds, "tds" => $tds, "long" => $rushlong, "avg" => $rushavg));
	}
	$rec = $player->getRecCnt();
	$yds = $player->getRecNetYds();
	$tds = $player->getRecTds();
	$reclong = $player->getRecLong();
	if ($rec || $yds || $tds) {
		array_push($receivers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "rec" => $rec, "yds" => $yds, "tds" => $tds, "long" => $reclong));
	}
	$punt = $player->getPuntCnt();
	$yds = $player->getPuntYds();
	$long = $player->getPuntLong();
	$puntavg = (intval($punt) != 0) ? round(100*intval($yds)/intval($punt))/100 : 0;
	$puntin20 = $player->getPuntIn20();
	$puntTB = $player->getPuntTB();
	if ($punt || $yds || $long || $puntavg || $puntin20 || $puntTB) {
		array_push($punters, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "punt" => $punt, "yds" => $yds, "long" => $long, "avg" => $puntavg, "puntin20" => $puntin20, "punttb" => $puntTB));
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
	
	$puntret = $player->getPuntRetCnt();
	$puntyds = $player->getPuntRetYds();
	$puntlong = $player->getPuntRetLong();
	$kickret = $player->getKickRetCnt();
	$kickyds = $player->getKickRetYds();
	$kicklong = $player->getKickRetLong();
	if ($puntret || $puntyds || $puntlong || $kickret || $kickyds || $kicklong) {
		array_push($returns, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "puntret" => $puntret, "puntyds" => $puntyds, "puntlong" => $puntlong, "kickret" => $kickret, "kickyds" => $kickyds, "kicklong" => $kicklong));
	}
	
	
	$kickoffcnt = $player->getKickoffCnt();
	$kickoffyds = $player->getKickoffYds();
	$kickofftb = $player->getKickoffTB();
	$kickoffob = $player->getKickoffOB();
	if ($kickoffcnt || $kickoffyds || $kickofftb || $kickoffob)
	{
		array_push($kickoffers, array("id" => $roster->findPlayeridByNameSeasonID($player->getName(), $season),"name" => $player->getName(), "kickoffcnt" => $kickoffcnt, "kickoffyds" => $kickoffyds, "kickofftb" => $kickofftb, "kickoffob" => $kickoffob));
	}
	
	
}

while ($d = $dfs->getOne()) {
	$name = $d->getPlayerName();
	if ($name != "TEAM") {
		$tkls = $d->getTackua() + $d->getTacka();
		$dtackua = $d->getTackua();
		$dtacka = $d->getTacka();
		$tfl = $d->getTflua() + $d->getTfla();
		$tflyds = $d->getTflyds();
		$sks = $d->getSackua() + $d->getSacka();
		$skyds = $d->getSackyds();
		$int = $d->getInter();
		$intyds = $d->getInteryds();
		if ($tkls || $tfl || $tflyds || $sks || $skyds || $int || $intyds || $dtackua || $dtacka) {
			array_push($defense, array("id" => $roster->findPlayeridByNameSeasonID($d->getPlayerName(), $season),"name" => "$name", "tkls" => $tkls, "tkua" => $dtackua, "tka" => $dtacka, "tfl" => $tfl, "tflyds" => $tflyds, "sks" => $sks, "skyds" => $skyds, "int" => $int, "intyds" => $intyds));
		}
		
		if ($int || $intyds)
		{
			array_push($returns, array("id" => $roster->findPlayeridByNameSeasonID($d->getPlayerName(), $season),"name" => "$name", "intret" => $int, "intyds" => $intyds));
		}
	}
}


while ($fgp = $fga->getOne())
{

	$name = $fgp->getKicker();
	$dist = $fgp->getDistance();
	$qtr = $fgp->getQuarter();
	$time = $fgp->getTime();
	$res = $fgp->getResult();
	
	if ($name || $dist || $qtr || $time || $res)
	{
		array_push($kickers, array("name" => $name, "dist" => $dist, "qtr" => $qtr, "time" => $time, "result" => $res));
	}
}


//-------------------output------
$data['teamname'] = $teamname;
$data['fullteamname'] = $fullteamname;
$data['passers'] = $passers;
$data['rushers'] = $rushers;
$data['receivers'] = $receivers;
$data['punters'] = $punters;
$data['kickreturners'] = $kickreturners;
$data['puntreturners'] = $puntreturners;
$data['defense'] = $defense;
$data['kickers'] = $kickers;
$data['kickoffers'] = $kickoffers;
$data['allreturns'] = $returns;
//$data['roster'] = $roster;

echo jsonp_encode($data,null);

?>
