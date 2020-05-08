                            
<!DOCTYPE html>
    <html lang="fr">
        <head>

            <title>Blog de Jé' - Développeur d'application</title>
            <link rel="icon" href="/public/img/accueil/favicon_dev.png" />
            
            <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link type="text/css" rel="stylesheet" href="/public/css/materialize/materialize.css"/>
           
            <link href="../public/css/bootstrap/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link href="../public/css/bootstrap/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="../public/css/bootstrap/css/style.css" rel="stylesheet">

            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta content="" name="keywords">
            <meta content="" name="description">

        </head>

        <!-- GESTION DES COOKIES -->
                    <?php 
            if(isset($_COOKIE['accept_cookie']))
            {
                $showcookie = false;
            }
            else
            {
                $showcookie = true;
            }

            if($showcookie)
            { ?>
            <div class="cookie-container center">
                <p>
                    En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies 
                    pour vous proposer des contenus et services adaptés à vos centres d'intérêts.
                </p>
                <div>
                    <a class="cookie-btn" href="config/accept_cookie.php">Ok</a>
                </div>
            </div>
            <?php } ?>
        
        <body>
            <!-- Mise en place de la topbar -->
                <?php
                include ($topbar);            
            ?>

            <!-- Mise en place du contenu -->
            <div class="container">
                <?php
                    echo $contentPage;
                ?>
            </div>
        </body>
        
        <!-- FOOTER -->
        <div id="copyrights">
            <div class="container">
                <p><a href="/connexion-espace-membre">Accès à l'espace d'administration</a></p>
                <p><a href="/mentions-legales">Mentions légales</a></p>
                <p>Blog créé dans le cadre d'un projet de formation OpenClassrooms by Jérôme Lacquemant</p>
                <p>Created with Kelvin template by <a href="https://templatemag.com/">TemplateMag</a></p>
            </div>
          </div>
        
        <!-- SCRIPTS -->
        <script src="public/css/bootstrap/lib/jquery/jquery.min.js"></script>
        <script src="public/css/bootstrap/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="public/css/bootstrap/lib/php-mail-form/validate.js"></script>
        <script src="public/css/bootstrap/lib/chart/chart.js"></script>
        <script src="public/css/bootstrap/lib/easing/easing.min.js"></script>
        <script src="public/css/bootstrap/js/main.js"></script>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="public/js/materialize.js"></script>
        <script type="text/javascript" src="public/js/script.js"></script>  
        <script type="text/javascript" src="public/js/dashboard.func.js"></script>
        <script type="text/javascript" src="public/js/cookie.js"></script>
            
    </html> 
