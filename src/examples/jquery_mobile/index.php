<?php
require("handlers/article_handler.php");
require("handlers/articles_handler.php");
require("handlers/comment_handler.php");
require("libs/markdown.php");
require("libs/mysql.php");
require("libs/queries.php");
require("Toro.php");

ToroHook::add("404", function() {
    echo "Not found";
});

Toro::serve(array(
    "/" => "ArticlesHandler",
    "/article/:alpha" => "ArticleHandler",
    "/article/:alpha/comment" => "CommentHandler"
));
