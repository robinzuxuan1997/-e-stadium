<?php

require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_roster"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_drive"));

if (isset($_REQUEST['gameid']) && isset($_REQUEST['quarter'])) {
    $driveid = 0;
    if (isset($_REQUEST['driveid'])){
        $driveid = (INT) $_REQUEST['driveid'];
    }
    $gameid = (INT) $_REQUEST['gameid'];
    $quarter = (INT) $_REQUEST['quarter'];
    $setup = new Setup();
    $setup->loadCurrent();
    
    $game = new Game($gameid);
    
    $hometeam = new Team($game->getTeamID());
    $awayteam = new Team($game->getVisitorID());
    
    $pl = new Play();
    $v = new Video();
    $qnums = $pl->findUniqueQuartersByGameID($gameid);
    
    if ($driveid!=0){
        $x = $pl->findPlaysByDriveidOrdered($driveid);
        $p = $x->getOne();
        $quarter = $p->getQuarter();
        $x->reset();
    } else {
        $x = $pl->findPlaysByGameIDQuarter($gameid, $quarter);
    }
    
    
    $data = array();
    
    $valid_access_code = "2009";
    
    $quarters = $v->findQuartersByGameID($gameid);
    
    //The codes above are the same as getPlaysByGameIDQaurter.php
    //The codes below pushes the video-play pair using the energy index of videos in descending order
    //Which affects the order of those pairs in the Popular Play Page
    
    $xvids = $v->findApprovedVideosByQuarterGameIDEnergy($quarter, $gameid, true);
    
    $xvids = new Found($xvids);
    $vid = $xvids->getOne();
    
    
    
    
    while ($vid){// the loop stops when it can no longer get any video from $xvid
        preg_match("/([0-9]+)(_([0-9]+))?/", $vid->getVideoFileName(), $matches);
        $videonumber = $matches["1"];
        $anglenumber = $matches["3"];
        $vidtext = $vid->getPlayText();
        foreach ($x->internal as $play){
            //if play ID matches, push this video-play pair
            if ($vid->getPlayId()==$play->getID()){
                array_push($data,
                array(
                "videos" => array(array(
                "path" => $vid->getVideoPath(),
                "filename" => $vid->getVideoFileName(),
                "videonumber" => $videonumber,
                "anglenumber" => $anglenumber + 1
                )),
                "text" => $vidtext,
                "spot" => $play->getSpot(),
                "ball" => $play->getHasBall(),
                "togo" => $play->getToGo(),
                "type" => $play->getType(),
                "drive" => $play->getDriveNo()
                ));
                //take this play from $x (which is a "Found" objec that contains the list of plays in that game&quarter) to make the program run faster
                unset($play);
                $x = new Found($x->internal);
                break;
        }
    }
    //get next video
    $vid = $xvids->getOne();
}

echo json_encode($data);
}
?>