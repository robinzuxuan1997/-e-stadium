<?php

if(!isset($_REQUEST["teamid"]) || !isset($_REQUEST['gameid'])){
	echo '{"fail"}';
	die(); // can't function w/o it
}

// deal with the eStadium current design, so we don't have to re-type it
require realpath(dirname(__FILE__) . '/../../jsonwrapper/jsonwrapper.php');
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
$g = new Game($_REQUEST['gameid']);

$total 		= $g->findGameTotalByTeamid($_REQUEST['teamid']);
$defense 	= $g->findTeamDefenseByTeamID($_REQUEST['teamid']);
$teamstats = $g->findTeamStatByTeamid($_REQUEST['teamid']);

$data = array();
$data['first_downs'] = (int)$teamstats->getFirstDowns();
$data['rush_fd'] = (int)$teamstats->getRushFirstDowns();
$data['pass_fd'] = (int)$teamstats->getPassFirstDowns();
$data['penalty_fd'] = (int)$teamstats->getPenaltyFirstDowns();

$data['net_rush_yds'] = (int)$teamstats->getRushNetYds();
$data['rush_att'] = (int)$teamstats->getRushAtt();
$data['rush_td'] = (int)$teamstats->getRushTD();
$data['rush_gained'] = (int)$teamstats->getRushGainedYds();
$data['rush_lost'] = (int)$teamstats->getRushLostYds();

$data['net_pass_yds'] = (int)$teamstats->getPassNetYds();
$data['pass_comp'] = (int)$teamstats->getPassComp();
$data['pass_att'] = (int)$teamstats->getPassAtt();
$data['pass_int'] = (int)$teamstats->getPassInt();
$data['pass_td'] = (int)$teamstats->getPassTD();

$data['tot_off_yds'] = (int)$teamstats->getTotalOffYds();

$data['fumble_cnt'] = (int)$teamstats->getFumbleCnt();
$data['fumble_lost'] = (int)$teamstats->getFumbleLost();

$data['penalty_cnt'] = (int)$teamstats->getPenaltyCnt();
$data['penalty_yds'] = (int)$teamstats->getPenaltyYds();

$data['punt_cnt'] = (int)$teamstats->getPuntCnt();
$data['punt_yds'] = (int)$teamstats->getPuntYds();
$data['punt_tb'] = (int)$teamstats->getPuntTB();
$data['punt_fc'] = (int)$teamstats->getPuntFC();
$data['punt_in20'] = (int)$teamstats->getPuntIn20();
$data['punt_plus50'] = (int)$teamstats->getPuntPlus50();

$data['kick_cnt'] = (int)$teamstats->getKickCnt();
$data['kick_yds'] = (int)$teamstats->getKickYds();

$data['kick_tb'] = (int)$teamstats->getKickTB();

$data['punt_ret_cnt'] = (int)$teamstats->getPuntRetCnt();
$data['punt_ret_yds'] = (int)$teamstats->getPuntRetYds();
$data['punt_ret_td'] = (int)$teamstats->getPuntRetTD();

$data['kick_ret_cnt'] = (int)$teamstats->getKickRetCnt();
$data['kick_ret_yds'] = (int)$teamstats->getKickRetYds();
$data['kick_ret_td'] = (int)$teamstats->getKickRetTD();

$data['int_cnt'] = (int)$teamstats->getIntCnt();
$data['int_yds'] = (int)$teamstats->getIntYds();
$data['int_td'] = (int)$teamstats->getIntTD();

$data['fumble_ret_cnt'] = (int)$teamstats->getFumbleRetCnt();
$data['fumble_ret_yds'] = (int)$teamstats->getFumbleRetYds();
$data['fumble_ret_td'] = (int)$teamstats->getFumbleRetTD();

$data['misc_yds'] = (int)$teamstats->getMiscYds();

$data['top'] = $teamstats->getToP();

$data['third_att'] = (int)$teamstats->getThirdDownAtt();
$data['third_conv'] = (int)$teamstats->getThirdDownConv();
$data['fourth_att'] = (int)$teamstats->getFourthDownAtt();
$data['fourth_conv'] = (int)$teamstats->getFourthDownConv();

$data['rz_att'] = (int)$teamstats->getRedZoneAtt();
$data['rz_conv'] = (int)$teamstats->getRedZoneConv();

$data['sacksby_cnt'] = (int)$teamstats->getSacksByCnt();
$data['sacksby_yds'] = (int)$teamstats->getSacksByYds();

$data['pat_conv'] = (int)$teamstats->getPATKickConv();
$data['pat_att'] = (int)$teamstats->getPATKickAtt();

$data['fg_conv'] = (int)$teamstats->getFGConv();
$data['fg_att'] = (int)$teamstats->getFGAtt();

//$data['first_downs'] = (int)1;

echo jsonp_encode($data,null);
?>
