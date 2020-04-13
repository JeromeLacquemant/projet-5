<?php

require_once "models/Article.php";
require_once "models/Comment.php";
require_once "models/Form.php";

class Frontend
{
    public function home_cv()
    {
        $model_form = new Form();
        
        $page="frontend/home_cv";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }

    public function legalnotice()
    {
        $page="frontend/legalnotice";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }
    
    public function home()
    {
        $model_article = new Article();
        $model_comment = new Comment();

        $page="frontend/home";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }

    public function blog()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        
        $page="frontend/blog";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }

    public function post()
    {
        $model_article = new Article();
        $model_comment = new Comment();
                
        $page="frontend/post";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }
    
    public function error()
    {
        $page="frontend/error";
        $topbar="frontend/topbar";
        require "views/layout.php";
    }
}