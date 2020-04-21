<?php

class Frontend
{
    public function home_cv()
    {
        $model_form = new Form();
        $formulaire = $model_form->form_page_home_cv();
        
        $myView = new View('home_cv', 'frontend');
        $myView->render();
    }

    public function legalnotice()
    {
        $myView = new View('legalnotice', 'frontend');
        $myView->render();
    }
    
    public function home()
    {
        $manager = new ArticleManager();
        $posts = $manager->get_posts_blog();
        
        $myView = new View('home', 'frontend');
        $myView->render(array('posts' => $posts));
    }

    public function blog()
    {
        $manager = new ArticleManager();
        $posts = $manager->get_posts_blog_all();
        
        $myView = new View('blog', 'frontend');
        $myView->render(array('posts' => $posts));
    }

    public function post()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $manager = new ArticleManager();
            $posts = $manager->get_article_blog();
            
            $manager_user = new UserManager();
            $admins = $manager_user->article_admin();
            
            $manager_comment = new CommentManager();
            $responses = $manager_comment->get_comments_blog();
            $manager_comment->form_comment_verification();
            //model_comment->form_comment_verification();  
        }
        
        if($posts == false){
            header("Location:/page-erreur");
        }
        else{
            $myView = new View('post', 'frontend');
            $myView->render(array('responses' => $responses, 'post' => $posts, 'admin' => $admins));
        }
    }
    
    public function error()
    {
        $myView = new View('error', 'frontend');
        $myView->render();
    }
}

 