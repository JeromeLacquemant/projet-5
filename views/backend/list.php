<h2>Listing des articles</h2>
<hr/>

<?php
    foreach($posts as $post){
        ?>
        <div class="row">
            <div class="col s12">
                <h4><?= $post->getTitle() ?><?php echo ($post->getPosted() == "0") ? "<i class='material-icons'>lock</i>" : "" ?></h4>
                <div class="row">
                    <div class="col s12 m6 l8">
                        <?= substr(nl2br($post->getChapo()),0,1200) ?>...
                    </div>
                    <div class="row"></div>
                    <div class="col s12 m6 l8">
                        <?= substr(nl2br($post->getContent()),0,1200) ?>...
                    </div>
                    <div class="col s12 m6 l4">
                        <img src="public/img/posts/<?= $post->getImage() ?>" class="materialboxed responsive-img" alt="<?= $post->getTitle() ?>"/>
                        <br/><br/>
                        <a class="btn light-blue waves-effect waves-light" href="modifier-un-article/<?= transforme_en_url($post->getTitle()) ?>-<?= $post->getId() ?>">Modifier l'article</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }