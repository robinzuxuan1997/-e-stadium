<?php
/*
Provides information for the video association page

ex:
?method=list&mode=existing&time=1232432391231 &quarter=Q

TODO: Make much more efficient...
*/

/*
Ensure is admin
*/
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
//require '../../service/jsonwrapper/jsonwrapper.php';

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');


include_once($path->getFilePath("class_session")); ////Session::isAdmin()
$data = array();

function pageError($msg){
	$data['error'] = $msg;
	echo json_encode($data);
	return;	
}

if (!Session::isAdmin()){
	$data['error'] = "Access Denied";
	
	//echo json_encode($data);	
	//return;
} else {
	$data['access'] = "Admin";
}
$data['processing'] = "true";
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_scripts_global_settings"));
	
	
GlobalSettings::load("site_links"); // creates $SETTINGS array
$setup = new Setup();
$setup->loadCurrent();

$method = $_REQUEST['method'];

//associate,list
if (!isset($_REQUEST['method'])){
	$method = "list";
} else {
	if ($method == "assoc") {
		$videoid = (int) $_REQUEST['videoid'];
		$playid = (int) $_REQUEST['playid'];
		$data['videoid'] = $videoid;
		$data['playid'] = $playid;
	} else {//default to list
		$method = "list";
	}
}
$mode = $_REQUEST['mode'];
if (!isset($_REQUEST['mode']) or $mode!="existing"){
	$mode = "new";
}
$time = (int) $_REQUEST['time'];
$data['method']=$method;
$data['mode']=$mode;
$data['time']=$time;
	
$quarter = (int) $_REQUEST['quarter'];

if ($method == "assoc"){
	$video = new Video($videoid);
	$pl = new Play($playid);
	if (!$video->idValid()) {
		pageError("Video id $videoid does not exist in the database!");
	}
	//$pl = new Play($playid);
	if ($pl->getID() != "" && $pl->getID() != 0 && !$pl->idValid()) {
     	pageError("Playid '$playid' does not exist in database!");
    }
    elseif ($pl->idValid() && $pl->getQuarter() != $video->getQuarter()) {
     	pageError("Quarter (".$pl->getQuarter().") for Playid (".$playid.") does not match video quarter (".$video->getQuarter().")!");
    }
    // have not approved yet
    if ($video->getApproved != "Y" && $video->getApproved() != "N") { 
     	$video->setApprovedTime(Check::formatDate(time(), "epoch", "mysql_datetime"));
    }
    $video->setApproved("Y");

    if ($pl->getID() > 0) { // 0 is non-associated play
	    $check_text = trim(preg_replace("/Recent Play/", "", $video->getPlayText()));
	    if ($video->getPlayid() < 1) {
	      	$video->setAssociatedTime(Check::formatDate(time(), "epoch", "mysql_datetime"));
	    }
	    $video->setPlayid($pl->getID());
	    $video->setPlayText($pl->getText());
    } else { // not associating play here
    	//echo "Play id = 0";
	    if ($video->getApproved() == "Y") {
	    	//echo "Cleared ID<br>";
	    	$video->setApproved("N");
	    	$video->setPlayid($pl->getID());
	      	$video->setPlayText("Recent Play");
	    }
    }

    $video->save();
    
    $method = "list";
    //echo json_encode($data);	
	//return;
}

if ($method == "list"){
	$v = new Video();
	if ($mode=="new") {
	  $quarters = $v->findQuartersWithNonAssociatedVideosByGameID($setup->getActiveGameID());
	  if (count($quarters) < 1) $quarters = array(1);
	  if (!in_array($quarter, $quarters)) {// don't have a quarter set that has any videos, so default to oldest quarter
	    $quarter = min($quarters);
	  }
	  $dbvideos = $v->findNonAssociatedVideosByGameIDQuarter($setup->getActiveGameID(), $quarter);
	} 
	elseif ($mode=="existing") {
	  $quarters = $v->findQuartersWithAssociatedVideosByGameID($setup->getActiveGameID());
	  if (count($quarters) < 1) $quarters = array(1);
	  if (!in_array($quarter, $quarters)) {// don't have a quarter set above that has any videos, so default to newest quarter
	    $quarter = max($quarters);
	  }
	  $dbvideos = $v->findAssociatedVideosByGameIDQuarter($setup->getActiveGameID(), $quarter);
	}
	$data['quarter'] = $quarter;
	$data['quarters'] = $quarters;
	//$data['videos'] = $dbvideos;
	$videos = array();
	foreach($dbvideos as $v) {
		$filenum = preg_replace("/_[0-9]+/", "", $v->getVideoFilename());
		if (!is_array($videos[$filenum])) $videos[$filenum] = array(); // first angle for this file number
	  		array_push($videos[$filenum], array("filename" => $v->getVideoFilename(),
	                                      "videoid"  => $v->getID(),
	                                      "webpath"  => $v->getVideoPath(),
	                                      "approved" => $v->getApproved(),
	                                      "playid"   => $v->getPlayID(),
	                                      "old_text" => $v->getPlayText()));
	}
	$data['videos'] = $videos;
	
	$playid_choices = Choices::getPlaybyPlayChoices($setup->getActiveGameID(), $quarter);
	
	$data['choices'] = $playid_choices;
	
	$data['transdirs'] = $SETTINGS['trans_dirs'];
	$data['extensions'] = $SETTINGS['transcode_extensions'];
	
	$pathbase = array();
	$pathbase['stream'] = $path->getLinkPath("link_video_stream_base");
	$pathbase['download'] = $path->getLinkPath("link_video_download_base");
	
	$data['path'] = $pathbase;
}

echo json_encode($data);	
echo "\n\n";
?>