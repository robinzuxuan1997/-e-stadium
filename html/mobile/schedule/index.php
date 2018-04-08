<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_location"));
include_once($path->getFilePath("class_season"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_location"));

$p = new Page("mobile", "public", "page_schedule");

$p->register("season", "hidden", array("setget" => "none"));

$setup = new Setup();
$setup->loadCurrent();

$s = new Season();
if (!Season::idExists($s->findIDBySeasonID($season))) {
  // season passed does not exist in the database
  $season = $setup->getActiveSeasonID();
}

$g = new Game();
$gms = $g->findGamesBySeasonID($season);

$games = array();
while ($g = $gms->getOne()) {
  $date = Check::formatDate($g->getStart(), 2, 1);
  $team = new Team($g->getVisitorID());
  $location = new Location($g->getLocationID());
  if ($location->getName() == "Ross-Ade Stadium") {
    $loc = "";
  } else {
    $loc = "at ";
  }
  $homegt = $g->findGameTotalByTeamID($g->getTeamID());
  $awaygt = $g->findGameTotalByTeamID($g->getVisitorID());
  if (   $g->getActive() == "2" 
      && ($homegt->getWL() == "W" || $awaygt->getWL() == "L")
      && Check::isInt($homegt->getFinalScore())
      && Check::isInt($awaygt->getFinalScore())               ) { // game is completed, show W/L and score
    $resulttime = $homegt->getWL() . " " . $homegt->getFinalScore() . "-" . $awaygt->getFinalScore();
  } else { // game is not completed yet, show time as TBD or time
    if ($g->getTimeTBD() == 1) {
      $resulttime = "TBD";
    } else {
      $resulttime = Check::formatDate($g->getStart(), 2, 2);
    }
  }
  array_push($games, array("date" => $date,
                           "opponent" => $loc . $team->getName(),
                           "resulttime" => $resulttime));
}

$p->startTemplate();
?>
<center><font class="mobile_h1"><u><?=$season?> Schedule</u><br></font></center>
<table width=100% border=0>
  <tr>
    <th>DATE</th>
    <th>OPPONENT</th>
    <th>RESULT/TIME</th>
  </tr>
  <?foreach($games as $g) {?>
  <tr>
    <td align=right><?=$g[date]?></td>
    <td><?=$g[opponent]?></td>
    <td><?=$g[resulttime]?></td>
  </tr>
  <?}?>
</table>

<?
$p->close();
?>
