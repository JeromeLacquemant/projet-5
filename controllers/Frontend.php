<?php

class Frontend
{
    public function home_cv()
    {
        require_once "config/formulaires.php";
      if(filter_has_var(INPUT_POST, 'submit')){

                $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name')));
                $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)));

                $subject = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'subject')));
                $message = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'message')));

                
                $errors = [];

                if(empty($name) || empty($email) || empty($subject) || empty($message)){
                    $errors['empty'] = "Veuillez remplier tous les champs";
                }
                if(strlen($name) < 5){
                    $errors['name'] = "Votre nom doit contenir au moins 5 caractères.";
                }
                if(strlen($subject) < 5){
                    $errors['subject'] = "Votre sujet doit contenir au moins 5 caractères.";
                }
                if(strlen($message) < 5){
                    $errors['message'] = "Votre message doit contenir au moins 50 caractères.";
                }

                if(empty($errors)){
                    contact_mail($name,$email,$subject,$message);
                    contact_mail_user($name,$email,$subject,$message);
                }
            }
            else{
                $errors = [];
            }
        
        $myView = new View('home_cv', 'frontend');
        $myView->render(array('errors' => $errors));
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
            
            if(filter_has_var(INPUT_POST, 'submit')){
            $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name')));
            $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email')));
            $comment = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'comment')));
            $errors = [];

            if(empty($name) || empty($email) || empty($comment)){
                $errors['empty'] = "Tous les champs n'ont pas été remplis";
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] = "L'adresse email n'est pas valide";
                }
                if(strlen($name) < 5){
                    $errors['name'] = "Votre nom doit contenir au moins 5 caractères.";
                }
                if(strlen($comment) < 5){
                    $errors['comment'] = "Votre message doit contenir au moins 5 caractères.";
                }
            }

            if(empty($errors)){
                $manager_comment->insert_comment($name,$email,$comment);
            }
            }
            else
                $errors =[];
        }

        if($posts == false){
            header("Location:/page-erreur");
        }
        else{
            $myView = new View('post', 'frontend');
            $myView->render(array('responses' => $responses, 'post' => $posts, 'admin' => $admins, 'errors' => $errors));
        }
    }
    
    public function error()
    {
        $myView = new View('error', 'frontend');
        $myView->render();
    }
}

 