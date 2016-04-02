<?php
// Setup Database
$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => __DIR__ . '/../db/db.sqlite'
]);

// Register Smarty as the view class
Flight::register('view', 'Smarty', array(), function($smarty){
    $smarty->template_dir = __DIR__ . '/views/';
    $smarty->compile_dir = __DIR__ . '/views_c/';
    $smarty->config_dir = __DIR__ . '/config/';
    $smarty->cache_dir = __DIR__ . '/../cache/';

    $smarty->registerPlugin("modifier","DateTime", "dateTimeToDate");
    $smarty->registerPlugin("modifier","count", "count");
});
Flight::map('render', function($template, $data){
    Flight::view()->assign($data);
    Flight::view()->display($template);
});



function dateTimeToDate($input)
{
    return DateTime::createFromFormat('Y-m-d H:i:s', $input)->format('Y-m-d');
}

// Setup Controller
require 'controller/cache.php';
require 'controller/xbox.php';

// Setup Routes
require 'routes.php';
