<?php

include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_found"));

$all_games = new Game();

$active_games_found = $all_games->findActiveGames();

while ($active_game = $active_games_found->getOne()) {
    echo $active_game;
}

?>