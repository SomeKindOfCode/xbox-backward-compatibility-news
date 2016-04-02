<!DOCTYPE html>
<html>
    <head>
        <title>New Xbox Backward Compatibility Games</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <style>
            html, body {
                margin: 0px;
                font-family: -apple-system, Helvetica, Arial, sans-serif;
                background: #333;
                color: white;
            }
            h1, h2, h3 {
                font-weight: lighter;
            }
            .container {
                margin: 15px auto;
                max-width: 920px;
            }
            .feeds {
                text-align: center;
                margin: 0px auto;
            }
            .feeds a {
                color: white;
                text-decoration: none;
            }
            .feed {
                background: #f60;
                display: inline-block;
                border-radius: 10px;
                padding: 5px 10px;
            }
            .feed:hover {
                opacity: 0.4;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Weekly Backwards Compatibility</h1>
            <p>Current Game Count: <?= $gameCount; ?></p>

            <div class="feeds">
                <a href="/feed">
                    <div class="feed">
                        <i class="fa fa-rss"></i> Daily
                    </div>
                </a>
                <a href="/feed/weekly">
                    <div class="feed">
                        <i class="fa fa-rss"></i> Weekly
                    </div>
                </a>
            </div>

            <h3>IFTTT</h3>
            <a href="https://ifttt.com/view_embed_recipe/403631-xbox-backward-compatibility-push" target = "_blank" class="embed_recipe embed_recipe-l_32" id= "embed_recipe-403631"><img src= 'https://ifttt.com/recipe_embed_img/403631' alt="IFTTT Recipe: Xbox Backward Compatibility Push connects feed to pushover" width="370px" style="max-width:100%"/></a>

            <?php foreach($gamesByWeek as $week => $weeklyGames){ ?>
                <h2>
                    <?php
                    $input = explode('-', $week);
                    list($year, $weekNo) = $input;

                    $weekDate = new DateTime();
                    $weekDate->setISODate($year, $weekNo);

                    echo $weekDate->format('\W\e\e\k W - Y');
                    ?>
                </h2>
                <?php foreach($weeklyGames as $singleGame){ ?>
                    <a href="<?= $singleGame["url"] ?>" target="_blank" rel="nofollow"><img src="<?= $singleGame["image"] ?>"\></a>
                <?php } ?>
            <?php } ?>
        </div>

        <script async type="text/javascript" src= "//ifttt.com/assets/embed_recipe.js"></script>
    </body>
</html>
