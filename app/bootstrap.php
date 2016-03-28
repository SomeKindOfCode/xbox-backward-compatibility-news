<?php
// Setup Database
$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => __DIR__ . '/../db/db.sqlite'
]);

Flight::set('flight.views.path', __DIR__ . '/../views');

// Setup Controller
require 'controller/cache.php';
require 'controller/xbox.php';

// Setup Routes
require 'routes.php';
