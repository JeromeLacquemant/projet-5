<?php

/**
 * Class Routeur
 * 
 * Créé les routes et trouve les controlleurs
 */

class Routeur 
{
    private $request;
    
    // Tableau qui récupère toutes les routes. Il fait le lien entre le route et le controlleur voulu.
    private $routes = [
                        "blog" => ["controller" => 'Frontend', "method" => 'blog'],
                        "error" => ["controller" => 'Frontend', "method" => 'error'],
                        "home" => ["controller" => 'Frontend', "method" => 'home'],
                        "home_cv" => ["controller" => 'Frontend', "method" => 'home_cv'],
                        "legalnotice" => ["controller" => 'Frontend', "method" => 'legalnotice'],
                        "post" => ["controller" => 'Frontend', "method" => 'post'],
        
                        "dashboard" => ["controller" => 'Backend', "method" => 'dashboard'],
                        "list" => ["controller" => 'Backend', "method" => 'list'], 
                        "login" => ["controller" => 'Backend', "method" => 'login'], 
                        "new" => ["controller" => 'Backend', "method" => 'new'], 
                        "password" => ["controller" => 'Backend', "method" => 'password'], 
                        "postback" => ["controller" => 'Backend', "method" => 'postback'], 
                        "settings" => ["controller" => 'Backend', "method" => 'settings'], 
                        "write" => ["controller" => 'Backend', "method" => 'write'], 
                        "logout" => ["controller" => 'Backend', "method" => 'logout'],
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
    }
}

