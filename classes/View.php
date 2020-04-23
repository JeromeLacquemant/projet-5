<?php

class View
{
    private $template;
    
    public function __construct($template, $frontback)
    {
        $this->template = $template;
        $this->frontback = $frontback;
    }
    
    public function render($params = array())
    {
        //On récupère dans le controller, le fait que c'est du backend ou du frontend
        $frontback = $this->frontback;
        
        $manager_user = new UserManager();
        $exist = $manager_user->admin();
        
        // Affichage de la topbar
        $topbar="views/topbar_$frontback.php";
        
        extract($params); // extrac() parcourt le tableau de $params et créé posts, responses, post, etc.
        
        //Affichage du contenu
        $template = $this->template;
        
        ob_start(); //On met dans une mémoire tampon.

        include("views/$frontback/$template.php");
        $contentPage = ob_get_clean();

        include_once("views/layout.php");
        }
 
    }

