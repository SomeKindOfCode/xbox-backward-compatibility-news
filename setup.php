<?php

require 'vendor/autoload.php';
require 'app/bootstrap.php';

// SQLite3
$database->query('CREATE TABLE IF NOT EXISTS games (
	id     INTEGER     PRIMARY KEY 	AUTOINCREMENT,
	name   TEXT,
    slug   TEXT,
    image  TEXT
)');


var_dump($database->error());
