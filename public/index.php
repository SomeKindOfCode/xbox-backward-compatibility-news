<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::start();
