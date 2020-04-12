<?php
    if($model_user->admin()!=1){
        header("Location:/dashboard");
    }
?>

<h2>Paramètres</h2>
<div class="row">
    <div class="col m6 s12">
        <h4>Modérateurs</h4>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Validé</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $modos= $model_user->get_modos();
                foreach($modos as $modo){
                    ?>
                        <tr>
                            <td><?= $modo->name ?></td>
                            <td><?= $modo->email ?></td>
                            <td><?= $modo->role ?></td>
                            <td><i class="material-icons"><?php echo (!empty($modo->password)) ? "verified_user" : "av_timer" ?></i></td>
                        </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

    </div>
    <div class="col m6 s12">
        <h4>Ajouter un modo</h4>

        <?php
            if(isset($_POST['submit'])){
                if(isset($_POST['name'])){
                    $name = htmlspecialchars(trim($_POST['name']));
                }
                if(isset($_POST['email'])){
                    $email = htmlspecialchars(trim($_POST['email']));
                }
                if(isset($_POST['email_again'])){
                    $email_again = htmlspecialchars(trim($_POST['email_again']));
                }
                if(isset($_POST['role'])){
                    $role = htmlspecialchars(trim($_POST['role']));
                }
                
                $token = $model_user->token(30);

                $errors = [];

                if(empty($name) || empty($email) || empty($email_again)){
                    $errors['empty'] = "Veuillez remplier tous les champs";
                }

                if($email != $email_again){
                    $errors['different'] = "Les adresses email ne correspondent pas";
                }

                if($model_user->email_taken($email)){
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
                    $model_user->add_modo($name,$email,$role,$token);
                    header("Location:/gestion-des-admins-et-modos");
                }
            }
        ?>

        <form method="post">
            <div class="row">
                <div class="input-field col s12 daniel">
                    <input type="text" name="name" id="name"/>
                    <label for="name">Nom</label>
                </div>
                <div class="input-field col s12 daniel">
                    
                    <input type="email" name="email" id="email"/>
                    <label for="email">Adresse email</label>
                </div>
                <div class="input-field col s12 daniel">
                    <input type="email" name="email_again" id="email_again"/>
                    <label for="email_again">Répéter l'adresse email</label>
                </div>
                <div class="row"></div>
                <select name="role" id="role" class="browser-default custom-select">
                    <option selected>Choisir le rôle de la personne</option>
                    <option value="modo">Modérateur</option>
                    <option value="admin">Administrateur</option>
                </select>
                <div class="row"></div>
                <div class="row"></div>
                <div class="col s12">
                    <button type="submit" name="submit" class="btn">Ajouter</button>
                </div>
            </div>
        </form>
        <div id="alaska"></div>
    </div>
</div>