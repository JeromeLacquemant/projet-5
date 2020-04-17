<?php

/**
 * Class Routeur
 * 
 * Créé les routes et trouve les controlleurs
 */

class Routeur
{
    private $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    public function renderController()
    {
        if($this->request == "home_cv")
        {
            include("controllers/Frontend.php");
            echo "Daniel";
        }
        else
        {
            echo '404';
        }
    }
}

