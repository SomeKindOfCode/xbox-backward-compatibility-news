<?php

class XboxController {
    private static $importList = "http://www.xbox.com/en-US/xbox-one/backward-compatibility/bcglist.js";
    private static $apc_key = 'xb_bc_input';

    private static function slug($string) {
        $string = trim($string); // remove trailing spaces
        $string = strtolower($string); // lowercase everything
        $string = preg_replace('/\W/', '', $string); // everything that is not a letter will be removed
        return $string;
    }

    public static function getInput() {
        if (!apc_exists(self::$apc_key)) {
            $input_raw = file_get_contents(self::$importList);

            // Extract only the array of games
            preg_match('/var bcgames = (\[[\W\D\S]{0,}\])\;/i', $input_raw, $matches);
            $input_games_json = $matches[1];

            // FIX single quotes
            $input_games_json = preg_replace('/:[\s]*\'/', ':"', $input_games_json);
            $input_games_json = preg_replace('/\'[,]+/', '",', $input_games_json);
            $input_games_json = preg_replace('/\'[\n]+/', '"', $input_games_json);

            // FIX missing quotes on keys
            $input_games_json = preg_replace('/([\w]+):[\s ]*"/', '"$1":"', $input_games_json);

            // Parse the now valid JSON
            $input_games_array = json_decode($input_games_json, true);

            // place in cache
            apc_store(self::$apc_key, $input_games_array, 60 * 60); // Cache for an hour - TTL given in seconds

            return $input_games_array;
        } else {
            // Load from cache
            return apc_fetch(self::$apc_key);
        }
    }

    private static function import() {
        global $database;

        $input_games_array = self::getInput();

        // Grab slugs in database
        $current_slugs = $database->select('games', 'slug');

        $slugs = [];
        foreach ($input_games_array as $input_game) {
            $slugs[] =  self::slug($input_game["title"]);
        }


        echo "<pre>";
        print_r($current_slugs);
        echo "</pre>";
    }

    public static function index() {
        echo "Index Page";
    }

    public static function feed() {
        echo "Feed - Regular";
    }

    public static function feedWeekly() {
        echo "Feed - Weekly";
    }
}
