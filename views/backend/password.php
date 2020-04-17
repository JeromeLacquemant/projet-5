<div class="row">
    <div class="col l4 m6 s12 offset-l4 offset-m3">
        <div class="card-panel">
            <div class="row">
                <div class="col s6 offset-s3">
                    <img src="public/img/admin/modo.png" alt="Modérateur" width="100"/>
                </div>
            </div>
            <h4 class="center-align">Choisir un mot de passe</h4>

            <?php
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
                        $model_user->update_password($password);
                        header("Location:/modification-du-mot-de-passe");
                    }
                }
            ?>

            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" id="password" name="password"/>
                        <label for="password">Mot de passe</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="password" name="password_again" id="password_again"/>
                        <label for="password_again">Répéter le mot de passe</label>
                    </div>
                </div>
                <center>
                    <button type="submit" name="submit" class="btn light-blue waves-effect waves-light">
                        <i class="material-icons left">perm_identity</i>
                        Se connecter
                    </button>
                </center>
            </form>
        </div>
    </div>
</div>

<div id="alaska"></div>