<h1>TOP 5 DES ARTICLES</h1>
<div class="row">

<?php
foreach($posts as $post){
        ?><div class="col l6 m6 s12">
            <div class="card">
                <div class="card-content">
                    <h1 class="grey-text text-darken-2"><?= $post->getTitle() ?></h1>
                    <h5 class="grey-text">Le <?= date("d/m/Y à H:i",strtotime($post->getDate())); ?> par <?= $post->getTitle() ?></h5>
                </div>
                <div class="row">
                    <div class="col s12">
                        <?= substr(nl2br($post->getChapo()),0,1200) ?>...
                    </div>
                </div>
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="/public/img/posts/<?= $post->getImage() ?>" class="activator" alt="<?= $post->getTitle() ?>"/>
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4"><i class="material-icons right">more_vert</i></span>
                    <p><a class="btn light-blue waves-effect waves-light center" href="/article/<?= transforme_en_url($post->getTitle()) ?>-<?= $post->getId() ?>">Voir l'article complet</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><?= $post->getTitle() ?> <i class="material-icons right">close</i></span>
                    <p><?= substr(nl2br($post->getContent()),0,1000); ?>...</p>
                </div>
            </div>
        </div><?php
}
?>
</div>