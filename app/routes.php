<?php

// Flight supports arrays as controller and their static functions

Flight::route('/', ['XboxController', 'index']);
Flight::route('/list', ['XboxController', 'listWithSearch']);
Flight::route('/feed', ['XboxController', 'feed']);
Flight::route('/feed/weekly', ['XboxController', 'feedWeekly']);
