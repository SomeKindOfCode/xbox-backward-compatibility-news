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
            .row, .game{
                margin: 10px auto;
            }
            .feeds {
                text-align: center;
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
                content: '  \f0d7';
            }
            .game { text-align: center; }
            .game img {
                max-width: 100%;
            }

            footer {
                margin-bottom: 50px;
            }
            footer a .fa {
                font-size: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            {block name=body}Nothing here{/block}
        </div>

        <hr/>

        <footer class="text-center">
            <p><small>Made by <a href="https://somekindofcode.com">somekindofcode.com</a></small></p>
            <a href="https://github.com/SomeKindOfCode/xbox-backward-compatibility-news"><i class="fa fa-github"></i></a>
        </footer>

        <script src="/js/list.js"></script>
        <script type="text/javascript" src= "/js/script.js"></script>
    </body>
</html>
