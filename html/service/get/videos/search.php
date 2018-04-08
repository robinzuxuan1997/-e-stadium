<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../../jsonwrapper/jsonwrapper.php';

$valid_access_code = "2009";

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_choices"));

$gameid = -1;
if (isset($_REQUEST['gameid']) && (int) $_REQUEST['gameid']>0){
	$gameid = (int) $_REQUEST['gameid'];	
}

$setup = new Setup();
$setup->loadCurrent();
if (!Game::idExists($gameid)) { 
  $gameid = $setup->getActiveGameID();
}

if (isset($_REQUEST["choices"])){
	$data = array();
	
		$game = new Game($gameid);
	$home = new Team($game->getTeamID());
	$away = new Team($game->getVisitorID());
	$season = $game->getSeasonID();
	$homeacr = $home->getAcronym();
	$awayacr = $away->getAcronym();

	$ch = new Choices();
														  
	$playerid_choices = $ch->getIdChoices("Roster",
					  false,
                      "findPlayersByTeamIDSeasonID",
                      array($game->getTeamID(), $setup->getActiveSeasonID()),
                      array("lname" => "getLName",
                            "fname" => "getFName",
                            "number" => "getNumber",
                            "id" => "getID",
                            "value" => "getID"));

	$data['players'] = $playerid_choices;
	
	echo json_encode($data);
	return;	
} else if (isset($_REQUEST["search"])){
	if ($_REQUEST["search"]=="type"){
		$playtype = $_REQUEST["type"];
		
		$playtext = $playtype;
		$playtype = strtolower($playtype);	
	} else {
		$playerid = (int) $_REQUEST['playerid'];
		$pl = new Roster($playerid);
  		$playtext = $pl->getLName();
	}
	
	$v = new Video();

	$x = $v->findApprovedVideosByGameidPlaytextSearch($gameid, $playtext, true);

    function videoCompare($a, $b) {
          $apath = $a->getVideoPath();
          $bpath = $b->getVideoPath();
          $afilename = $a->getVideoFilename();
          $bfilename = $b->getVideoFilename();
          preg_match("/([0-9]+)(_([0-9]+))?/", $afilename, $amatches);
          preg_match("/([0-9]+)(_([0-9]+))?/", $bfilename, $bmatches);
          $afile = $amatches[1];
          $bfile = $bmatches[1];
          if (count($amatches)>2){
	          $aangle = $amatches[3];
	          $bangle = $bmatches[3];
          } else {
          	  $aangle = 0;
          	  $bangle = 0;	
          }
          if ($apath != $bpath)
                return (strcmp($apath, $bpath)) ? 1 : -1;
          if ($afile != $bfile)
                return ($afile < $bfile) ? 1 : -1;
          if ($aangle != $bangle)
                return ($aangle < $bangle) ? 1 : -1;
          return 0;
    }

    usort($x, "videoCompare");

    $videos = array();
    foreach ($x as $v) {
          preg_match("/([0-9]+)(_([0-9]+))?/", $v->getVideoFileName(), $matches);
          $videonumber = $matches[1];
          if (count($matches)>2)
	          $anglenumber = $matches[3];
	      else
	      	  $anglenumber = 0;
          $last_video = count($videos) - 1;
          if ($last_video>=0)
	          $qarr = $videos[$last_video];
	      else
	      	  $qarr = null;
          if (is_array($qarr) && $qarr[0]['videonumber'] == $videonumber) {
                // Add a new angle to this set of videos
                array_push($videos[$last_video],
                            array("path" => $v->getVideoPath(),
                                "filename" => $v->getVideoFileName(),
                                "videonumber" => $videonumber,
                                "anglenumber" => $anglenumber + 1,
                                "text" => $v->getPlayText()));
          } else {
                // Add a new video as the first angle
                array_push($videos,
                            array(array("path" => $v->getVideoPath(),
                                    "filename" => $v->getVideoFileName(),
                                    "videonumber" => $videonumber,
                                    "anglenumber" => $anglenumber + 1,
                                    "text" => $v->getPlayText())));
          }
    }


    echo json_encode($videos);
}
?>