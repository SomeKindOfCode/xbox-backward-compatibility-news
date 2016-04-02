<!DOCTYPE html>
<html>
    <head>
        <title>New Xbox Backward Compatibility Games</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <style>
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
            .sort:after {
                font-family: FontAwesome;
            }
            .sort.asc:after{
                content: ' \f0d8';
            }
            .sort.desc:after{
                content: ' \f0d7';
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Weekly Backwards Compatibility</h1>
            <p>Current Game Count: <?= count($games); ?></p>

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

            <div id="games">
                <div class="input-group">
                    <input class="form-control search" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-default sort" data-sort="title">Sort by title</button>
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Title</th>
                            <th>Date added</th>
                        </thead>

                        <tbody class="list">
                            <?php foreach($games as $game){ ?>
                            <tr data-slug="<?= $game['slug'] ?>">
                                <td class="title"><a href="<?= $game["url"] ?>" target="_blank" rel="nofollow noreferrer"><?= $game["name"] ?></a></td>
                                <td class="date"><?= DateTime::createFromFormat('Y-m-d H:i:s', $game["date_imported"])->format('Y-m-d') ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="/js/list.js"></script>
        <script type="text/javascript" src= "/js/script.js"></script>
    </body>
</html>
