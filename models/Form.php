<?php

require_once('Model.php');

// Cette classe sert à manipuler tout ce qui concerne le formulaire de contact de la page d'accueil
class Form extends Model
{
    //Formulaire d'accueil
    function form_page_home_cv(){
      if(filter_has_var(INPUT_POST, 'submit')){

                $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
                $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
                $subject = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING)));
                $message = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING)));

                
                $errors = [];

                if(empty($name) || empty($email) || empty($subject) || empty($message)){
                    $errors['empty'] = "Veuillez remplier tous les champs";
                }

                if(!empty($errors)){
                    ?>
                        <div class="card red">
                            <div class="card-content white-text">
                                <?php
                                foreach($errors as $error){
                                    echo $error;
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                }else{
                    Contact::contact_mail($name,$email,$subject,$message);
                    Contact::contact_mail_user($name,$email,$subject,$message);
                }
            }
    }
            
    // Fonction permettant de m'envoyer un mail lorsqu'un client m'envoie un message
    function contact_mail($name,$email,$subject,$message){
    global $db;

    $subject_mail= "Message d'un utilisateur de mon blog";
    $message_mail = '              
       <html lang="en" style="font-family: sans-serif;">
            <head>
                <meta charset="UTF-8">
            </head>
            <body>
            
                <br/>Nom de l\'utilisateur : '.$name.'
                <br/>Adresse mail de l\'utilisateur : '.$email.'
                <br/>Sujet du message : '.$subject.'
                <br/>Message en entier : '.$message.'
            </body>
        </html>
    ';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=UTF-8\r\n";
    $header .= 'From: jerome.lacquemant@gmail.com' . "\r\n" . 'Reply-To: jerome.lacquemant@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail("jerome.lacquemant@gmail.com",$subject_mail,$message_mail,$header);

    }
    
    // Fonction permettant de m'envoyer un mail lors du formulaire de contact'envoyer un mail au client qui m'envoie
    function contact_mail_user($name,$email,$subject,$message){
    global $db;

    $subject_mail= "Message posté sur le blog de Jé'";
    $message_mail = '              
       <html lang="en" style="font-family: sans-serif;">
            <head>
                <meta charset="UTF-8">
            </head>
            <body>
            
                <br/>Voici les informations que vous m\'avez envoyées :
                <br/>
                <br/>Votre nom utilisateur : '.$name.'
                <br/>Adresse mail utilisée : '.$email.'
                <br/>Sujet du message : '.$subject.'
                <br/>Message en entier : '.$message.'
                <br/>
                <br/>Je vous remercie pour votre message et vous répondrai dans un délai de 5 jours.
                <br/>
                <br/>Excellente journée !
                <br/>
                <br/>Jérôme L.
                    

            </body>
        </html>
    ';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=UTF-8\r\n";
    $header .= 'From: jerome.lacquemant@gmail.com' . "\r\n" . 'Reply-To: jerome.lacquemant@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($email,$subject_mail,$message_mail,$header);
    }
    
 function form_page_postback(){
        if(isset($_POST['delete'])){
            $article = $model_article->delete_article();
            $comment = $model_comment->delete_article_comments();
        }

        if(isset($_POST['submit'])){
            if(isset($_POST['title'])){
                $title = htmlspecialchars(trim($_POST['title']));
            }
            if(isset($_POST['content'])){
                $content = htmlspecialchars(trim($_POST['content']));
            }
            $posted = isset($_POST['public']) ? "1" : "0";
            
            $errors = [];

            if(empty($title) || empty($content)){
                $errors['empty'] = "Veuillez remplir tous les champs svp";
            }

            if(!empty($_FILES['image']['name'])){
                $file = $_FILES['image']['name'];
                $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
                $extension = strrchr($file,'.');
  
                if(!in_array($extension,$extensions)){
                    $errors['image'] = "Cette image n'est pas valable.";
                }
            }
            
            if(!empty($errors)){
                ?>
                <div class="card red">
                    <div class="card-content white-text">
                        <?php
                        foreach($errors as $error){
                            echo $error;
                        }
                        ?>
                    </div>
                </div>
                <?php
            }else{
                $model_article->edit($title,$content,$posted,$_GET['id']);
             
                if(!empty($_FILES['image']['name']))
                {
                    $model_article->update_img($_FILES['image']['tmp_name'], $extension);
                    header("Location:/liste-de-tous-les-articles");
                }
                else
                {
                    header("Location:/liste-de-tous-les-articles");
                }
                
                ?>
                    <script>
                        window.location.replace("index.php?page=postback&id=<?= $_GET['id'] ?>");
                    </script> 
                <?php
            }
        }
    }
    
     // Fonction permettant de vérifier que les données envoyées pat l'utilisateur sont bonnes.
    function form_comment_verification(){
        if(filter_has_var(INPUT_POST, 'submit')){
            $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)));
            $comment = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING)));
            $errors = [];

            if(empty($name) || empty($email) || empty($comment)){
                $errors['empty'] = "Tous les champs n'ont pas été remplis";
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] = "L'adresse email n'est pas valide";
                }
            }

            if(!empty($errors)){
            ?>
                <div class="card red">
                    <div class="card-content white-text">
                        <?php
                            foreach($errors as $error){
                                echo $error;
                            }
                        ?>
                    </div>
                </div>
            <?php
            }else{
                Comment::insert_comment($name,$email,$comment);
            }
        }
    }
    
    function form_page_write(){
        if(isset($_POST['post'])){
            if(isset($_POST['title'])){
                $title = htmlspecialchars(trim($_POST['title']));
            }
            if(isset($_POST['content'])){
                $content = htmlspecialchars(trim($_POST['content']));
            }

            $posted = isset($_POST['public']) ? "1" : "0";

            $errors = [];

            if(empty($title) || empty($content)){
                $errors['empty'] = "Veuillez remplir tous les champs";
            }

            if(!empty($_FILES['image']['name'])){
                $file = $_FILES['image']['name'];
                $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
                $extension = strrchr($file,'.');
                if(!in_array($extension,$extensions)){
                    $errors['image'] = "Cette image n'est pas valable";
                }
            }

            if(!empty($errors)){
                ?>
                    <div class="card red">
                        <div class="card-content white-text">
                            <?php
                                foreach($errors as $error){
                                    echo $error;
                                }
                            ?>
                        </div>
                    </div>
                <?php
            }else{
                $model_article->post($title,$content,$posted);
                if(!empty($_FILES['image']['name'])){

                    $model_article->post_img($_FILES['image']['tmp_name'], $extension);

                }else{
                    $db = getPdo();
                    $id = $db->lastInsertId();
                   header("Location:/liste-de-tous-les-articles");
                }
            }
        }
    }
}