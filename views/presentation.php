<?php

ob_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="public/css/materialize/materialize.css"/>
        <title>Blog de Jé'</title>
        <link rel="icon" href="public/img/accueil/favicon_dev.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
        
    <body>
            <?php
                include 'views/'.$topbar.'.php';
            ?>

            <div class="container">
                <?php
                    include 'views/'.$page.'.php';
                ?>
            </div>


<!--import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="public/js/dashboard.func.js"></script>
    <script type="text/javascript" src="public/js/materialize.js"></script>
    <script type="text/javascript" src="public/js/script.js"></script>  
    <script type="text/javascript" src="public/js/post.func.js"></script>

    </body>
</html> 
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

