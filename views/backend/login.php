<?php
    if(isset($_SESSION['admin'])){
        header("Location:/dashboard");
    }
?>

<div class="row">
    <div class="col l4 m6 s12 offset-l4 offset-m3">
        <div class="card-panel">
            <div class="row">
                <div class="col s6 offset-s3">
                    <img src="../../public/img/admin/admin.png" alt="Administrateur" width="100"/>
                </div>    
            </div>
            <h4 class="center-align">Se connecter</h4>
            <?php
                if(filter_has_var(INPUT_POST, 'submit')){
                    if(filter_has_var(INPUT_POST, 'email')){
                        $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_VALIDATE_EMAIL)));
                    }
                    if(filter_has_var(INPUT_POST, 'password')){
                        $password = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));

                    }

                    $errors = [];

                    if(empty($email) || empty($password)){
                        $errors['empty'] = "Tous les champs n'ont pas été remplis!";
                    }else if($model_user->is_admin($email,$password) == 0){
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
                        header("Location:index.php?page=dashboard");
                    }
                }
            ?>

            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" id="email" name="email"/>
                        <label for="email">Adresse email</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="password" id="password" name="password"/>
                        <label for="password">Mot de passe</label>
                    </div>
                </div>
                <center>
                    <button type="submit" name="submit" class="waves-effect waves-light btn light-blue">
                        <i class="material-icons left">perm_identity</i>
                        Se connecter
                    </button>
                    <br/><br/>
                    <a href="index.php?page=new">Nouveau modérateur</a>
                    <br/><br/>
                </center>
            </form>
        </div>
           <div id="alaska"></div>
    </div>
</div>