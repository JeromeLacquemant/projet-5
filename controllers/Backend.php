<?php

require_once('models/Article.php');
require_once('models/Comment.php');
require_once('models/Dashboard.php');
require_once('models/User.php');

class Backend
{
    public function dashboard()
    {
        $model_comment = new Comment();
        $model_dashboard = new Dashboard();
        $model_user = new User();
        
        $page="backend/dashboard";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function write()
    {
        $model_article = new Article();
        $model_user = new User();
        
        $page="backend/write";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function settings()
    {
        $model_user = new User();
        
        $page="backend/settings";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function list()
    {
        $model_article = new Article();
        $model_user = new User();

        $page="backend/list";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function logout()
    {
        $model_user = new User();
        
        $page="backend/logout";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function password()
    {
        $model_user = new User();
        
        $page="backend/password";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function postback()
    {
        $model_article = new Article();
        $model_user = new User();
        
        $page="backend/postback";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function login()
    {
        $model_user = new User();
        
        $page="backend/login";
        $topbar="backend/topbar";
        require('views/layout.php');
    }
    
    public function new()
    {
        $model_user = new User();
        
        $page="backend/new";
        $topbar="backend/topbar";
        require('views/layout.php');
    }

    public function errorback()
    {
        $model_user = new User();
        
        $page="backend/errorback";
        $topbar="backend/topbar";
        require('views/layout.php');
    }
}