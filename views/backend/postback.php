    <?php
        if($model_user->admin()!=1){
            header("Location:/dashboard");
        }

        $post = $model_article->get_post();
        if($post == false){
            header("Location:/page-erreur-administrateur");
        }
   
    ?>

<h2>Modifier un article</h2>
        <div class="row center">
            <div class="row">
                <img class="responsive-img" src="/public/img/posts/<?= $post->image ?>" alt="<?= $post->title ?>"/>
            </div>
        </div>
    <div class="container">

    <?php
        if(isset($_POST['delete'])){
            $article = $model_article->delete_article();
            $comment = $model_comment->delete_article_comments();
        }

        if(isset($_POST['submit'])){
            if(isset($_POST['title'])){
                $title = htmlspecialchars(trim($_POST['title']));
            }
            if(isset($_POST['content'])){
                $content = htmlspecialchars(trim($_POST['content']));
            }
            $posted = isset($_POST['public']) ? "1" : "0";
            
            $errors = [];

            if(empty($title) || empty($content)){
                $errors['empty'] = "Veuillez remplir tous les champs svp";
            }

            if(!empty($_FILES['image']['name'])){
                $file = $_FILES['image']['name'];
                $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
                $extension = strrchr($file,'.');
  
                if(!in_array($extension,$extensions)){
                    $errors['image'] = "Cette image n'est pas valable.";
                }
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
                $model_article->edit($title,$content,$posted,$_GET['id']);
             
                if(!empty($_FILES['image']['name']))
                {
                    $model_article->update_img($_FILES['image']['tmp_name'], $extension);
                    header("Location:/liste-de-tous-les-articles");
                }
                else
                {
                    header("Location:/liste-de-tous-les-articles");
                }
                
                ?>
                    <script>
                        window.location.replace("index.php?page=postback&id=<?= $_GET['id'] ?>");
                    </script> 
                <?php
            }
        }
    ?>


    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="title" id="title" value="<?= $post->title ?>"/>
             
            </div>
            <div class="input-field col s12">
                <textarea id="content" name="content" class="materialize-textarea"><?= $post->content ?></textarea>
       
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
                        <input type="checkbox" name="public" <?php echo ($post->posted == "1")?"checked" : "" ?>/>
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
