<?php

require '../../jsonwrapper/jsonwrapper.php';
?>

<?

$valid_access_code = "2009";

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game"));

if (isset($_REQUEST['gameid']) && isset($_REQUEST['quarter'])) {
      $gameid = (INT)$_REQUEST['gameid'];
      $quarter = (INT)$_REQUEST['quarter'];

      $game = new Game($gameid);
      $home = new Team($game->getTeamID());
      $away = new Team($game->getVisitorID());
      $season = $game->getSeasonID();
      $homeacr = $home->getAcronym();
      $awayacr = $away->getAcronym();


      $v = new Video();

      $quarters = $v->findQuartersByGameID($gameid);

      foreach ($quarters as $q) {
            if ($quarter == $q) {
                  $found = true;
                  break;
            }
      }

      if (!$found)
            $quarter = $q; // set to last (max) quarter
// Get the list of Videos from the Database that we are interested in

      $x = $v->findApprovedVideosByQuarterGameID($quarter, $gameid, true);

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

      usort($x, "videoCompare");

      $videos = array();
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


      echo json_encode($videos);
}
?>



