<h2>TOUS LES ARTICLES</h2>

<?php
$count = 0;
    foreach($posts as $post){
?>
    <div class="row">
        <div class="col s12 m12 l12">
            <h1><?= $post->getTitle() ?></h1>
            <h5 class="grey-text">Le <?= date("d/m/Y à H:i",strtotime($post->getDate())); ?> par <?= $admins[$count]->getName() ?></h5>
            <div class="row">
                <div class="col s12 ">
                    <?= substr(nl2br($post->getChapo()),0,1200) ?>...
                </div>
                <div class="row"></div>
                <div class="col s12 m6 l8">
                    <?= substr(nl2br($post->getContent()),0,1200) ?>...
                </div>
                <div class="col s12 m6 l4">
                    <img src="public/img/posts/<?= $post->getImage() ?>" class="materialboxed responsive-img" alt="<?= $post->getTitle() ?>"/>
                    <br/><br/>
                    <a class="btn light-blue waves-effect waves-light center" href="/article/<?= transforme_en_url($post->getTitle()) ?>-<?= $post->getId() ?>">Lire l'article complet</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    $count ++;
}
