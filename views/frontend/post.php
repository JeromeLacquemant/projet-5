<div class="row center">
        <div class=" row ">
            <img class="responsive-img" src="/public/img/posts/<?= $post->getImage() ?>" alt="<?= $post->getTitle() ?>"/>
        </div>
    </div>
    
    <div class="container">
        <h1><?= $post->getTitle() ?></h1>
        <h6>Par <?= $post->getTitle() ?> le <?= date("d/m/Y à H:i", strtotime($post->getDate())) ?></h6>
        <p><?= nl2br($post->getContent()); ?></p>
        <hr>
        <h4>Commentaires:</h4>
        <?php
            if($responses != false){
                foreach($responses as $response){
                    ?>
                        <blockquote>
                             <strong><?= $response->getName() ?> (<?= date("d/m/Y", strtotime($response->getDate())) ?>)</strong>
                             <p><?= nl2br($response->getComment()); ?></p>
                         </blockquote>
                    <?php
                 }
             }else{ 
                 echo "Aucun commentaire n'a été publié... Soyez le premier!";
             }
        ?>
        <h4>Commenter:</h4>
            
        <form method="post">
            <div class="row">
                <div class="input-field col s12 m6">
                    <input type="text" id="name" name="name" placeholder="Nom"/>
                    <label for="name"></label>
                </div>
                <div class="input-field col s12 m6">
                    <input type="email" name="email" id="email" placeholder="Adresse email"/>
                    <label for="email"></label>
                </div>
                <div class="input-field col s12">
                    <textarea name="comment" id="comment" class="materialize-textarea" placeholder="Commentaire"></textarea>
                    <label for="comment"></label>
                </div>

                <div class="col s12">
                    <button type="submit" name="submit" class="btn waves-effect" 
                            onclick="return window.confirm(`Ce commentaire va être validé par notre équipe avant d'être affiché`)"
                        href="/article/<?= transforme_en_url($post->getTitle()) ?>-<?= $post->getId() ?>">
                        Commenter ce post
                    </button>
                </div>
            </div>
        </form>               
    </div>