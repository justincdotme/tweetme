<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>TweetMe - By Justin Christenson</title>
        <meta name="description" content="TweetMe App by Justin Christenson"/>
        <meta name="copyright" content="Justin Christenson, Vancouver, WA. All Rights Reserved"/>
        <meta name="author" content="Justin Christenson, https://justinc.me"/>
        <meta name="city" content="Vancouver"/>
        <meta name="country" content="US"/>
        <meta name="Distribution" content="Global"/>
        <meta name="Rating" content="General"/>
        <meta name="Robots" content="INDEX,FOLLOW"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="format-detection" content="telephone=no"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">TweetMe</a>
                </div>
                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home <span class="sr-only">(current)</span></a></li>
                        <li><a href="https://github.com/justincdotme/tweetme" target="_BLANK">GitHub <span class="sr-only">(current)</span></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://justinc.me" target="_BLANK">By Justin Christenson</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Latest tweets (JSON Option)</h3>
                        </div>
                        <ul class="list-group json-tweets">
                            <li class="list-group-item tweet text-center">
                                Loading tweets...
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Latest tweets (HTML Option)</h3>
                        </div>
	                <?php
	                    require 'tweetme-html.php';
	                ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.2/handlebars.min.js"></script>
        <!-- Handlebars Template and RenderTweets JavaScript are only required for the JSON option of TweetMe. -->
        <!--Begin Handlebars template-->
        <script id="tweets-template" type="text/x-handlebars-template">
            {{#tweets}}
            <li class="list-group-item tweet">
                <div class="row">
                    <div class="col-sm-12">
                        <span class="pull-right badge tweet-date">{{date}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-md-1">
                        <a href="https://www.twitter.com/{{user_name}}" target="_BLANK">
                            <img class="inline thumb" src="{{user_profile_image}}">
                        </a>
                    </div>
                    <div class="col-sm-10 col-md-11">
                        <div class="tweet-container">
                            <p class="">{{{tweet}}}</p>
                        </div>
                    </div>
                </div>
            </li>
            {{/tweets}}
        </script>
        <!--End Handlebars template-->
        <!--Begin render tweets-->
        <script>
            var tweetMe = window.tweetMe || {};

            /**
             * Run script on DOM ready.
             */
            $(function()
            {
                tweetMe.getTweetJson();
            });

            /**
             * Get JSON bag of Tweets.
             * Assign JSON to tweetMe.tweets.
             * Call the Handlebars template renderer.
             *
             */
            tweetMe.getTweetJson = function()
            {
                $.get('tweetme-json.php', function(data)
                {
                    tweetMe.tweets = data;
                    tweetMe.renderTweets();
                });
            };

            /**
             * Render Tweets using Handlebars template.
             */
            tweetMe.renderTweets = function()
            {
                var view = $('#tweets-template').html();
                var template = Handlebars.compile(view);
                var json = {tweets: tweetMe.tweets};
                var html = template(json);
                var listContainer = $('ul.json-tweets');
                listContainer.empty();
                listContainer.append(html);
            };
        </script>
        <!--End render tweets-->
    </body>
</html>
