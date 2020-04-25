<h2>Tableau de bord</h2>
<div class="row">
    <?php
        $tables = [
            "Publications"      =>  "articles",
            "Commentaires"      =>  "comments",
            "Admin / Modo"   =>  "admins"
        ];

        $colors = [
            "articles"      =>  "green",
            "comments"      =>  "red",
            "admins"        =>  "blue"
        ];
    ?>

    <?php
        foreach($tables as $table_name => $table){
            ?>
                <div class="col l4 m6 s12">
                    <div class="card">
                        <div class="card-content <?= getColor($table,$colors) ?> ">
                            <span class="card-title"><?= $table_name ?></span>
                            <?php $nbrInTable = inTable($table); ?>
                            <h4 class="chiffres"><?= $nbrInTable[0] ?></h4>
                        </div>
                    </div>
                </div>
            <?php
        }
    ?>
</div>

<h4>Commentaires non lus</h4>

<table>
    <thead>
        <tr>
            <th>Article</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php  
        $count = 0;
        if(!empty($comments)) {
            foreach ($comments as $comment) {  
        ?>
        
        <div>
                <tr id="commentaire_<?= $comment->getId() ?>">
                    <td><?= $posts[$count]->getTitle() ?></td>
                    <td><?= substr($comment->getComment(), 0, 100); ?></td>
                    <td>

                        <a href="index.php?page=dashboard&approve=<?= $comment->getId() ?>" type="submit" 
                            class="btn-floating btn-small waves-effect waves-light green see_comment" 
                            onclick="return window.confirm(`Êtes vous sur de vouloir d'approuver ce commentaire ?!`)"><i
                            class="material-icons">done</i></a>

                        <a href="index.php?page=dashboard&delete=<?= $comment->getId() ?>" type="submit" 
                            class="btn-floating btn-small waves-effect waves-light red see_comment" 
                            onclick="return window.confirm(`Êtes vous sur de vouloir supprimer ce commentaire ?!`)"><i
                            class="material-icons">delete</i></a>
        
                        <a href="#comment_<?= $comment->getId() ?>"
                           class="btn-floating btn-small waves-effect waves-light blue modal-trigger"><i
                            class="material-icons">more_vert</i></a>

                        <div class="modal" id="comment_<?=$comment->getId() ?>">
                            <div class="modal-content">
                                <h4><?= $comment->getName() ?></h4>

                                <p>Commentaire posté par
                                    <strong><?= $comment->getName() . " (" . $comment->getEmail() . ")</strong><br/>Le " . date("d/m/Y à H:i", strtotime($comment->getDate())) ?>
                                </p>
                                <hr/>
                                <p><?= nl2br($comment->getComment()) ?></p>

                            </div>
                            <div class="modal-footer">
                                <a href="index.php?page=dashboard&delete=<?= $comment->getId() ?>" id="<?= $comment->getId() ?>" type="submit"
                                   class="modal-action modal-close waves-effect waves-red btn-flat delete_comment"><i
                                        class="material-icons">delete</i></a>
                                <a href="index.php?page=dashboard&delete=<?= $comment->getId() ?>" id="<?= $comment->getId() ?>" type="submit"
                                   class="modal-action modal-close waves-effect waves-green btn-flat see_comment"><i
                                        class="material-icons">done</i></a>
                            </div>
                        </div>

                    </td>
                </tr>
            
            <?php
            $count ++;
                }            
        }else{
            ?>
                <tr>
                    <td></td>
                    <td><center>Aucun commentaire à valider</center></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>
