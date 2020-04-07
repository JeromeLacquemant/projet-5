<nav class="light-green">
    <div class="container">
        <div class="nav-wrapper">
            <a href="accueil-de-jerome" class="brand-logo">Accueil</a>
            <?php
            if($page != 'login' && $page != 'new' && $page != 'password'){
                ?>
                    <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>

                    <ul class="right hide-on-med-and-down">
                    <?php
                        if($model_user->admin()==1){
                         ?>
                        <li class="<?php echo ($page=="dashboard")?"active" : ""; ?>"><a href="/dashboard"><i class="material-icons">dashboard</i></a></li>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if($model_user->admin()==1){
                            ?>
                            <li class="<?php echo ($page=="write")?"active" : ""; ?>"><a href="/ecrire-un-article"><i class="material-icons">edit</i></a></li>
                            <li class="<?php echo ($page=="list")?"active" : ""; ?>"><a href="/liste-de-tous-les-articles"><i class="material-icons">view_list</i></a></li>
                            <li class="<?php echo ($page=="settings")?"active" : ""; ?>"><a href="/gestion-des-admins-et-modos"><i class="material-icons">settings</i></a></li>

                            <?php
                        }

                        ?>

                        <li><a href="/articles-a-la-une">Quitter</a></li>
                        <li><a href="/index.php?page=logout">Déconnexion</a></li>

                    </ul>

                    <ul class="side-nav" id="mobile-menu">
                        <?php
                        if($model_user->admin()==1){
                         ?>
                        <li class="<?php echo ($page=="dashboard")?"active" : ""; ?>"><a href="index.php?page=dashboard">Tableau de bord</a></li>
                        
                        <?php
                        }
                        ?>

                        <?php
                        if($model_user->admin()==1){
                            ?>
                                <li class="<?php echo ($page=="write")?"active" : ""; ?>"><a href="/ecrire-un-article">Publier un article</a></li>
                                <li class="<?php echo ($page=="list")?"active" : ""; ?>"><a href="/liste-de-tous-les-articles">Listing des articles</a></li>
                                <li class="<?php echo ($page=="settings")?"active" : ""; ?>"><a href="/gestion-des-admins-et-modos">Paramètres</a></li>
                            <?php
                        }

                        ?>
                        <li><a href="/articles-a-la-une">Quitter</a></li>
                        <li><a href="/index.php?page=logout">Déconnexion</a></li>

                    </ul>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
