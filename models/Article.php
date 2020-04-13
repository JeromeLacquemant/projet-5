<?php
// Permet d'avoir accès à la base de données
require_once('Model.php');

// Cette classe sert à manipuler tout ce qui touche aux articles
class Article extends Model
{
// FONCTIONS POUR LE FRONTEND
    
    // Fonction qui permet de récupérer les détails des articles postés
    public function get_posts_blog(){
        $req = $this->db->query("
            SELECT  articles.id,
                    articles.title,
                    articles.image,
                    articles.date,
                    articles.content,
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer=admins.email
            WHERE posted='1'
            ORDER BY date DESC
            LIMIT 0,5
        ");
        
        $results = array();
        
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        return $results;
    }
    
    // Fonction qui récupère un article avec le posted = 1
    public function get_article_blog(){
        $req = $this->db->query("
            SELECT  articles.id,
                    articles.title,
                    articles.image,
                    articles.content,
                    articles.date,
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer = admins.email
            WHERE articles.id='{$_GET['id']}'
            AND articles.posted = '1'
        ");
    
        $result = $req->fetchObject();
        return $result;
    }


//FONCTIONS POUR LE BACKEND
    // Fonction permettant de récupérer l'ensemble des articles
    function get_posts(){
        $req = $this->db->query("SELECT * FROM articles ORDER BY date DESC");
        
        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        
        return $results;
    }

// Fonction permettant d'obtenir un article en particulier
    function get_post(){
        $req = $this->db->query("
            SELECT  articles.id,
                    articles.title,
                    articles.image,
                    articles.date,
                    articles.content,
                    articles.posted,
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer = admins.email
            WHERE articles.id = '{$_GET['id']}'
        ");

        $result = $req->fetchObject();
        
        return $result;
    }

    // Fonction permettant d'éditer un article 
    function edit($title,$content,$posted,$id){
        $tableau = [
            'title'     => $title,
            'content'   => $content,
            'posted'    => $posted,
            'id'        => $id
        ];

        $sql = "UPDATE articles SET title=:title, content=:content, date=NOW(), posted=:posted WHERE id=:id";
        $req = $this->db->prepare($sql);
        $req->execute($tableau);
    }

    // Fonction permettant d'insérer un nouvel article dans la base de données
    function post($title,$content,$posted){
        $tableau = [
            'title'     =>  $title,
            'content'   =>  $content,
            'writer'    =>  $_SESSION['admin'],
            'posted'    =>  $posted
        ];

        $sql = "
        INSERT INTO articles(title, slug, introduction, content, writer, date, posted, image)
        VALUES(:title, '', '', :content,:writer,NOW(),:posted, '')
        ";

        $req = $this->db->prepare($sql);
        $req->execute($tableau);
    }

    // Fonction permettant d'insérer une nouvelle image dans la base de données
    function post_img($tmp_name, $extension){
        $id = $this->db->lastInsertId(); //On doit mettre la fonction lastInsertId seulement après une fonction INSERT.
        
        $tableau = [
            'id'    =>  $id,
            'image' =>  $id.$extension  
        ];

        $sql = "UPDATE articles SET image = :image WHERE id = :id";
        
        $req = $this->db->prepare($sql);
        $req->execute($tableau);
        move_uploaded_file($tmp_name, "public/img/posts/".$id.$extension);
    }

        // Fonction permettant de mettre à jour l'image d'un article
    function update_img($tmp_name, $extension){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
         
        $tableau = [
            'id'    =>  $id,
            'image' =>  $id.$extension  
        ];

        $sql = "UPDATE articles SET image = :image WHERE id = :id";
        
        $req = $this->db->prepare($sql);
        $req->execute($tableau);
        move_uploaded_file($tmp_name, "public/img/posts/".$id.$extension);
    }
    
    // Fonction permettant de supprimer un article
    function delete_article()
    {  
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        $query = $this->db->prepare('
            DELETE
            FROM articles 
            WHERE id = :id'
        );
        
        $query->execute(['id' => $id]);
        
        unlink("public/img/posts/".$id.".png");
        unlink("public/img/posts/".$id.".jpg");
        unlink("public/img/posts/".$id.".jpeg");
        unlink("public/img/posts/".$id.".gif");
        unlink("public/img/posts/".$id.".PNG");
        unlink("public/img/posts/".$id.".JPG");
        unlink("public/img/posts/".$id.".JPEG");
        unlink("public/img/posts/".$id.".GIF");
    }
    
      // Fonction permettant de supprimer les commentaires d'un article
    function delete_article_comments()
    {  
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = $this->db->prepare('
            DELETE 
            FROM comments 
            WHERE article_id = :id
        ');
        
        $query->execute(['id' => $id]);

        header("Location: /liste-de-tous-les-articles");
    }
}