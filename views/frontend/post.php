<?php
$post = $model_article->get_article_blog();
if($post == false){
    header("Location:/page-erreur");
}else{
    ?>
    
    <div class="row center">
        <div class=" row ">
            <img class="responsive-img" src="/public/img/posts/<?= $post->image ?>" alt="<?= $post->title ?>"/>
        </div>
    </div>
        <div class="container">

            <h1><?= $post->title ?></h1>
            <h6>Par <?= $post->name ?> le <?= date("d/m/Y à H:i", strtotime($post->date)) ?></h6>
            <p><?= nl2br($post->content); ?></p>
<?php
}
?>

            <hr>
            <h4>Commentaires:</h4>
            <?php
                $responses = $model_comment->get_comments_blog();
                if($responses != false){
                    foreach($responses as $response){
                        ?>
                            <blockquote>
                                <strong><?= $response->name ?> (<?= date("d/m/Y", strtotime($response->date)) ?>)</strong>
                                <p><?= nl2br($response->comment); ?></p>
                            </blockquote>
                        <?php
                    }
                }else echo "Aucun commentaire n'a été publié... Soyez le premier!";
            ?>

            <h4>Commenter:</h4>

<?php
// Fonction permettant de vérifier le contenu envoyé par l'utilisateur pour insérer un commentaire sur un article.
$model_form->form_comment_verification();
?>

            <form method="post">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input type="text" name="name" id="name"/>
                        <label for="name">Nom</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="email" name="email" id="email"/>
                        <label for="email">Adresse email</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea name="comment" id="comment" class="materialize-textarea"></textarea>
                        <label for="comment">Commentaire</label>
                    </div>

                    <div class="col s12">
                        <button type="submit" name="submit" class="btn waves-effect" 
                                onclick="return window.confirm(`Ce commentaire va être validé par notre équipe avant d'être affiché`)"
                            href="/article/<?= transforme_en_url($post->title) ?>-<?= $post->id ?>">
                            Commenter ce post
                        </button>
                    </div>
                </div>
            </form>
                            
        </div>