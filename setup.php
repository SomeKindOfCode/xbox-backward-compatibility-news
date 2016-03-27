<?php

require 'vendor/autoload.php';
require 'app/bootstrap.php';

// SQLite3
$database->query('CREATE TABLE IF NOT EXISTS games (
	id     INT     PRIMARY KEY,
	name   TEXT,
    slug   TEXT,
    image  TEXT
)');
