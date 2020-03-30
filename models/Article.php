<?php

// Permet d'avoir accès à la base de données
require_once('Model.php');

// Cette classe sert à manipuler tout ce qui touche aux articles
class Article extends Model
{
// FONCTIONS POUR LE FRONTEND
    // Fonction permettant de récupérer tous les articles postés
    public function get_posts_blog(){

        $req = $this->db->query("SELECT * FROM articles WHERE posted='1' ORDER BY date DESC");

        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        return $results;
    }
    

    // Fonction qui permet de récupérer les détails des articles postés
    public function get_posts_blog1(){

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

        global $db;
        $db = getPdo();

        $req = $db->query("
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
        global $db;
        $db = getPdo();

        $e = [
            'title'     => $title,
            'content'   => $content,
            'posted'    => $posted,
            'id'        => $id
        ];

        $sql = "UPDATE articles SET title=:title, content=:content, date=NOW(), posted=:posted WHERE id=:id";
        $req = $db->prepare($sql);
        $req->execute($e);
    }

    // Fonction permettant d'insérer un nouvel article dans la base de données
    function post($title,$content,$posted){
        global $db;
        global $id;
        $db = getPdo();

        $p = [
            'title'     =>  $title,
            'content'   =>  $content,
            'writer'    =>  $_SESSION['admin'],
            'posted'    =>  $posted

        ];

        $sql = "
        INSERT INTO articles(title, slug, introduction, content, writer, date, posted, image)
        VALUES(:title, '', '', :content,:writer,NOW(),:posted, '')
        ";

        $req = $db->prepare($sql);
        $req->execute($p);

        $id = $db->lastInsertId(); //On doit mettre la fonction lastInsertId seulement après une fonction INSERT.
    }

    // Fonction permettant d'insérer une nouvelle image dans la base de données
    function post_img($tmp_name, $extension){
        global $db;
        global $id;
        $db = getPdo();
        
      
        $i = [
            'id'    =>  $id,
            'image' =>  $id.$extension  
        ];

        $sql = "UPDATE articles SET image = :image WHERE id = :id";
        
        $req = $db->prepare($sql);
        $req->execute($i);
        move_uploaded_file($tmp_name, "public/img/posts/".$id.$extension);
    }

        // Fonction permettant de mettre à jour l'image d'un article
    function update_img($tmp_name, $extension){
        $db = getPdo();
        
        $id = $_GET['id'];
         
        $i = [
            'id'    =>  $id,
            'image' =>  $id.$extension  
        ];

        $sql = "UPDATE articles SET image = :image WHERE id = :id";
        
        $req = $db->prepare($sql);
        $req->execute($i);
        move_uploaded_file($tmp_name, "public/img/posts/".$id.$extension);
    }
    
    // Fonction permettant de supprimer un article
    function delete_article()
    {
        $db = getPdo();
        
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }

        $id = $_GET['id'];

        $query = $db->prepare('SELECT * FROM articles WHERE id = :id');
        $query->execute(['id' => $id]);
        if ($query->rowCount() === 0) {
            die("Aucun commentaire n'a l'identifiant $id !");
        }

        $query = $db->prepare('DELETE FROM articles WHERE id = :id');
        $query->execute(['id' => $id]);

        exit();
    }
}