<!DOCTYPE html>
<html>
    <head>
        <title>New Xbox Backward Compatibility Games</title>
    </head>
    <body>
        <?php foreach($games as $weeklyGames){ ?>
            <?php foreach($weeklyGames as $singleGame){ ?>
                <img src="<?= $singleGame["image"] ?>"\>
            <?php } ?>
        <?php } ?>
    </body>
</html>
