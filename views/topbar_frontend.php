<nav class="grey darken-4">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/accueil-de-jerome" class="brand-logo">Accueil</a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li class="<?php echo ($page=="home")?"active" : ""; ?>"><a href="/articles-a-la-une">Top 5 des articles</a></li>
                <li class="<?php echo ($page=="blog")?"active" : ""; ?>"><a href="/ensemble-des-articles">Tous les articles</a></li>
                <li class="<?php echo ($page=="login")?"active" : ""; ?>"><a href="/connexion-espace-membre">Espace membre</a></li>            
            </ul>
            <ul class="side-nav" id="mobile-menu">
                <li class="<?php echo ($page=="home")?"active" : ""; ?>"><a href="/articles-a-la-une">Top 5 des articles</a></li>
                <li class="<?php echo ($page=="blog")?"active" : ""; ?>"><a href="/ensemble-des-articles">Tous les articles</a></li>
                <li class="<?php echo ($page=="login")?"active" : ""; ?>"><a href="/connexion-espace-membre">Espace membre</a></li>            
            </ul>
        </div>
    </div>
</nav>