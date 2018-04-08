<?

require '../../jsonwrapper/jsonwrapper.php';
include_once(realpath(dirname(__FILE__) . "/../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));

$s = new Setup();
$s->loadCurrent();
$game = new Game($s->getActiveGameID());

$data = array();

$pl = new Play();
$rp = $pl->findMostRecentPlayByGameID($game->getID());
$data['hasBall'] = $rp->getHasBall();

json_encode($data);

?>
