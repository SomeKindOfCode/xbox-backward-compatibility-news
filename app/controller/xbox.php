<?php

class XboxController {
    private static $importList = "http://www.xbox.com/en-US/xbox-one/backward-compatibility/bcglist.js";

    private static function slug($string) {
        $string = preg_replace('/[^a-zA-Z0-9]/', '', $string); // everything that is not a letter or number will be removed
        $string = trim($string); // remove trailing spaces
        $string = strtolower($string); // lowercase everything
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

    public static function import() {
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
                    "date_imported" => date("Y-m-d H:i:s")
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

    private static function getGames($where = []) {
        global $database;

        return $database->select(
            'games',
            '*',
            // Add possible overrides
            array_merge($where, [
                'ORDER' => 'date_imported DESC'
            ])
        );
    }

    private static function getGamesByWeek($where = []) {

        $cache = new Cache(sprintf('xb_bc_games_weekly_%s', json_encode($where)));

        $groupedGames = [];

        // Try grabbing the games from cache or rebuild it
        if(!$cache->has()) {
            // No Cache

            $beginningOfCurrentWeek = new DateTime('this week');
            $games = self::getGames($where);

            // Group by <YEAR>-<WeekNo>
            foreach($games as $singleGame) {
                $groupValue = DateTime::createFromFormat("Y-m-d H:i:s", $singleGame['date_imported'], new DateTimeZone('UTC'))->format('Y-W');
                $groupedGames[$groupValue][] = $singleGame;
            }

            $cache->set($groupedGames, 60*60); // TTL in seconds
        } else {
            // We have a cache
            $groupedGames = $cache->get();
        }

        return $groupedGames;
    }

    private static function feedChannel() {
        $xml = new SimpleXMLElement('<rss version="2.0"></rss>');
        $xml->addChild('channel');
        $xml->channel->addChild('title', 'Xbox Backward Compatibility');
        $xml->channel->addChild('link', 'http://xbox.somekindofcode.com');
        $xml->channel->addChild('description', 'A newsfeed informing you about new Xbox 360 games that are compatible with Xbox One.');
        $xml->channel->addChild('pubDate', (new DateTime())->format(DateTime::RSS));

        return $xml;
    }

    private static function HTMLforGamesArray($games) {
        $response = '<ul>';

        foreach($games as $game){
            $response .= sprintf(
                '<li><a href="%s">%s</a></li>',
                $game["url"],
                $game["name"]
            );
        }

        $response .= '</ul>';

        return $response;
    }

    /// - ROUTES

    public static function index() {
        self::importIfNeeded();

        Flight::render('xbox/index.php', [
            'gamesByWeek' => self::getGamesByWeek(),
            'gameCount' => count(self::getGames())
        ]);
    }

    public static function listWithSearch() {
        self::importIfNeeded();

        Flight::render('xbox/list.tpl', [
            'games' => self::getGames()
        ]);
    }

    public static function feed() {
        self::importIfNeeded();

        // Group Games by Year-Month-Day
        $groupedGames = [];

        $games = self::getGames([
            'date_imported[<]' => (new DateTime())->format('Y-m-d 00:00:00') // Don't include the current day
        ]);

        foreach($games as $singleGame) {
            $groupValue = DateTime::createFromFormat("Y-m-d H:i:s", $singleGame['date_imported'], new DateTimeZone('UTC'))->format('Y-m-d');
            $groupedGames[$groupValue][] = $singleGame;
        }

        // Render Feed
        $xml = self::feedChannel();

        foreach($groupedGames as $day => $gamesOfDay){
            $item = $xml->channel->addChild('item');

            $dateOfDay = DateTime::createFromFormat('Y-m-d', $day, new DateTimeZone('UTC'));

            $item->addChild('title', $dateOfDay->format('l, F jS Y')); // Week <WeekNo>
            $item->addChild('link', 'http://xbox.somekindofcode.com');
            $item->addChild('pubDate', $dateOfDay->format(DateTime::RSS));

            // Add Description as CDATA
            $item->description = NULL;
            $node = dom_import_simplexml($item->description);
            $no   = $node->ownerDocument;
            $node->appendChild($no->createCDATASection(self::HTMLforGamesArray($gamesOfDay)));
        }

        echo $xml->asXML();
    }

    public static function feedWeekly() {
        self::importIfNeeded();

        $weeklyGames = self::getGamesByWeek([
            'date_imported[<]' => $beginningOfCurrentWeek->format('Y-m-d 00:00:00') // Don't include the current week
        ]);

        $xml = self::feedChannel();

        foreach($weeklyGames as $week => $gamesOfWeek){
            $item = $xml->channel->addChild('item');

            // Parse <Week>-<Year> into a DateTime Object
            $input = explode('-', $week);
            list($year, $weekNo) = $input;

            $weekDate = new DateTime();
            $weekDate->setISODate($year, $weekNo);

            $item->addChild('title', $weekDate->format('\W\e\e\k W')); // Week <WeekNo>
            $item->addChild('link', 'http://xbox.somekindofcode.com');
            $item->addChild('pubDate', $weekDate->format(DateTime::RSS));

            // Add Description as CDATA
            $item->description = NULL;
            $node = dom_import_simplexml($item->description);
            $no   = $node->ownerDocument;
            $node->appendChild($no->createCDATASection(self::HTMLforGamesArray($gamesOfWeek)));
        }

        echo $xml->asXML();
    }
}
