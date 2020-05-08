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
                foreach($modos as $modo){
                    ?>
                        <tr>
                            <td><?= $modo->getName() ?></td>
                            <td><?= $modo->getEmail() ?></td>
                            <td><?= $modo->getRole() ?></td>
                            <td><i class="material-icons"><?php echo (!empty($modo->getPassword())) ? "verified_user" : "av_timer" ?></i></td>
                        </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

    </div>

    <div class="col m6 s12">
        <h4>Ajouter un modo</h4>

                   <?php if(!empty($errors)){
                    ?>
                        <div class="card red">
                            <div class="card-content white-text">
                                <?php
                                foreach($errors as $error){
                                    echo $error."</br>";
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                }?>

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