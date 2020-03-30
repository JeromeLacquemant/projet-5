<nav class="grey darken-4">
    <div class="container">
        <div class="nav-wrapper">
            <a href="index.php?page=home_cv" class="brand-logo">Accueil</a>

            <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>

            <ul class="right hide-on-med-and-down">
                <li class="<?php echo ($page=="home")?"active" : ""; ?>"><a href="index.php?page=home">Blog</a></li>
                <li class="<?php echo ($page=="blog")?"active" : ""; ?>"><a href="index.php?page=blog">Articles</a></li>
                <li class="<?php echo ($page=="login")?"active" : ""; ?>"><a href="index.php?page=login">Espace membre</a></li>            
            </ul>

            <ul class="side-nav" id="mobile-menu">
                <li class="<?php echo ($page=="home")?"active" : ""; ?>"><a href="index.php?page=home">Blog</a></li>
                <li class="<?php echo ($page=="blog")?"active" : ""; ?>"><a href="index.php?page=blog">Articles</a></li>
                <li class="<?php echo ($page=="blog")?"active" : ""; ?>"><a href="index.php?page=login">Espace membre</a></li>            
            </ul>

        </div>
    </div>
</nav>