<?php

class Backend
{
    public function dashboard()
    {
        $manager_comment = new CommentManager();
        $comments = $manager_comment->get_comments(); 
        
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_comments_article(); 
       
        if(!isset($_SESSION['admin'])){
            header("location: /articles-a-la-une");
        }
        
        if(filter_has_var(INPUT_GET, 'delete')){
            $comment = $manager_comment->delete_comment();
        }
                
        if(filter_has_var(INPUT_GET, 'approve')){
            $comment = $manager_comment->approve_comment();
        }
        
        require_once "config/dashboard.php";
        $myView = new View('dashboard', 'backend');
        $myView->render(array('comments' => $comments, 'posts' => $posts));
    }

    public function write()
    {
        $manager_article = new ArticleManager();
        
        //Permet de vérifier les données envoyées par l'utilsiateur
        if(filter_has_var(INPUT_POST, 'post')){
            if(filter_has_var(INPUT_POST, 'title')){
                $title = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'title')));
            }
            if(filter_has_var(INPUT_POST, 'chapo')){
                $chapo = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'chapo')));
            }
           if(filter_has_var(INPUT_POST, 'content')){
                $content = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'content')));
            }

            $posted = filter_input(INPUT_POST, 'public') ? "1" : "0";

            $errors = [];

            if(empty($title) || empty($content) || empty($chapo)){
                $errors['empty'] = "Veuillez remplir tous les champs";
            }
            if(strlen($title) < 5){
                $errors['title'] = "Votre titre doit contenir au moins 5 caractères.";
            }
            if(strlen($chapo) < 5){
                $errors['chapo'] = "Votre chapô doit contenir au moins 5 caractères.";
            }
            if(strlen($title) < 5){
                $errors['content'] = "Votre article doit contenir au moins 100 caractères.";
            }

            if(!empty($_FILES['image']['name'])){
                $file = $_FILES['image']['name'];
                $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
                $extension = strrchr($file,'.');
                if(!in_array($extension,$extensions)){
                    $errors['image'] = "Cette image n'est pas valable";
                }
            }

            if(empty($errors)){
                $manager_article->post($title,$chapo,$content,$posted);
                if(!empty($_FILES['image']['name'])){
                    $manager_article->post_img($_FILES['image']['tmp_name'], $extension);
                    header("Location:/liste-de-tous-les-articles");
                }else{
                   header("Location:/liste-de-tous-les-articles");
                }
            }
        }
        else
            $errors =[];
   
        if(!isset($_SESSION['admin'])){
            header("location: /articles-a-la-une");
        }
        
        $myView = new View('write', 'backend');
        $myView->render(array('errors' => $errors));
    }

    public function settings()
    {
        $manager_user = new UserManager();
        $modos = $manager_user->get_modos();
 
        if(filter_has_var(INPUT_POST, 'submit')){
                if(filter_has_var(INPUT_POST, 'name')){
                    $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name')));
                }
                if(filter_has_var(INPUT_POST, 'email')){
                    $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email')));
                }
                if(filter_has_var(INPUT_POST, 'email_again')){
                    $email_again = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email_again', FILTER_VALIDATE_EMAIL)));
                }
                if(filter_has_var(INPUT_POST, 'role')){
                    $role = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'role')));
                }
                
                $token = UserManager::token(30);

                $errors = [];

                if(empty($name) || empty($email) || empty($email_again)){
                    $errors['empty'] = "Veuillez remplier tous les champs";
                }

                if($email != $email_again){
                    $errors['different'] = "Les adresses email ne correspondent pas";
                }

                if($manager_user->email_taken($email)){
                    $errors['taken'] = "L'adresse email est déjà assignée à un modérateur";
                }

                if(empty($errors)){
                    $manager_user->add_modo($name,$email,$role,$token);
                    header("Location:/gestion-des-admins-et-modos");
                }
            }
            else {
                $errors = [];
            }
            
        if(!isset($_SESSION['admin'])){
            header("location: /articles-a-la-une");
        }
        
        $myView = new View('settings', 'backend');
        $myView->render(array('modos' => $modos, 'errors' => $errors));
    }

    public function list()
    {
        $manager_article = new ArticleManager();
        $posts = $manager_article->get_posts();

        if(!isset($_SESSION['admin'])){
            header("location: /articles-a-la-une");
        }
        
        $myView = new View('list', 'backend');
        $myView->render(array('posts' => $posts));
    }

    public function password()
    {
        $manager_user = new UserManager();
        $errors = $manager_user->password_verification();
   
         if(filter_has_var(INPUT_POST, 'submit')){
            $password = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password')));
            $password_again = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password_again')));

            $errors = [];
            
            if(empty($password) || empty($password_again)){
                $errors['empty'] = "Tous les champs n'ont pas été remplis";
            }

            if($password != $password_again){
                $errors['different'] = "Les mots de passe sont différents";
            }

            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z]).{8,}$#', $password)) {
            }
            else{
                $errors['non conforme'] = 'Votre mot de passe doit contenir des minuscules et des majuscules et posséder une longueur de 8 caractères au minimum';
            }	
                    
            if(empty($errors)){
                Usermanager::update_password($password);
                header("Location:/modification-du-mot-de-passe");
            }
        }else
            $errors =[];
        
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
        
        $manager_user = new UserManager();
        $admins = $manager_user->get_post_admin();
        
        }

          if(filter_has_var(INPUT_POST, 'delete')){
            $manager_article->delete_article_comments();
            $manager_article->delete_article();
        }

        if(filter_has_var(INPUT_POST, 'submit')){
            if(filter_has_var(INPUT_POST, 'title')){
                $title = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'title')));
            }
            if(filter_has_var(INPUT_POST, 'chapo')){
                $chapo = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'chapo')));
            }
            if(filter_has_var(INPUT_POST, 'content')){
                $content = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'content')));
            }
            $posted = filter_input(INPUT_POST, 'public') ? "1" : "0";
            
            $errors = [];

            if(empty($title) || empty($content) || empty($chapo)){
                $errors['empty'] = "Veuillez remplir tous les champs svp";
            }
            if(strlen($title) < 5){
                $errors['title'] = "Votre message doit contenir au moins 5 caractères.";
            }
            if(strlen($chapo) < 5){
                $errors['chapo'] = "Votre chapô doit contenir au moins 5 caractères.";
            }
            if(strlen($content) < 5){
                $errors['content'] = "Votre article doit contenir au moins 5 caractères.";
            }

            if(!empty($_FILES['image']['name'])){
                $file = $_FILES['image']['name'];
                $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
                $extension = strrchr($file,'.');
  
                if(!in_array($extension,$extensions)){
                    $errors['image'] = "Cette image n'est pas valable.";
                }
            }
            
            if(empty($errors)){
                $admin = $_SESSION['admin'];
                $manager_article->edit($title,$chapo,$content,$posted, $admin, filter_input(INPUT_GET, 'id'));
             
                if(!empty($_FILES['image']['name']))
                {
                    $manager_article->update_img($_FILES['image']['tmp_name'], $extension);
                    header("Location:/liste-de-tous-les-articles");
                }
                else
                {
                    header("Location:/liste-de-tous-les-articles");
                }
            }}else{
                $errors = []; 
            }
        
        if(!isset($_SESSION['admin'])){
            header("location: /articles-a-la-une");
        }
        
        if($posts == false){
            header("Location:/page-erreur");
        }

        else{
            $myView = new View('postback', 'backend');
            $myView->render(array('post' => $posts, 'errors' => $errors, 'admins' => $admins));
        }
    }

    public function login()
    {
        $manager_user = new UserManager();
    
         if(filter_has_var(INPUT_POST, 'submit')){
            if(filter_has_var(INPUT_POST, 'email')){
                $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)));
            }
            if(filter_has_var(INPUT_POST, 'password')){
                $password = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password')));
            }
            
            $errors = [];

            if(empty($email) || empty($password)){
                $errors['empty'] = "Tous les champs n'ont pas été remplis!";
            }else if($manager_user->is_admin($email,$password) == 0){
                $errors['exist']  = "Cet administrateur n'existe pas";
            }
                    
            if(empty($errors)){
                $_SESSION['admin'] = $email;
                header("Location: /dashboard");

            }
        }
        else
            $errors =[];
        
        if(isset($_SESSION['admin'])){
            header("location: /dashboard");
        }

        $myView = new View('login', 'backend');
        $myView->render(array('errors' => $errors));
    }
    
    public function new()
    {
        $manager_user = new UserManager();
        
         if(filter_has_var(INPUT_POST, 'submit')){
            $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email')));
            $token = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'token')));

            $errors = [];

            if(empty($email) || empty($token)){
                $errors['empty'] = "Tous les champs n'ont pas été remplis";
            }else if($manager_user->is_modo($email,$token) == 0){
                $errors['exist'] = "Ce modérateur n'existe pas";
            }                

            if(empty($errors)){
                $_SESSION['admin'] = $email;
                header("Location:/modification-du-mot-de-passe");
            }
            }else
                $errors =[];
            
        $myView = new View('new', 'backend');
        $myView->render(array('errors' => $errors));
    }
    
    public function logout()
    {
        UNSET($_SESSION['admin']);
        header("Location: /articles-a-la-une");
    }
}