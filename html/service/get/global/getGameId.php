<?
require '../../jsonwrapper/jsonwrapper.php';

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));

$s = new Setup();
$s->loadCurrent();
$game = new Game($s->getActiveGameID());

$data = array();
$data['gameId'] = $game->getID();

echo json_encode($data);



?>
