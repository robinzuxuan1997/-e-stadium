<?php

require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_video"));

if (isset($_REQUEST['gameid'])) {
      $gameid = (INT) $_REQUEST['gameid'];
      $quarter = (INT) $_REQUEST['quarter'];

      $game = new Game($gameid);

      $v = new Video();

      $quarters = $v->findQuartersByGameID($gameid);

      echo json_encode($quarters);
}
?>