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
                    <img src="../../public/img/admin/modo.png" alt="Modérateur" width="100"/>
                </div>
            </div>
            <h4 class="center-align">Se connecter</h4>

            <?php
                if(filter_has_var(INPUT_POST, 'submit')){
                    $email = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)));
                    $token = filter_var(htmlspecialchars(filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING)));

                    $errors = [];

                    if(empty($email) || empty($token)){
                        $errors['empty'] = "Tous les champs n'ont pas été remplis";
                    }else if($model_user->is_modo($email,$token) == 0){
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
            ?>

            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" id="email" name="email"/>
                        <label for="email">Adresse email</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="token" name="token"/>
                        <label for="token">Code unique</label>
                    </div>
                    <center>
                        <button type="submit" name="submit" class="btn waves-effect waves-light light-blue">
                            <i class="material-icons left">perm_identity</i>
                            Se connecter
                        </button>
                        <br/><br/>
                        <a href="/connexion-espace-membre">Déjà modérateur / administrateur</a>
                    </center>
                </div>
            </form>
        </div>
    <div id="alaska"></div>
    </div>
</div>