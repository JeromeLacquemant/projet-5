<h1>Page d'accueil</h1>
<div class="row">

<?php
$posts = $model_article->get_posts_blog1();
foreach($posts as $post){
        ?><div class="col l6 m6 s12">
            <div class="card">
                <div class="card-content">
                    <h1 class="grey-text text-darken-2"><?= $post->title ?></h1>
                    <h6 class="grey-text">Le <?= date("d/m/Y à H:i",strtotime($post->date)); ?> par <?= $post->name ?></h6>
                </div>
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="/public/img/posts/<?= $post->image ?>" class="activator" alt="<?= $post->title ?>"/>
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4"><i class="material-icons right">more_vert</i></span>
                    <p><a class="btn light-blue waves-effect waves-light center" href="/article/<?= transforme_en_url($post->title) ?>-<?= $post->id ?>">Voir l'article complet</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><?= $post->title ?> <i class="material-icons right">close</i></span>
                    <p><?= substr(nl2br($post->content),0,1000); ?>...</p>
                </div>
            </div>
        </div><?php
}
?>
</div>