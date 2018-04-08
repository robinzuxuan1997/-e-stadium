<?php
require '../../jsonwrapper/jsonwrapper.php';
?>

<?php

$data = array();

$data['mlb'] = "MLB";
$data['nba'] = "NBA";
$data['ncf'] = "NCAA Football";
$data['nfl'] = "NFL";
$data['nhl'] = "NHL";

echo json_encode($data);

//<select name="scores" onchange="Score.submit();">
//
//<option value="mlb">MLB</option>
//<option value="nba">NBA</option>
//<option value="ncaaf">NCAA Football</option>
//<option value="nfl">NFL</option>
//<option value="nhl">NHL</option>

?>
