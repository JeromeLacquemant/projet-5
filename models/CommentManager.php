<?php
// Permet d'avoir accès à la base de données
require_once "Model.php";

class CommentManager extends Model{
    
    //FONCTIONS POUR LE FRONTEND
    // Fonction qui permet de récupérer les commentaires visibles d'un article (seen = 1)
     function get_comments_blog(){
        $req = $this->db->query("SELECT * FROM comments WHERE article_id = '{$_GET['id']}' AND seen = 1 ORDER BY date DESC");

        $responses=[]; // Obligé d'initialisé avant  la boucle sinon cela ne fonctionne pas.
        
        while($row = $req->fetch()){   
            $response   = new Comment();
            $response   ->setName($row['name']);
            $response   ->setDate($row['date']);
            $response   ->setComment($row['comment']);
            $response   ->setArticleId($row['article_id']);
            $response   ->setSeen($row['seen']);
                        
            $responses[] = $response;
        }
        return $responses;
        }

        // Fonction qui insère un commentaire dans la base de données avec un seen = 0
        function insert_comment($name,$email,$comment){

            if(filter_has_var(INPUT_GET, 'id')){
                $tableau = array(
                'name'      => $name,
                'email'     => $email,
                'comment'   => $comment,
                'article_id'   => filter_input(INPUT_GET, 'id')
                );
            }

            $sql = "INSERT INTO comments(name,email,comment,article_id,date,seen) VALUES(:name, :email, :comment, :article_id, NOW(), 0)";
            $req = $this->db->prepare($sql);
            $req->execute($tableau);
        }

    //FONCTIONS POUR LE BACKEND
        // Fonction qui récupère l'ensemble des commentaires non vu par l'administrateur
        function get_comments(){
            $req = $this->db->query("
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
            $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT);

            $req = $this->db->prepare('DELETE FROM comments WHERE id = ?');
            $req->execute(array($delete));

            header("Location: /dashboard");
        }

        // Fonction permettant d'approuver un commentaire
        function approve_comment(){
            $id = filter_input(INPUT_GET, 'approve', FILTER_SANITIZE_NUMBER_INT);

            $query = $this->db->prepare('UPDATE comments SET seen=1 WHERE id=:id');

            $query->execute(['id' => $id]);

            header("Location: /dashboard");
        }


        // Fonction permettant de vérifier que les données envoyées pat l'utilisateur sont bonnes.
        function form_comment_verification(){
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

                if(!empty($errors)){
                ?>
                    <div class="card red">
                        <div class="card-content white-text">
                            <?php
                                foreach($errors as $error){
                                    echo $error."</br>";
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
}