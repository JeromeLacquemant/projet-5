<?php

class View
{
    private $template;
    
    public function __construct($template)
    {
        $this->template = $template;
    }
    
    public function render($params = array())
    {
        // Affichage de la topbar
        $topbar="views/topbar_frontend.php";
        
        extract($params); // extrac() parcourt le tableau de $params et créé posts, responses, post, etc.
        //Affichage du contenu
        $template = $this->template;
        
        ob_start(); //On met dans une mémoire tampon.
        include("views/frontend/$template.php");
        $contentPage = ob_get_clean();

        include_once("views/layout.php");
    }
}

