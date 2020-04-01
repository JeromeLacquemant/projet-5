<?php 

require_once('Model.php');

// Cette classe sert à manipuler tout ce qui touche aux users
class User{
    // Fonction permettant de vérifier que la session est bien active sous le role administrateur
    function admin(){
    if(isset($_SESSION['admin'])){
        $db = getPdo();
        $a = [
            'email'     =>  $_SESSION['admin'],
            'role'      =>  'admin'
        ];

        $sql = "SELECT * FROM admins WHERE email=:email AND role=:role";
        $req = $db->prepare($sql);
        $req->execute($a);
        $exist = $req->rowCount($sql);

        return $exist;
    }else{
        return 0;
    }
    }

    // Fonction qui vérifie qu'un utilisateur est bien administrateur
    function is_admin($email,$password)
    {
        $db = getPdo();

        $a = [
            'email'     =>  $email,
            'password'  =>  $password
        ];
        $sql = "SELECT * FROM admins WHERE email = :email AND password = :password";
        $req = $db->prepare($sql);
        $req->execute($a);
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
        global $db;
        $db = getPdo();

        $e = ['email'   =>  $email];
        $sql = "SELECT * FROM admins WHERE email = :email";
        $req = $db->prepare($sql);
        $req->execute($e);
        $free = $req->rowCount($sql);

        return $free;
    }

    function token($length){
        $chars = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789";
        return substr(str_shuffle(str_repeat($chars,$length)),0,$length);
    }

    // Fonction permettant d'ajouter un modérateur / administrateur et de lui envoyer un mail
    function add_modo($name,$email,$role,$token){
    global $db;

    $m= [
        'name'      =>  $name,
        'email'     =>  $email,
        'token'     =>  $token,
        'role'      =>  $role
    ];

    $sql = "INSERT INTO admins(name,email,token,role) VALUES(:name,:email,:token,:role)";
    $req = $db->prepare($sql);
    $req->execute($m);

    $subject = "Modo / Admin sur le blog";
    $message = '
                Voici votre identifiant et code unique à insérer sur <a href="http://projet-5.jeromelacquemant.fr/index.php?page=new">cette page :
                Identifiant: '.$email.'
                Mot de passe: '.$token.'
                Vous êtes: '.$role.'
                Après avoir inséré ces informations, vous devrez choisir un mot de passe.
    ';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=UTF-8\r\n";
    $header .= 'From: no-reply@gmail.com' . "\r\n" . 'Reply-To: jerome.lacquemant@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($email,$subject,$message,$header);

}
    
    // Fonction permettant d'obtenir tous les modérateurs / administrateurs
    function get_modos(){
        global $db;
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
        global $db;
        $db = getPdo();

        $a = [
            'email' =>  $email,
            'token' =>  $token
        ];
        $sql = "SELECT * FROM admins WHERE email=:email AND token=:token";
        $req= $db->prepare($sql);
        $req->execute($a);
        return $req->rowCount($sql);
    }

    // Fonction permettant la mise à jour du mot de passe 
    function update_password($password){
        global $db;
        $db = getPdo();

        $p = [
            'password'  =>  sha1($password),
            'session'   =>  $_SESSION['admin']
        ];

        $sql = "UPDATE admins SET password = :password WHERE email=:session";
        $req = $db->prepare($sql);
        $req->execute($p);

    }

    // Fonction permettant de récupérer la liste des administrateurs
    function get_user(){
        $db = getPdo();
        global $db;

        $req = $db->query("
            SELECT * FROM admins WHERE email='{$_SESSION['admin']}';
        ");

        $result = $req->fetchObject();
        return $result;
    }
}
