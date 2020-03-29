<?php

require_once('models/Article.php');
require_once('models/Comment.php');

require_once('models/Model.php');
require_once('models/User.php');

class Frontend
{
    public function home_cv()
    {
        require('views/frontend/home_cv.php');
    }
    
    public function home()
    {
        $model_article = new Article();
        $model_comment = new Comment();

        $page="frontend/home";
        $topbar="frontend/topbar";
        require('views/presentation.php');
    }

    public function blog()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        
        $page="frontend/blog";
        $topbar="frontend/topbar";
        require('views/presentation.php');
    }

    public function post()
    {
        $model_article = new Article();
        $model_comment = new Comment();
                
        $page="frontend/post";
        $topbar="frontend/topbar";
        require('views/presentation.php');
    }
}