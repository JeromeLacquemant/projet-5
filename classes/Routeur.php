<?php

/**
 * Class Routeur
 * 
 * Créé les routes et trouve les controlleurs
 */

include_once("controllers/Frontend.php");
class Routeur
{
    private $request;
    
    // Tableau qui récupère toutes les routes. Il fait le lien entre le route et le controlleur voulu.
    private $routes = [
                        "blog" => ["controller" => 'Frontend', "method" => 'blog'],
                        "error" => ["controller" => 'Frontend', "method" => 'error'],
                        "home" => ["controller" => 'Frontend', "method" => 'home'],
                        "home_cv" => ["controller" => 'Frontend', "method" => 'home_cv'],
                        "legal_notice" => ["controller" => 'Frontend', "method" => 'legal_notice'],
                        "post" => ["controller" => 'Frontend', "method" => 'post']    
        ];
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    public function renderController()
    {
        $request = $this->request;
        
        if(key_exists($request, $this->routes)) //Est-ce que la clé $request existe dans le tableau routes ?
        {
            $controller = $this->routes[$request]['controller'];
            $method = $this->routes[$request]['method'];
            
            $currentController = new $controller();
            $currentController->$method();
        }
        else
        {
            echo '404';
        }
    }
}

