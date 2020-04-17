<?php

require_once "models/Article.php";
require_once "models/Comment.php";
require_once "models/Dashboard.php";
require_once "models/User.php";

class Backend
{
    public function dashboard()
    {
        $model_comment = new Comment();
        $model_dashboard = new Dashboard();
        $model_user = new User();
        
        $page="backend/dashboard";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function write()
    {
        $model_article = new Article();
        $model_user = new User();
        
        $page="backend/write";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function settings()
    {
        $model_user = new User();
        
        $page="backend/settings";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function list()
    {
        $model_article = new Article();
        $model_user = new User();

        $page="backend/list";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function logout()
    {
        $model_user = new User();
        
        $page="backend/logout";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function password()
    {
        $model_user = new User();
        
        $page="backend/password";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function postback()
    {
        $model_article = new Article();
        $model_user = new User();
        
        $page="backend/postback";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function login()
    {
        $model_user = new User();
        
        $page="backend/login";
        $topbar="topbar_backend";
        require "views/layout.php";
    }
    
    public function new()
    {
        $model_user = new User();
        
        $page="backend/new";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function errorback()
    {
        $model_user = new User();
        
        $page="backend/errorback";
        $topbar="topbar_backend";
        require "views/layout.php";
    }
}