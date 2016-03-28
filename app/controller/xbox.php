<?php

class XboxController {
    private static $importList = "http://www.xbox.com/en-US/xbox-one/backward-compatibility/bcglist.js";

    private static function slug($string) {
        $string = trim($string); // remove trailing spaces
        $string = strtolower($string); // lowercase everything
        $string = preg_replace('/\W/', '', $string); // everything that is not a letter will be removed
        return $string;
    }

    private static function getInput() {
        $cache = new Cache('xb_bc_input');

        if (!$cache->has()) {
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
            $cache->set($input_games_array, 60 * 60); // Cache for an hour - TTL given in seconds

            return $input_games_array;
        } else {
            // Load from cache
            return $cache->get();
        }
    }

    private static function import() {
        global $database;
        $new_games = [];

        $input_games_array = self::getInput();

        // Grab slugs in database
        $current_slugs = $database->select('games', 'slug');

        foreach($input_games_array as $input_game) {
            $input_slug = self::slug($input_game["title"]);

            if(!in_array($input_slug, $current_slugs)) {
                // game is new
                $new_games[] = [
                    "name" => $input_game["title"],
                    "slug" => $input_slug,
                    "image" => $input_game["image"],
                    "url" => $input_game["url"],
                    "date_imported" => date("d-m-Y H:i:s")
                ];
            }
        }

        // Insert new games
        if(count($new_games) > 0){
            $database->insert('games', $new_games);
        }
    }

    private static function importIfNeeded() {
        $cache = new Cache('xb_bc_input');
        if (!$cache->has()) {
            self::import();
        }
    }

    /// - ROUTES

    public static function index() {
        global $database;

        self::importIfNeeded();

        $cache = new Cache('xb_bc_index');

        $groupedGames = [];

        // Try grabbing the games from cache or rebuild it
        if(!$cache->has()) {
            // No Cache
            $games = $database->select('games', '*');

            foreach($games as $singleGame) {
                $groupValue = DateTime::createFromFormat("d-m-Y H:i:s", $singleGame['date_imported'])->format('W-Y');
                $groupedGames[$groupValue][] = $singleGame;
            }

            $cache->set($groupedGames, 60*60); // TTL in seconds
        } else {
            // We have a cache
            $groupedGames = $cache->get();
        }


        Flight::render('xbox/index.php', array('gamesByWeek' => $groupedGames));
    }

    public static function feed() {
        self::importIfNeeded();
        echo "Feed - Regular";
    }

    public static function feedWeekly() {
        self::importIfNeeded();
        echo "Feed - Weekly";
    }
}
