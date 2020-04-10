<?php
    if($model_user->admin()!=1){
        header("Location:/dashboard");
    }
?>

<h2>Poster un article</h2>

<?php
    if(isset($_POST['post'])){
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $posted = isset($_POST['public']) ? "1" : "0";

        $errors = [];

        if(empty($title) || empty($content)){
            $errors['empty'] = "Veuillez remplir tous les champs";
        }

        if(!empty($_FILES['image']['name'])){
            $file = $_FILES['image']['name'];
            $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
            $extension = strrchr($file,'.');
            if(!in_array($extension,$extensions)){
                $errors['image'] = "Cette image n'est pas valable";
            }
        }

        if(!empty($errors)){
            ?>
                <div class="card red">
                    <div class="card-content white-text">
                        <?php
                            foreach($errors as $error){
                                echo $error."<br/>";
                            }
                        ?>
                    </div>
                </div>
            <?php
        }else{
            $model_article->post($title,$content,$posted);
            if(!empty($_FILES['image']['name'])){
            
                $model_article->post_img($_FILES['image']['tmp_name'], $extension);

            }else{
                $db = getPdo();
                $id = $db->lastInsertId();
               header("Location:/liste-de-tous-les-articles");
            }
        }
    }
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