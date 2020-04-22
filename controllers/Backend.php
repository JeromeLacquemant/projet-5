<?php

class Backend
{
    public function dashboard()
    {
        $manager_comment = new CommentManager();
        $comments = $manager_comment->get_comments(); 
       
        if(filter_has_var(INPUT_GET, 'delete')){
            $comment = $manager_comment->delete_comment();
        }
                
        if(filter_has_var(INPUT_GET, 'approve')){
            $comment = $manager_comment->approve_comment();
        }
        
        require_once "config/dashboard.php";
        $myView = new View('dashboard', 'backend');
        $myView->render(array('comments' => $comments));
    }

    public function write()
    {
        $manager_article = new ArticleManager();
        $errors = $manager_article->write_verification();
    
        $myView = new View('write', 'backend');
        $myView->render(array('errors' => $errors));
    }

    public function settings()
    {
        $manager_user = new UserManager();
        $modos = $manager_user->get_modos();
        $errors = $manager_user->settings_verification();
 
        $myView = new View('settings', 'backend');
        $myView->render(array('modos' => $modos, 'errors' => $errors));
    }

    public function list()
    {
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_posts();
        
        $manager_user = new UserManager();
        $users = $manager_user->admin();
        
        if($users=0){
        header("Location:/dashboard");
        }
        
        $myView = new View('list', 'backend');
        $myView->render(array('posts' => $posts));
    }

    public function password()
    {
        $manager_user = new UserManager();
        $errors = $manager_user->password_verification();
   
        if($manager_user->hasnt_password() == 0){
        header("Location:/dashboard");
    }
        $myView = new View('password', 'backend');
        $myView->render(array('errors' => $errors));
    }

    public function postback()
    {
        if(isset($_GET['id']))
        {
        $id = $_GET['id'];
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_post();
        $errors = $manager_article->postback_verification();
        }

        if($posts == false){
            header("Location:/page-erreur-administrateur");
        }

        else{
            $myView = new View('postback', 'backend');
            $myView->render(array('post' => $posts, 'errors' => $errors));
        }
    }

    public function login()
    {
        $manager_user = new UserManager();
        $errors = $manager_user->login_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
    
        $myView = new View('login', 'backend');
        $myView->render(array('errors' => $errors));
    }
    
    public function new()
    {
        $manager_user = new UserManager();
        $errors = $manager_user->new_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
        $myView = new View('new', 'backend');
        $myView->render(array('errors' => $errors));
    }

    public function errorback()
    {
        $myView = new View('errorback', 'backend');
        $myView->render();
    }
}