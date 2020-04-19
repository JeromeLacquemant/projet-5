<?php

class Backend
{
    public function dashboard()
    {
        $manager_comment = new CommentManager();
        $comments = $manager_comment->get_comments();
        
        //$model_dashboard = new Dashboard();
        //$model_user = new UserManager();

       
        if(filter_has_var(INPUT_GET, 'delete')){
            $comment = $manager_comment->delete_comment();
        }
                
        if(filter_has_var(INPUT_GET, 'approve')){
            $comment = $manager_comment->approve_comment();
        }
        
        $myView = new View('dashboard');
        $myView->render(array('comments' => $comments));
    }

    public function write()
    {
        $manager_article = new ArticleManager();
        $manager_article->write_verification();

        //$model_user = new User();
        
        //    if($model_user->admin()!=1){
        //header("Location:/dashboard");
    //}
    
        $myView = new View('write');
        $myView->render();
    }

    public function settings()
    {
        $manager_user = new UserManager();
        $modos = $manager_user->get_modos();
        $manager_user->settings_verification();
        
        //if($model_user->admin()!=1){
        //header("Location:/dashboard");
        //}
        
        $myView = new View('settings');
        $myView->render(array('modos' => $modos));
    }

    public function list()
    {
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_posts();
        
    
        //$model_user = new User();

        
        //if($model_user->admin()!=1){
        //header("Location:/dashboard");
        //}
        $myView = new View('list');
        $myView->render(array('posts' => $posts));
    }

    public function logout()
    {
        $manager_user = new UserManager();
        
        $myView = new View('logout');
        $myView->render();
    }

    public function password()
    {
        $manager_user = new UserManager();
   
        if($manager_user->hasnt_password() == 0){
        header("Location:/dashboard");
    }
        $myView = new View('password');
        $myView->render();
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
        $manager_user = new UserManager();
        $manager_user->new_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
        $myView = new View('new');
        $myView->render();
    }

    public function errorback()
    {
        $model_user = new User();
        
       $myView = new View('errorback');
        $myView->render();
    }
}