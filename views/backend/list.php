<h2>Listing des articles</h2>
<hr/>

<?php
    foreach($posts as $post){
        ?>
        <div class="row">
            <div class="col s12">
                <h4><?= $post->title ?><?php echo ($post->posted == "0") ? "<i class='material-icons'>lock</i>" : "" ?></h4>
                <div class="row">
                    <div class="col s12 m6 l8">
                        <?= substr(nl2br($post->chapo),0,1200) ?>...
                    </div>
                    <div class="row"></div>
                    <div class="col s12 m6 l8">
                        <?= substr(nl2br($post->content),0,1200) ?>...
                    </div>
                    <div class="col s12 m6 l4">
                        <img src="public/img/posts/<?= $post->image ?>" class="materialboxed responsive-img" alt="<?= $post->title ?>"/>
                        <br/><br/>
                        <a class="btn light-blue waves-effect waves-light" href="modifier-un-article/<?= transforme_en_url($post->title) ?>-<?= $post->id ?>">Modifier l'article</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }