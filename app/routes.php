<?php

Flight::route('/', ['XboxController', 'index']);
Flight::route('/feed', ['XboxController', 'feed']);
Flight::route('/feed/weekly', ['XboxController', 'feedWeekly']);
