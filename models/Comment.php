<?php

require_once('Model.php');

// Cette classe sert à manipuler tout ce qui touche aux commentaires
class Comment extends Model
{
// FONCTIONS POUR LE FRONTEND
    // Fonction qui récupère les commentaires d'un article
    public function get_comments_blog(){
    
        $req = $this->db->query("SELECT * FROM comments WHERE article_id = '{$_GET['id']}' AND seen = 1 ORDER BY date DESC");
        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        
        return $results;
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
    
    // Fonction qui insère un commentaire dans la base de données avec un seen = 0
    function insert_comment($name,$email,$comment){
    
        $db = getPdo();
    
        if(isset($_GET['id'])){
            $tableau = array(
            'name'      => $name,
            'email'     => $email,
            'comment'   => $comment,
            'article_id'   => $_GET["id"]
            );
        }
  
    
        $sql = "INSERT INTO comments(name,email,comment,article_id,date,seen) VALUES(:name, :email, :comment, :article_id, NOW(), 0)";
        $req = $db->prepare($sql);
        $req->execute($tableau);
    
    }

//FONCTIONS POUR LE BACKEND
    // Fonction qui récupère l'ensemble des commentaires non vu par l'administrateur
    function get_comments(){
        $db = getPdo();
    
        $req = $db->query("
            SELECT  comments.id,
                    comments.name,
                    comments.email,
                    comments.date,
                    comments.article_id,
                    comments.comment,
                    articles.title
            FROM comments
            JOIN articles
            ON comments.article_id = articles.id
            WHERE comments.seen = '0'
            ORDER BY comments.date ASC
        ");
    
        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        return $results;
    }

    // Fonction permettant de supprimer un commentaire
    function delete_comment(){
        if (isset($_GET['delete']) AND !empty($_GET['delete'])) {
        
        $delete = (int) $_GET['delete'];

        $db = getPdo();
        
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $req->execute(array($delete));

        header("Location: index.php?page=dashboard");
        
        exit();    
        }
    }

    // Fonction permettant d'approuver un commentaire
    function approve_comment(){
        if (empty($_GET['approve']) || !ctype_digit($_GET['approve'])) {
            echo("Ho ! Fallait préciser le paramètre id en GET !");
        }

        $id = $_GET['approve'];

        $db = getPdo();

        $query = $db->prepare('UPDATE comments SET seen=1 WHERE id=:id');
        $query->execute(['id' => $id]);

        header("Location: index.php?page=dashboard");

        exit();
    }

    // EN COURS
    //Fonction permettant de supprimer tous les commentaires d'un article (dans le cas où on veut supprimer un article)
    function delete_article_comments(){
        
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }

        $id = $_GET['id'];

        $query = $db->prepare('
        DELETE 
        FROM comments 
        JOIN articles
        ON comments.article_id = article.id
        ');
        $query->execute(['id' => $id]);

        header("Location: index.php?page=list");

        exit();

    }
}