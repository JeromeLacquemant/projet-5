<?php

require_once "models/Article.php";
require_once "models/Comment.php";
require_once "models/Form.php";

class Frontend
{
    public function showHome()
    {
        echo "Daniel";
    }
    
    public function home_cv()
    {
        $model_form = new Form();
        
        $page="frontend/home_cv";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }

    public function legalnotice()
    {
        $page="frontend/legalnotice";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }
    
    public function home()
    {
        $model_article = new Article();
        $model_comment = new Comment();

        $page="frontend/home";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }

    public function blog()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        
        $page="frontend/blog";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }

    public function post()
    {
        $model_article = new Article();
        $model_comment = new Comment();
                
        $page="frontend/post";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }
    
    public function error()
    {
        $page="frontend/error";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }
}

 