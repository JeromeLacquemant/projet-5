<?php // Affichage des erreurs           
if(!empty($errors)){
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
                <?php } ?>
            
<h2>Modifier un article</h2>
        <div class="row center">
            <div class="row">
                <img class="responsive-img" src="/public/img/posts/<?= $post->getImage() ?>" alt="<?= $post->getTitle() ?>"/>
            </div>
        </div>
    <div class="container">

    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="input-field col s12">
                <div id="content" class="materialize-textarea"><?= $admins->getEmail() ?></div>
            </div>
            <hr>
            <div class="input-field col s12">
                <input type="text" name="title" id="title" value="<?= $post->getTitle() ?>"/>
            </div>
            <div class="input-field col s12">
                <textarea id="content" name="chapo" class="materialize-textarea"><?= $post->getChapo() ?></textarea>
            </div>
            <div class="input-field col s12">
                <textarea id="content" name="content" class="materialize-textarea"><?= $post->getContent() ?></textarea>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <input type="file" name="image" class="col s12"/>
                    <input type="text" class="file-path col s10" readonly/> <!-- readyonly bloque l'utilisateur pour changer le chemin -->
                </div>
            </div>
            <div class="col s6">
                <p>Public</p>
                <div class="switch">
                    <label>
                        Non
                        <input type="checkbox" name="public" <?php echo ($post->getPosted() == "1")?"checked" : "" ?>/>
                        <span class="lever"></span>
                        Oui
                    </label>
                </div>
            </div>
            <div class="col s6 right-align">
                <br/><br/>
                <button type="submit" class="btn" name="submit" onclick="return window.confirm(`Êtes vous sur de vouloir modifier cet article ?!`)">Modifier l'article</button>
                <button type="submit" class="btn" name="delete" onclick="return window.confirm(`Êtes vous sur de vouloir supprimer cet article ?!`)">Supprimer l'article</button>
            </div>
        </div>
        <div id="alaska"></div>
    </form>
