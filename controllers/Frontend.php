<?php

require_once "models/Article.php";
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
        $model_article = new Article();
        $model_comment = new Comment();
        $posts = $model_article->get_posts_blog();
        
        $myView = new View('home');
        $myView->render($posts);
    }

    public function blog()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        $posts = $model_article->get_posts_blog_all();
        
        $myView = new View('blog');
        $myView->render($posts);
    }

    public function post()
    {
        
        $model_article = new Article();
        $model_comment = new Comment();
                
        $responses = $model_comment->get_comments_blog();
        $post = $model_article->get_article_blog();
        $model_comment->form_comment_verification();
        
        if($post == false){
            header("Location:/page-erreur");
        }else{
        $myView = new View('post');
        $myView->render($posts);
        }
    }
    
    public function error()
    {
        $myView = new View('error');
        $myView->render();
    }
}

 