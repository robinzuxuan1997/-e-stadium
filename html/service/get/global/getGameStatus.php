<?php

require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_play"));

if (isset($_REQUEST['gameid'])) {

      $gameid = $_REQUEST['gameid'];
      $game = new Game($gameid);

      $pl = new Play();
      $rp = $pl->findMostRecentPlayByGameID($game->getID());

      $hasball = $rp->getHasBall();

      $homeball = false;
      $awayball = false;

      if ($hasball == "H") {
            $homeball = true;
      } else if ($hasball == "V") {
            $awayball = true;
      }

      $quarter = $rp->getQuarter();
      $time = $rp->getClock();
      $text = $rp->getText();
      $end_game_text = ("End of game");
      $end_half_text = ("End of half");

//Get the time and display it on the header
//if ($time) $time_prev = $time;
//if ($time==null) $time = $time_prev;
      if ($quarter > 4)
            $time = "";

      else {

      }
      $OT_value = $quarter - 4;

      if ($quarter > 4)
            $quarter_text = "OT #" . $OT_value;
      if ($quarter == 4)
            $quarter_text = "4th";
      if ($quarter == 3)
            $quarter_text = "3rd";
      if ($quarter == 2)
            $quarter_text = "2nd";
      if ($quarter == 1)
            $quarter_text = "1st";


//If a game has ended, display Final
//Information on how the code was edited for "Final" and "Halftime" on vip wiki

        if ($quarter != 1 && $quarter != 2 && $quarter != 3 && (strlen(strstr($text, $end_game_text)) > 0)) {
            $quarter_text = "Final";
      }

//Tell if it is halftime

      if ($quarter != 1 && ($quarter == 2 || $quarter == 3)
        && $quarter != 4 && strlen(strstr($text, $end_half_text)) > 0) {
            $quarter_text = "Halftime";
            $time = "0:00";
      }


     ///-----------------------------------------

      $data = array();

      if(strcasecmp('00:00', $time) == 0){
      	$time = "-";
      }


      $data['homeHasBall'] = $homeball;
      $data['visitorHasBall'] = $awayball;
      $data['time'] = $time;
      $data['text'] = $quarter_text;
      $data['quarter'] = $quarter;
      $data['recentplay'] = $text;

      echo json_encode($data);
}
?>
