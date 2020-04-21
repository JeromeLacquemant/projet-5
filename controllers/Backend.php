<?php

class Backend
{
    public function dashboard()
    {
        $manager_comment = new CommentManager();
        $comments = $manager_comment->get_comments();
        
        
   
        //$manager_user = new Usermanager();
        //$comments = $manager_user->
        //$model_dashboard = new Dashboard();
        //$model_user = new UserManager();

       
        if(filter_has_var(INPUT_GET, 'delete')){
            $comment = $manager_comment->delete_comment();
        }
                
        if(filter_has_var(INPUT_GET, 'approve')){
            $comment = $manager_comment->approve_comment();
        }
        
        $myView = new View('dashboard', 'backend');
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
    
        $myView = new View('write', 'backend');
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
        
        $myView = new View('settings', 'backend');
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
        $myView = new View('list', 'backend');
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
        $manager_user->password_verification();
   
        if($manager_user->hasnt_password() == 0){
        header("Location:/dashboard");
    }
        $myView = new View('password', 'backend');
        $myView->render();
    }

    public function postback()
    {
        if(isset($_GET['id']))
        {
        $id = $_GET['id'];
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_post();
        $manager_article->postback_verification();
        
        //$manager_user = new UserManager();
        }
        //if($model_user->admin()!=1){
        //header("Location:/dashboard");
        if($posts == false){
            header("Location:/page-erreur-administrateur");
        }

        else{
            $myView = new View('postback', 'backend');
            $myView->render(array('post' => $posts));
        }
    }


    public function login()
    {
        $manager_user = new UserManager();
        $manager_user->user_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
    
        $myView = new View('login', 'backend');
        $myView->render();
    }
    
    public function new()
    {
        $manager_user = new UserManager();
        $manager_user->new_verification();
        
        if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
        $myView = new View('new', 'backend');
        $myView->render();
    }

    public function errorback()
    {
        //$model_user = new User();
        
       $myView = new View('errorback', 'backend');
        $myView->render();
    }
}