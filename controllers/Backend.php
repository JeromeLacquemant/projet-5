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
        
        $comments = $model_comment->get_comments();

       
                        if(filter_has_var(INPUT_GET, 'delete')){
                    $comment = $model_comment->delete_comment();
                }
                
                if(filter_has_var(INPUT_GET, 'approve')){
                    $comment = $model_comment->approve_comment();
                }
        $page="backend/dashboard";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function write()
    {
        $model_article = new Article();
        $model_user = new User();
        
            if($model_user->admin()!=1){
        header("Location:/dashboard");
    }
    
        $page="backend/write";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function settings()
    {
        $model_user = new User();
        
        if($model_user->admin()!=1){
        header("Location:/dashboard");
        }
        
        $page="backend/settings";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function list()
    {
        $model_article = new Article();
        $model_user = new User();
        $posts = $model_article->get_posts();
        
        if($model_user->admin()!=1){
        header("Location:/dashboard");
        }
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
        
            if($model_user->hasnt_password() == 0){
        header("Location:/dashboard");
    }
        $page="backend/password";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function postback()
    {
        $model_article = new Article();
        $model_user = new User();
        
            if($model_user->admin()!=1){
        header("Location:/dashboard");
    }

    $post = $model_article->get_post();
    if($post == false){
        header("Location:/page-erreur-administrateur");
    }
    
        $page="backend/postback";
        $topbar="topbar_backend";
        require "views/layout.php";
    }

    public function login()
    {
        $model_user = new User();
        
            if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
    
        $page="backend/login";
        $topbar="topbar_backend";
        require "views/layout.php";
    }
    
    public function new()
    {
        $model_user = new User();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
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