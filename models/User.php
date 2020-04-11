<?php 

require_once('Model.php');

// Cette classe sert à manipuler tout ce qui touche aux users
class User{
    // Fonction permettant de vérifier que la session est bien active sous le role administrateur
    function admin(){
    if(isset($_SESSION['admin'])){
        $db = getPdo();
        
        $tableau = [
            'email'     =>  $_SESSION['admin'],
            'role'      =>  'admin'
        ];

        $sql = "SELECT * FROM admins WHERE email=:email AND role=:role";
        $req = $db->prepare($sql);
        $req->execute($tableau);
        $exist = $req->rowCount($sql);

        return $exist;
    }else{
        return 0;
    }
    }

    // Fonction qui vérifie qu'un utilisateur est bien administrateur
    function is_admin($email,$password){
        $db = getPdo();

        $tableau = [
            'email'     =>  $email,
            'password'  =>  sha1($password)
        ];
        $sql = "SELECT * FROM admins WHERE email = :email AND password = :password";
        $req = $db->prepare($sql);
        $req->execute($tableau);
        $exist = $req->rowCount($sql);
        
        return $exist;
    }

    function hasnt_password(){
        $db = getPdo();

        $sql = "SELECT * FROM admins WHERE email = '{$_SESSION['admin']}' AND password = ''";
        $req = $db->prepare($sql);
        $req->execute();
        $exist = $req->rowCount($sql);
        
        return $exist;
    }

    // Fonction qui gère les settings
    function email_taken($email){
        $db = getPdo();

        $tableau = ['email'   =>  $email];
        $sql = "SELECT * FROM admins WHERE email = :email";
        $req = $db->prepare($sql);
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
        $db = getPdo();

        $tableau= [
            'name'      =>  $name,
            'email'     =>  $email,
            'token'     =>  $token,
            'role'      =>  $role
        ];

        $sql = "INSERT INTO admins(name,email,token,role) VALUES(:name,:email,:token,:role)";
        $req = $db->prepare($sql);
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
        $db = getPdo();

        $req = $db->query("
            SELECT * FROM admins
        ");

        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        
        return $results;
    }

    // Fonction qui vérifie qu'un utilisateur est bien modérateur ou admin
    function is_modo($email,$token){
        $db = getPdo();

        $tableau = [
            'email' =>  $email,
            'token' =>  $token
        ];
        $sql = "SELECT * FROM admins WHERE email=:email AND token=:token";
        $req= $db->prepare($sql);
        $req->execute($tableau);
        
        return $req->rowCount($sql);
    }

    // Fonction permettant la mise à jour du mot de passe 
    function update_password($password){
        $db = getPdo();

        $tableau = [
            'password'  =>  sha1($password),
            'session'   =>  $_SESSION['admin']
        ];

        $sql = "UPDATE admins SET password = :password WHERE email=:session";
        $req = $db->prepare($sql);
        $req->execute($tableau);

    }

    // Fonction permettant de récupérer la liste des administrateurs
    function get_user(){
        $db = getPdo();

        $req = $db->query("
            SELECT * FROM admins WHERE email='{$_SESSION['admin']}';
        ");

        $result = $req->fetchObject();
        
        return $result;
    }
}
