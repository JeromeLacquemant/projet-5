<?php
    if($model_user->admin()!=1){
        header("Location:/dashboard");
    }
?>

<h2>Poster un article</h2>

<?php
$model_form->form_page_write();
?>

<form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="input-field col s12">
            <input type="text" name="title" id="title"/>
            <label for="title">Titre de l'article</label>
        </div>

        <div class="input-field col s12">
            <textarea name="content" id="content" class="materialize-textarea"></textarea>
            <label for="content">Contenu de l'article</label>
        </div>

        <div class="col s12">
            <div class="input-field">                 
                <input type="file" name="image" class="col s12"/>
                <input type="text" class="file-path col s10" readonly/> <!-- readyonly bloque l'utilisateur pour changer le chemin -->
            </div>
     
        </div>
               <div class="row">
            <p>Veuillez insérer une image de 940*530 px pour que les articles soient homogènes sur le site.</p>
            </div>

        <div class="col s6">
            <p>Public</p>
            <div class="switch">
                <label>
                    Non
                    <input type="checkbox" name="public"/>
                    <span class="lever"></span>
                    Oui
                </label>
            </div>
        </div>

        <div class="col s6 right-align">
            <br/><br/>
            <button class="btn" type="submit" name="post">Publier</button>
        </div>

    </div>
    <div id="alaska"></div>
</form>