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


$data = array();
$data['first_downs'] = (int)$total->getFirstDowns();
$data['rushyds'] = (int)$total->getRushYds();
$data['passyds'] = (int)$total->getPassYds();
$data['passcomp'] = (int)$total->getPassComp();
$data['passatt'] = (int)$total->getPassAtt();
$data['passint'] = (int)$total->getPassInt();
$data['totalyds'] = (int)$total->getRushYds() + (int)$total->getPassYds();
$data['totalplays'] = (int)$total->getRushAtt() + (int)$total->getPassAtt();
$data['rushatt'] = (int)$total->getRushAtt();
$data['kick_rtn_cnt'] = (int)$total->getKickReturnCnt();
$data['kick_rtn_yds'] = (int)$total->getKickReturnYds();
$data['punt_cnt'] = (int)$total->getPuntCount();
$data['punt_yds'] = (int)$total->getPuntYds();
$data['t_o_p'] = $total->getTimeOfPos();
$data['third_down_att'] = $total->getConvThirdAtt();
$data['third_down_conv'] = $total->getConvThirdConv();
$data['fourth_down_att'] = $total->getConvFourthAtt();
$data['fourth_down_conv'] = $total->getConvFourthConv();
$data['penalty_cnt'] = $total->getPenaltyTot();
$data['penalty_yds'] = $total->getPenaltyYds();
$data['sacks']	= (int)$defense->getSackua() + (int)$defense->getSacka();
$data['sackyds']			= (int)$defense->getSackyds();
$data['punt_rtn_cnt'] = (int)$total->getPuntReturnCnt();
$data['punt_rtn_yds'] = (int)$total->getPuntReturnYds();
$data['int_rtn_cnt'] = (int)$total->getIntReturnCnt();
$data['int_rtn_yds'] = (int)$total->getIntReturnYds();
$data['fumble_rtn_cnt'] = (int)$total->getFumbleReturnCnt();
$data['fumble_rtn_yds'] = (int)$total->getFumbleReturnYds();
$data['fumble_cnt'] = (int)$total->getFumbles();
$data['fumble_lost_cnt'] = (int)$total->getFumblesLostCnt();
$data['red_zone_conv'] = (int)$total->getRedZoneConv();
$data['red_zone_att'] = (int)$total->getRedZoneAtt();

echo jsonp_encode($data,null);
?>
