<?php
include_once "db.php";

$config = array(
    'DB_HOST' => 'localhost',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'root123',
    'DB_DATABASE' => 'login_db',
    'CHAR_SET' => 'utf8',
);
define("LOCAL_HOST_PATH", 'http://localhost:8082/exercise-files');

$db = new db($config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE'], $config['CHAR_SET']);