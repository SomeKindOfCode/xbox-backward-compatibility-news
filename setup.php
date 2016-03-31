<?php

require 'vendor/autoload.php';
require 'app/bootstrap.php';

// SQLite3
$database->query('CREATE TABLE IF NOT EXISTS games (
	id     			INTEGER     PRIMARY KEY 	AUTOINCREMENT,
	name   			TEXT,
    slug   			TEXT,
    image  			TEXT,
    url  			TEXT,
	date_imported 	DATETIME
)');

// Make an initial import
XboxController::import();

// Redate games
$datedGames = [
	// Arrival of BC
	'2015-11-09' => [
		'akingdomforkeflings', 'aworldofkeflings', 'alienhominidhd', 'assassinscreedii', 'asteroidsdeluxe', 'banjokazooie', 'banjokazooiennb', 'banjotooie', 'battleblocktheater', 'bejeweled2', 'bellatormmaonslaught', 'beyondgoodevilhd', 'bloodofthewerewolf', 'bloodraynebetrayal', 'borderlands', 'callofjuarezgunslinger', 'castlecrashers', 'castlestorm', 'centipedemillipede', 'condemned', 'crazytaxi', 'deadliestwarriorlegends', 'defensegrid', 'dirt3', 'dirtshowdown', 'discsoftron', 'doom', 'doomii', 'dungeonsiegeiii', 'earthwormjimhd', 'fableii', 'fallout3', 'feedingfrenzy', 'feedingfrenzy2', 'gearsofwar', 'gearsofwar2', 'gearsofwar3', 'gearsofwarjudgment', 'geometrywarsevolved', 'goldenaxe', 'halospartanassault', 'hardwoodbackgammon', 'hardwoodhearts', 'hardwoodspades', 'heavyweapon', 'hexichd', 'ikaruga', 'jetpacrefuelled', 'joyrideturbo', 'justcause2', 'kameo', 'legopiratesofthecaribbeanthevideogame', 'legostarwarstcs', 'loderunner', 'lumineslive', 'masseffect', 'metalslug3', 'metalslugxx', 'mightmagicclashofheroes', 'mirrorsedge', 'missilecommand', 'mondaynightcombat', 'monkeyisland2se', 'monkeyislandse', 'mssplosionman', 'mutantblobsattack', 'n', 'nbajamonfireedition', 'nightsintodream', 'ofdragonrising', 'pacmance', 'pacmancedx', 'perfectdark', 'perfectdarkzero', 'phantombreakerbattlegrounds', 'pinballfx', 'plantsvszombies', 'princeofpersia', 'puttysquad', 'rayman3hd', 'rtypedimensions', 'sacredcitadel', 'segavintagecollectionalexkiddco', 'segavintagecollectiongoldenaxe', 'segavintagecollectionmonsterworld', 'segavintagecollectionstreetsofrage', 'shadowcomplex', 'soniccd', 'sonicthehedgehog', 'sonicthehedgehog2', 'sonicthehedgehog3', 'supermeatboy', 'supremecommander2', 'tcsrainbowsixvegas', 'tcsrainbowsixvegas2', 'thestickoftruth', 'torchlight', 'toysoldiers', 'toysoldierscoldwar', 'tronevolution', 'uglyamericansapocalypsegeddon', 'vivapiata', 'vivapiatatroubleinparadise', 'wolfenstein3d', 'zuma'
	],
	'2015-12-16' => ['sacred3'],
	'2015-12-17' => ['braid', 'deusexhumanrevolution', 'doritoscrashcourse', 'fableiii', 'haloreach', 'hydrothunder', 'ironbrigade', 'kanelynch2', 'motocrossmadness', 'mspacman', 'peggle', 'portalstillalive', 'sacred3', 'spelunky', 'splosionman', 'tickettoride', 'zumasrevenge'],
	'2016-01-21' => ['aegiswing', 'ageofbooty', 'counterstrikego', 'jeremymcgrathsoffroad', 'sammaxsavetheworld', 'skullgirls', 'smallarms', 'soulcalibur', 'spacegiraffe', 'thewitcher2assassinsofkings'],
	'2016-02-11' => ['alanwakesamericannightmare', 'legobatman', 'sammaxbeyondtimeandspace', 'trialshd'],
	'2016-02-15' => ['galaga'],
	'2016-02-25' => ['geometrywarsevolved'],
	'2016-02-26' => ['carcassonne'],
	'2016-03-17' => ['alanwake', 'castlevaniasotn', 'pacman'],
	'2016-03-21' => ['assassinscreed', 'darkvoid', 'grid2'],
	'2016-03-23' => ['darksouls', 'tekkentagtournament2'],
	'2016-03-28' => ['halowars', 'soulcaliberiihd', 'thekingoffighters98'],
	'2016-03-29' => ['left4dead2'],
	'2016-03-30' => ['deadspace'],
	'2016-03-31' => ['saintsrowiv']
];

foreach($datedGames as $date => $gameArray) {
	$dateObj = DateTime::createFromFormat('Y-m-d', $date);
	$database->update('games', [
		'date_imported' => $dateObj->format('Y-m-d 12:00:00') // Just set them to noon
	],
	[
		'slug' => $gameArray
	]);
}
