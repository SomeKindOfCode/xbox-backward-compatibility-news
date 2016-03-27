<?php
// Setup Database
$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => __DIR__ . '/../db/db.sqlite'
]);

// Setup Controller
require 'controller/xbox.php';

// Setup Routes
require 'routes.php';
