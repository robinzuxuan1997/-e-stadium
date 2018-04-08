<?
require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_scoring_drive"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_video"));

	$s = new Setup();
	$s->loadCurrent();

	if(isset($_REQUEST['gameid']))
		$gameid = (INT)$_REQUEST['gameid'];
	else
		$gameid = $s->getActiveGameID();

	$game = new Game($gameid);

	$d = new Drive();
	$sd = new ScoringDrive();
	$p = new Play();
	$v = new Video();

	$drives=$d->findDrivesByGameID($gameid, true);
	$scoringdrives = $sd->findScoringDrivesByGameID($gameid, true);

	$temp = array();	

	for($i=0;$i<count($scoringdrives);$i++)
		$temp[$i] = $scoringdrives[$i];

	array_multisort($temp, $scoringdrives);	

	for($i=0;$i<count($scoringdrives);$i++)
	{
		if($scoringdrives[$i]->getScoreHow()=="INT" || $scoringdrives[$i]->getScoreHow()=="FGA")			
			$plays = $p->findPlaysByDriveidOrdered($drives[$scoringdrives[$i]->getSDIndex()-1]->getID()-1, true);
		else 
			$plays = $p->findPlaysByDriveidOrdered($drives[$scoringdrives[$i]->getSDIndex()-1]->getID(), true);

		for($k=0;$k<count($plays);$k++)				
		{
			if(preg_match("/TOUCHDOWN/", $plays[$k]->getText()) || preg_match("/GOOD/", $plays[$k]->getText()))
			{
				$text = $plays[$k]->getText();

				$text = substr($text, 0, strrpos($text, " "));
				$text = substr($text, 0, strrpos($text, ", "));

				$video = $v->findVideoByPlayid($plays[$k]->getID());
		
				preg_match("/([0-9]+)(_([0-9]+))?/", $video->getVideoFileName(), $matches);
       				$videonumber = $matches["1"];
			        $anglenumber = $matches["3"];
				
				$vid = array("path" => $video->getVideoPath(),
				"filename" => $video->getVideoFileName(),
				"videonumber" => $videonumber,
				"anglenumber" => $anglenumber + 1);
				break;
			}
		}		

		$quarters[$scoringdrives[$i]->getQuarter()][] = array("HScore" => $scoringdrives[$i]->getHScore(), 
			"VScore" =>$scoringdrives[$i]->getVScore(), "Team" => $scoringdrives[$i]->getTeamID(), 
			"ScoreType" => $scoringdrives[$i]->getScoreType(), "ClockTime" => $scoringdrives[$i]->getClockTime(), 
			"Scorer" => $scoringdrives[$i]->getScorer(), "Text" => $text, "Video" => $vid);	
$text = "";
	}

	echo json_encode($quarters);
?>
