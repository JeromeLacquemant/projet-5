<?php
    ob_start();
?>
                             
<!DOCTYPE html>
    <html lang="fr">
        <head>

            <title>Blog de Jé' - Développeur d'application</title>
            <link rel="icon" href="public/img/accueil/favicon_dev.png" />
            
            <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link type="text/css" rel="stylesheet" href="public/css/materialize/materialize.css"/>
           
            <link href="public/css/bootstrap/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link href="public/css/bootstrap/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="public/css/bootstrap/css/style.css" rel="stylesheet">

            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta content="" name="keywords">
            <meta content="" name="description">

        </head>

        <body>
            <!-- Mise en place de la topbar -->
            <?php
                include 'views/'.$topbar.'.php';
            ?>

            <!-- Mise en place du contenu -->
            <div class="container">
                <?php
                    include 'views/'.$page.'.php';
                ?>
            </div>
            
            <div class="row">
            <!-- Mise en place du footer -->
            <?php
                include 'views/footer.php';
            ?>
            </div>
<script src="public/css/bootstrap/js/main.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="public/js/materialize.js"></script>
        <script type="text/javascript" src="public/js/script.js"></script>  
        <script type="text/javascript" src="public/js/post.func.js"></script>
        <script src="public/css/bootstrap/lib/jquery/jquery.min.js"></script>
        <script src="public/css/bootstrap/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/css/bootstrap/lib/php-mail-form/validate.js"></script>
        <script src="public/css/bootstrap/lib/chart/chart.js"></script>
        <script src="public/css/bootstrap/lib/easing/easing.min.js"></script>
        <script src="../public/js/main.js"></script>

        </body>
    </html> 