<?php

// Démarrage de la session
session_start();

// Pour afficher les erreurs de php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Appel des contrôleurs
require_once("controllers/Frontend.php");
require_once("controllers/Backend.php");

// Affichage de la page d'accueil lors du lancement de l'index.php
if (!isset($_GET['page']))
{
    $controller = new Frontend();
    $controller->home_cv();
    require_once('views/frontend/home_cv.php');
}

// Affichage des autres page en fonction du GET
if (isset($_GET['page']))
{
    switch($_GET['page']){
        case 'home_cv':
            $controller = new Frontend();
            $controller->home_cv();
        break;
    
        case 'legalnotice':
            $controller = new Frontend();
            $controller->legalnotice();
        break;
    
        case 'home':
            $controller = new Frontend();
            $controller->home();
        break;
    
        case'blog':
            $controller = new Frontend();
            $controller->blog();
        break;

        case 'post':
            if(isset($_GET['id']) && $_GET['id']>0){
                $controller = new Frontend();
                $controller->post($_GET['id']);
            }
        break;
        
        case 'dashboard':
            $controller = new Backend();
            $controller->dashboard();
        break;

        case 'write':
            $controller = new Backend();
            $controller->write();
        break;

        case 'settings':
            $controller = new Backend();
            $controller->settings();
        break;

        case 'list':
            $controller = new Backend();
            $controller->list();
        break;

        case 'logout':
            $controller = new Backend();
            $controller->logout();
        break;

        case 'new':
            $controller = new Backend();
            $controller->new();
        break;

        case 'password':
            $controller = new Backend();
            $controller->password();
        break;

        case 'postback':
            $controller = new Backend();
            $controller->postback();
        break;

        case 'login':
            $controller = new Backend();
            $controller->login();
        break;
    }
}


