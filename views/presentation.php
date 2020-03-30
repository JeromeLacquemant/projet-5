<?php

ob_start();

?>
<!DOCTYPE html>
    <html>
        <head>
            <link href="public/bootstrap/img/favicon_dev.png" rel="icon">
            <link type="text/css" rel="stylesheet" href="public/css/materialize.css"  media="screen,projection"/>
            <title>Blog de Jérôme</title>
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
    
            <!--Import jQuery before materialize.js-->
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="public/js/dashboard.func.js"></script>
            <script type="text/javascript" src="public/js/materialize.js"></script>
            <script type="text/javascript" src="public/js/script.js"></script>  
            <script type="text/javascript" src="public/js/post.func.js"></script>
        </body>
    </html>
   

