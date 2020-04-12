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
        WHERE id = :id');
        $query->execute(['id' => $id]
        );
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
    
    //Fonction permettant de vérifier les données envoyées par l'utilsiateur
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
                Article::post($title,$content,$posted);
                if(!empty($_FILES['image']['name'])){
                    Article::post_img($_FILES['image']['tmp_name'], $extension);
                    header("Location:/liste-de-tous-les-articles");
                }else{
                    $id = $this->db->lastInsertId();
                   header("Location:/liste-de-tous-les-articles");
                }
            }
        }
    }
    
    function form_page_postback(){
        if(isset($_POST['delete'])){
            Article::delete_article_comments();
            Article::delete_article();
            
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
                Article::edit($title,$content,$posted,$_GET['id']);
             
                if(!empty($_FILES['image']['name']))
                {
                    Article::update_img($_FILES['image']['tmp_name'], $extension);
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
}