<?php

require_once "models/Article.php";
require_once "models/ArticleManager.php";
require_once "models/Comment.php";
require_once "models/Form.php";

class Frontend
{
    public function home_cv()
    {
        $model_form = new Form();
        
        $formulaire = $model_form->form_page_home_cv();
        $myView = new View('home_cv');
        $myView->render();
    }

    public function legalnotice()
    {
        $myView = new View('legalnotice');
        $myView->render();
    }
    
    public function home()
    {
        $manager = new ArticleManager();
        $posts = $manager->get_posts_blog();
        
        $myView = new View('home');
        $myView->render(array('posts' => $posts));
    }

    public function blog()
    {
        $manager = new ArticleManager();
        $posts = $manager->get_posts_blog_all();
        
        $myView = new View('blog');
        $myView->render(array('posts' => $posts));
    }

    public function post()
    {
        $manager = new ArticleManager();
        $post = $manager->get_article_blog();
        
        $model_comment = new Comment();
                
        $responses = $model_comment->get_comments_blog();
        
        $model_comment->form_comment_verification();
        
        if($post == false){
            header("Location:/page-erreur");
        }else{
        $myView = new View('post');
        $myView->render(array('responses' => $responses, 'post' => $post));
        }
    }
    
    public function error()
    {
        $myView = new View('error');
        $myView->render();
    }
}

 