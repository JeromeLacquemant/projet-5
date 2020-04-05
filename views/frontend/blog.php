<h2>Blog</h2>

<?php
require_once("config/function_url.php");

    $posts = $model_article->get_posts_blog();
    foreach($posts as $post){
?>

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= $post->title ?></h4>

            <div class="row">
                <div class="col s12 m6 l8">
                    <?= substr(nl2br($post->content),0,1200) ?>...
                </div>
                <div class="col s12 m6 l4">
                    <img src="public/img/posts/<?= $post->image ?>" class="materialboxed responsive-img" alt="<?= $post->title ?>"/>
                    <br/><br/>
                    <a class="btn light-blue waves-effect waves-light center" href="/article/<?= transforme_en_url($post->title) ?>-<?= $post->id ?>">Lire l'article complet</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
