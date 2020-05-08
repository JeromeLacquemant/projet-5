<?php

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

        $comments=[]; // Obligé d'initialisé avant  la boucle sinon cela ne fonctionne pas.
        
        while($row = $req->fetch()){   
            $comment   = new Comment();
            $comment   ->setId($row['id']);
            $comment   ->setName($row['name']);
            $comment   ->setDate($row['date']);
            $comment   ->setComment($row['comment']);
            $comment   ->setArticleId($row['article_id']);
                        
            $comments[] = $comment;
        }
        return $comments;
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
}