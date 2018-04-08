<?php

require '../../jsonwrapper/jsonwrapper.php';
//error_reporting(E_ALL);
//ini_set('display_errors','On');


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
	  //$data['curQuarter'] = $quarter;
      $valid_access_code = "2009";
      //Check::videoAccess($p);
      
	  //echo "quarter: ".$quarter." gameid: ".$gameid."<br/>";
	  $quarters = $v->findQuartersByGameID($gameid);
	  //echo "quarters:";
	  //print_r($quarters);
	  // Get the list of Videos from the Database that we are interested in
      $xvids = $v->findApprovedVideosByQuarterGameID($quarter, $gameid, true);
	  //echo "xvids: ".count($xvids);
	  //echo "quarters: ".count($v->findQuartersWithAssociatedVideosByGameID($gameid));
	  //$vidg = $v->findVideosByGameID($gameid,true);
	  //echo "vids: ".count($vidg);
	  //echo json_encode($vidg);
	  //print_r($vidg);
      function videoCompare($a, $b) {
            $apath = $a->getVideoPath();
            $bpath = $b->getVideoPath();
            $afilename = $a->getVideoFilename();
            $bfilename = $b->getVideoFilename();
            preg_match("/([0-9]+)(_([0-9]+))?/", $afilename, $amatches);
            preg_match("/([0-9]+)(_([0-9]+))?/", $bfilename, $bmatches);
            $afile = $amatches[1];
            $bfile = $bmatches[1];
            $aangle = $amatches[3];
            $bangle = $bmatches[3];
            if ($apath != $bpath)
                  return (strcmp($apath, $bpath)) ? 1 : -1;
            if ($afile != $bfile)
                  return ($afile < $bfile) ? 1 : -1;
            if ($aangle != $bangle)
                  return ($aangle < $bangle) ? 1 : -1;
            return 0;
      }

      usort($xvids, "videoCompare");
      //echo "xvids: ".$xvids;
      //print_r($xvids);
      $xvids = new Found($xvids);
      $pl = $x->getOne();
      $vid = $xvids->getOne();
      //echo "START vid id: ".$vid->getPlayId()." ".$pl->getID()." <br/>\n";
      while ($pl) {
            //Drives might span multiple quarters... so be sure to update the video array
            //There is probably a much better way to do this with sql, but I don't
            //have the time! We're at tech after all...
            if ($pl->getQuarter()<$quarter){
                $quarter = $pl->getQuarter();
                $xvids = new Found($v->findApprovedVideosByQuarterGameID(
                                   $quarter, $gameid, true));
                $vid = $xvids->getOne();
            }
            $vidpos = $xvids->last-1;
            //echo "VIDPos vid id: ".$vid->getPlayId()." ".$pl->getID()." <br/>\n";
			while ($vid){
				preg_match("/([0-9]+)(_([0-9]+))?/", $vid->getVideoFileName(), $matches);
	            $videonumber = $matches["1"];
	            $anglenumber = $matches["3"];
	            $last_video = count($data) - 1;
	            $qarr = $data[$last_video];
	            if (is_array($qarr) && is_array($qarr["videos"]) &&
	            	$qarr["videos"][0][videonumber] == $videonumber){
	            	//echo "add additional angle<br/>\n";
	            	 // Add a new angle to this set of videos
                  	array_push($data[$last_video]["videos"],
                              array("path" => $vid->getVideoPath(),
                                  "filename" => $vid->getVideoFileName(),
                                  "videonumber" => $videonumber,
                                  "anglenumber" => $anglenumber + 1));
                    $vid = $xvids->getOne();
                    break;
	            } else {
	            	$vidtext = $vid->getPlayText();
	            	$plytext = $pl->getText();
	            	/*if (strcmp($vidtext,$plytext)==0)*/
	            	//echo "vid id: ".$vid->getPlayId()." ".$pl->getID()." <br/>\n";
		            if ($vid->getPlayId()==$pl->getID()){
		            	// Add a new video as the first angle
	                  	array_push($data,
	                              	array(
	                              		"videos" => array(array(
	                              			  "path" => $vid->getVideoPath(),
		                                      "filename" => $vid->getVideoFileName(),
		                                      "videonumber" => $videonumber,
		                                      "anglenumber" => $anglenumber + 1
		                                 )),
	                              		"text" => $vidtext,
	                              		"spot" => $pl->getSpot(),
	                              		"ball" => $pl->getHasBall(),
	                              		"togo" => $pl->getToGo(),
			                        	"type" => $pl->getType(),
	                              		"drive" => $pl->getDriveNo()
	                              	));
	                     $pl = $x->getOne();
	                     $vid = $xvids->getOne();
	                     break;
	            	} else {
	            	    $vid = $xvids->getOne();
                        /*array_push($data, array(
		            		"text" => $pl->getText(),
		            		"spot" => $pl->getSpot(),
                          	"ball" => $pl->getHasBall(),
                        	"togo" => $pl->getToGo(),
                        	"type" => $pl->getType(),
                            "drive" => $pl->getDriveNo()));
            			$pl = $x->getOne();
            			*/
            			
	            	}
	            }
			} 
			if (!$vid) {
			    //echo "no video: ".$xvids->size()."<br/>\n";
				array_push($data, array(
		            		"text" => $pl->getText(),
		            		"spot" => $pl->getSpot(),
                          	"ball" => $pl->getHasBall(),
                        	"togo" => $pl->getToGo(),
                        	"type" => $pl->getType(),
                            "drive" => $pl->getDriveNo()));
	            $pl = $x->getOne();
	            $xvids->last = $vidpos;
	            $vid = $xvids->getOne();
			} else {
			    //echo "OK VIDEO------<br/>\n";
			}
      }
      
      /*
      foreach ($x as $v) {
            preg_match("/([0-9]+)(_([0-9]+))?/", $v->getVideoFileName(), $matches);
            $videonumber = $matches[1];
            $anglenumber = $matches[3];
            $last_video = count($videos) - 1;
            $qarr = $videos[$last_video];
            if (is_array($qarr) && $qarr[0][videonumber] == $videonumber) {
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
      while ($pl = $x->getOne()) {

            $row ['text'] = $pl->getText();
            array_push($data, $row);
		  }*/
	  //session_write_close();
      echo json_encode($data);
}
?>
