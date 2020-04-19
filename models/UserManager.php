<?php

class UserManager extends Model
{
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
            return 0;
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

        $results = [];
        while($rows = $req->fetchObject()){
            $results[] = $rows;
        }
        
        return $results;
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
    
    function user_verification()
    {
           if(filter_has_var(INPUT_POST, 'submit')){
                    if(filter_has_var(INPUT_POST, 'email')){

                        $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)));
                    }
                    if(filter_has_var(INPUT_POST, 'password')){
                        $password = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password')));

                    }
                    $errors = [];

                    if(empty($email) || empty($password)){
                        $errors['empty'] = "Tous les champs n'ont pas été remplis!";
                    }else if(Usermanager::is_admin($email,$password) == 0){
                        $errors['exist']  = "Cet administrateur n'existe pas";
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
                        $_SESSION['admin'] = $email;
                        header("Location:/dashboard");
                    }
                }
    }
    
    function settings_verification()
    {
          if(filter_has_var(INPUT_POST, 'submit')){
                if(filter_has_var(INPUT_POST, 'name')){
                    $name = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'name')));
                }
                if(filter_has_var(INPUT_POST, 'email')){
                    $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email')));
                }
                if(filter_has_var(INPUT_POST, 'email_again')){
                    $email_again = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email_again', FILTER_VALIDATE_EMAIL)));
                }
                if(filter_has_var(INPUT_POST, 'role')){
                    $role = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'role')));
                }
                
                $token = UserManager::token(30);

                $errors = [];

                if(empty($name) || empty($email) || empty($email_again)){
                    $errors['empty'] = "Veuillez remplier tous les champs";
                }

                if($email != $email_again){
                    $errors['different'] = "Les adresses email ne correspondent pas";
                }

                if(UserManager::email_taken($email)){
                    $errors['taken'] = "L'adresse email est déjà assignée à un modérateur";
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
                    Usermanager::add_modo($name,$email,$role,$token);
                    header("Location:/gestion-des-admins-et-modos");
                }
            }
    }
    
    function new_verification()
    {
        
                        if(filter_has_var(INPUT_POST, 'submit')){
                    $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email')));
                    $token = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'token')));

                    $errors = [];

                    if(empty($email) || empty($token)){
                        $errors['empty'] = "Tous les champs n'ont pas été remplis";
                    }else if(UserManager::is_modo($email,$token) == 0){
                        $errors['exist'] = "Ce modérateur n'existe pas";
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
                        $_SESSION['admin'] = $email;
                        header("Location:/modification-du-mot-de-passe");
                    }
                }
    }
    
    function password_verification()
    {
   if(filter_has_var(INPUT_POST, 'submit')){
                    $password = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password')));
                    $password_again = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password_again')));

                    $errors = [];
                    if(empty($password) || empty($password_again)){
                        $errors['empty'] = "Tous les champs n'ont pas été remplis";
                    }

                    if($password != $password_again){
                        $errors['different'] = "Les mots de passe sont différents";
                    }

                    if (preg_match('#^(?=.*[a-z])(?=.*[A-Z]).{8,}$#', $password)) {
                    }
                    else{
                        $errors['non conforme'] = 'Votre mot de passe doit contenir des minuscules et des majuscules et posséder une longueur de 8 caractères au minimum';
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
                        Usermanager::update_password($password);
                        header("Location:/modification-du-mot-de-passe");
                    }
                }
    }
}