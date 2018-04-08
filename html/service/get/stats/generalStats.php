<?php
require_once 'stats.php';
$data = array();
$data['scoreQ1'] = (int)$total->getScoreFirstQ();
$data['scoreQ2'] = (int)$total->getScoreSecondQ();
$data['scoreQ3'] = (int)$total->getScoreThirdQ();
$data['scoreQ4'] = (int)$total->getScoreFourthQ();
$data['scoreF']  = (int)$total->getFinalScore();
$data['firstDowns'] 	= (int)$total->getFirstDowns();
$data['thirdAttempts'] 	= (int)$total->getConvThirdAtt();
$data['thirdConvs'] 	= (int)$total->getConvThirdConv();
$data['fourthAttempts'] = (int)$total->getConvFourthAtt();
$data['fourthConvs']	= (int)$total->getConvFourthConv();
$data['passYds'] 	= (int)$total->getPassYds();
$data['passComp'] 	= (int)$total->getPassComp();
$data['passAtt'] 	= (int)$total->getPassAtt();
$data['rushYds'] 	= (int)$total->getRushYds();
$data['rushAtt']	= (int)$total->getRushAtt();
$data['penaltyYds']	= (int)$total->getPenaltyYds();
$data['penaltyTot']	= (int)$total->getPenaltyTot();
$data['turnovers']['fumbles']	= (int)$total->getFumbles();
$data['turnovers']['interceptions']	= (int)$total->getPassInt();
$data['timeOfPos'] 	= $total->getTimeOfPos();
$data['kickReturnCnt']	= (int)$total->getKickReturnCnt();
$data['kickReturnYds']	= (int)$total->getKickReturnYds();
$data['kickReturnLong']	= (int)$total->getKickReturnLong(); 
$data['puntCount']	= (int)$total->getPuntCount();
$data['puntLong']	= (int)$total->getPuntLong(); 
$data['fumbles']['forced'] 		= (int)$defense->getFf();
$data['fumbles']['recovered'] 	= (int)$defense->getFr();
$data['fumbles']['getFryds'] 	= (int)$defense->getFryds();
$data['inter']['num']	= (int)$defense->getInter();
$data['inter']['yds']	= (int)$defense->getInteryds();
$data['tackles']['number']	= (int)$defense->getTackua() + (int)$defense->getTacka();
$data['tackles']['tfl']		= (int)$defense->getTflua() + (int)$defense->getTfla();
$data['tackles']['tflyds']	= (int)$defense->getTflyds();
$data['tackles']['sacks']	= (int)$defense->getSackua() + (int)$defense->getSacka();
$data['sackyds']			= (int)$defense->getSackyds();

echo jsonp_encode($data,null);
?>

