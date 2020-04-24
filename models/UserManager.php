<?php

class UserManager extends Model
{
    // Fonction permettant de récupérer le nom d'un admin pour un article précis.
    function get_article_blog_admin(){
     $req = $this->db->query("
            SELECT  
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer=admins.email
            WHERE articles.id = '{$_GET['id']}'

        ");
        
        $admin = [];
        
        while($row = $req->fetch()){
            $admin   = new User();
            $admin   ->setName($row['name']);
               
            $admins[] = $admin;
        }
        return $admin;
    }
    
        // Fonction qui permet de récupérer les détails des articles postés
    public function get_posts_blog_admin(){
        $req = $this->db->query("
            SELECT  
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer=admins.email
            WHERE posted='1'
                        ORDER BY date DESC
            LIMIT 0,5
 
        ");
        
        $admin = [];
        
        while($row = $req->fetch()){
            
            $admin   = new User();
            $admin   ->setName($row['name']);
                        
            $admins[] = $admin;
        }
        return $admins;
    }
    
     public function get_posts_blog_all_admin(){
        $req = $this->db->query("
            SELECT  
                    admins.name
            FROM articles
            JOIN admins
            ON articles.writer=admins.email
            WHERE posted='1'
            ORDER BY date DESC
        ");
        
        while($row = $req->fetch()){
            
            $admin   = new User();
            $admin   ->setName($row['name']);
                        
            $admins[] = $admin;
        }
        return $admins;
    }
    
    // Fonction permettant de vérifier que la session est bien active sous le role administrateur
    function admin(){
        if(isset($_SESSION['admin'])){
            $tableau = [
                'email'     =>  $_SESSION['admin'],
                'role'      =>  'admin'
            ];

            $sql = "SELECT * FROM admins WHERE email=:email AND role=:role";
            $req = $this->db->prepare($sql);
            $req->execute($tableau);
            $exist = $req->rowCount($sql);

            return $exist;
        }else{
            $exist = 0;
            return $exist;
        }
    }

    // Fonction qui vérifie qu'un utilisateur est bien administrateur
    function is_admin($email,$password){
        $tableau = [
            'email'     =>  $email,
            'password'  =>  sha1($password)
        ];
        $sql = "SELECT * FROM admins WHERE email = :email AND password = :password";
        $req = $this->db->prepare($sql);
        $req->execute($tableau);
        $exist = $req->rowCount($sql);
        
        return $exist;
    }

    function hasnt_password(){
        $sql = "SELECT * FROM admins WHERE email = '{$_SESSION['admin']}' AND password = ''";
        $req = $this->db->prepare($sql);
        $req->execute();
        $exist = $req->rowCount($sql);
        
        return $exist;
    }

    // Fonction qui gère les settings
    function email_taken($email){
        $tableau = ['email'   =>  $email];
        $sql = "SELECT * FROM admins WHERE email = :email";
        $req = $this->db->prepare($sql);
        $req->execute($tableau);
        $free = $req->rowCount($sql);

        return $free;
    }

    //Fonction permettant de créer un token
    function token($length){
        $chars = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789";
        
        return substr(str_shuffle(str_repeat($chars,$length)),0,$length);
    }

    // Fonction permettant d'ajouter un modérateur / administrateur et de lui envoyer un mail
    function add_modo($name,$email,$role,$token){
        $tableau= [
            'name'      =>  $name,
            'email'     =>  $email,
            'token'     =>  $token,
            'role'      =>  $role
        ];

        $sql = "INSERT INTO admins(name,email,token,role) VALUES(:name,:email,:token,:role)";
        $req = $this->db->prepare($sql);
        $req->execute($tableau);

        $subject = "Modo / Admin sur le blog";
        $message = '              
           <html lang="en" style="font-family: sans-serif;">
                <head>
                    <meta charset="UTF-8">
                </head>
                <body>
                    Voici votre identifiant et code unique à insérer sur <a href="http://projet-5.jeromelacquemant.fr/index.php?page=new">cette page</a>.
                    <br/>Identifiant: '.$email.'
                    <br/>Mot de passe: '.$token.'
                    <br/>Vous êtes: '.$role.'
                    <br/><br/>Après avoir inséré ces informations, vous devrez choisir un mot de passe.
                </body>
            </html>
        ';

        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";
        $header .= 'From: jerome.lacquemant@gmail.com' . "\r\n" . 'Reply-To: jerome.lacquemant@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        mail($email,$subject,$message,$header);
}
    
    // Fonction permettant d'obtenir tous les modérateurs / administrateurs
    function get_modos(){
        $req = $this->db->query("
            SELECT * FROM admins
        ");

        $admin = [];
        
        while($row = $req->fetch()){
            
            $admin   = new User();
            $admin   ->setName($row['name']);
            $admin   ->setEmail($row['email']);
            $admin   ->setRole($row['role']);
            $admin   ->setPassword($row['password']);
                        
            $admins[] = $admin;
        }
        return $admins;
    }

    // Fonction qui vérifie qu'un utilisateur est bien modérateur ou admin
    function is_modo($email,$token){
        $tableau = [
            'email' =>  $email,
            'token' =>  $token
        ];
        $sql = "SELECT * FROM admins WHERE email=:email AND token=:token";
        $req= $this->db->prepare($sql);
        $req->execute($tableau);
        
        return $req->rowCount($sql);
    }

    // Fonction permettant la mise à jour du mot de passe 
    function update_password($password){
         $tableau = [
            'password'  =>  sha1($password),
            'session'   =>  $_SESSION['admin']
        ];

        $sql = "UPDATE admins SET password = :password WHERE email=:session";
        $req = $this->db->prepare($sql);
        $req->execute($tableau);

    }

    // Fonction permettant de récupérer la liste des administrateurs
    function get_user(){
        $req = $this->db->query("
            SELECT * FROM admins WHERE email='{$_SESSION['admin']}';
        ");

        $result = $req->fetchObject();
        
        return $result;
    }
}