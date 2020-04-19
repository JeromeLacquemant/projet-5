<?php

require_once "models/Article.php";
require_once "models/Comment.php";
require_once "models/Dashboard.php";
require_once "models/User.php";

class Backend
{
    public function dashboard()
    {
        $manager_comment = new CommentManager();
        $comments = $manager_comment->get_comments();
        
        //$model_dashboard = new Dashboard();
        //$model_user = new UserManager();

       
        //if(filter_has_var(INPUT_GET, 'delete')){
        //    $comment = $manager_comment->delete_comment();
        //}
                
        //if(filter_has_var(INPUT_GET, 'approve')){
        //    $comment = $manager_comment->approve_comment();
        //}
        
        $myView = new View('dashboard');
        $myView->render(array('comments' => $comments));
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
        $manager_user = new UserManager();
        $manager_user->user_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
    
        $myView = new View('login');
        $myView->render();
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