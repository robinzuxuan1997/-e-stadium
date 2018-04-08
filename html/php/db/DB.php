<?php

class DB {


    public function getInstance() {

        $host = '127.0.0.1';
        $database = 'chat';
        $username = 'root';
        $password = 'cubano05';

        $db = new PDO("mysql:host=$host;dbname=$database",
        $username, $password);

        return $db;
    }
}
?>
