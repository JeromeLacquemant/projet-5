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
        $page="frontend/home_cv";
        $topbar="topbar_frontend";
        require "views/layout.php";

        //$myView = new View('home_cv');
       // $myView->render;
    }

    public function legalnotice()
    {
        $page="frontend/legalnotice";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }
    
    public function home()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        $posts = $model_article->get_posts_blog();
        

        $page="frontend/home";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }

    public function blog()
    {
        $model_article = new Article();
        $model_comment = new Comment();
        $posts = $model_article->get_posts_blog_all();
        
        $page="frontend/blog";
        $topbar="topbar_frontend";
        require "views/layout.php";
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
        $page="frontend/post";
        $topbar="topbar_frontend";
        require "views/layout.php";
        }
    }
    
    public function error()
    {
        $page="frontend/error";
        $topbar="topbar_frontend";
        require "views/layout.php";
    }
}

 