<?php 
require_once "config/dashboard.php";
?>

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
        if(!empty($comments)) {
            foreach ($comments as $comment) {  

        ?>
        
        <div>
                <tr id="commentaire_<?=$comment->id?>">
                    <td><?= $comment->title ?></td>
                    <td><?= substr($comment->comment, 0, 100); ?>...</td>
                    <td>

                        <a href="index.php?page=dashboard&approve=<?= $comment->id ?>" type="submit" 
                            class="btn-floating btn-small waves-effect waves-light green see_comment" 
                            onclick="return window.confirm(`Êtes vous sur de vouloir d'approuver ce commentaire ?!`)"><i
                            class="material-icons">done</i></a>

                        <a href="index.php?page=dashboard&delete=<?= $comment->id ?>" type="submit" 
                            class="btn-floating btn-small waves-effect waves-light red see_comment" 
                            onclick="return window.confirm(`Êtes vous sur de vouloir supprimer ce commentaire ?!`)"><i
                            class="material-icons">delete</i></a>
        
                        <a href="#comment_<?= $comment->id ?>"
                           class="btn-floating btn-small waves-effect waves-light blue modal-trigger"><i
                            class="material-icons">more_vert</i></a>

                        <div class="modal" id="comment_<?=$comment->id ?>">
                            <div class="modal-content">
                                <h4><?= $comment->name ?></h4>

                                <p>Commentaire posté par
                                    <strong><?= $comment->name . " (" . $comment->email . ")</strong><br/>Le " . date("d/m/Y à H:i", strtotime($comment->date)) ?>
                                </p>
                                <hr/>
                                <p><?= nl2br($comment->comment) ?></p>

                            </div>
                            <div class="modal-footer">
                                <a href="index.php?page=dashboard&delete=<?= $comment->id ?>" id="<?= $comment->id ?>" type="submit"
                                   class="modal-action modal-close waves-effect waves-red btn-flat delete_comment"><i
                                        class="material-icons">delete</i></a>
                                <a href="index.php?page=dashboard&delete=<?= $comment->id ?>" id="<?= $comment->id ?>" type="submit"
                                   class="modal-action modal-close waves-effect waves-green btn-flat see_comment"><i
                                        class="material-icons">done</i></a>
                            </div>
                        </div>

                    </td>
                </tr>
            
            <?php
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
