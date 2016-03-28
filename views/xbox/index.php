<!DOCTYPE html>
<html>
    <head>
        <title>New Xbox Backward Compatibility Games</title>
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
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Weekly Backwards Compatibility</h1>
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
                <img src="<?= $singleGame["image"] ?>"\>
            <?php } ?>
        <?php } ?>
        </div>
    </body>
</html>
