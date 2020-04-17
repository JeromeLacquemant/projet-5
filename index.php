<?php
// Démarrage de la session
session_start();

// Pour afficher les erreurs de php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Appel des contrôleurs

require_once "controllers/Backend.php";

// Appel d'un fichier pour l'url rewritting
require_once "config/function_url.php";

// Affichage de la page d'accueil lors du lancement de l'index.php
//if (!filter_has_var(INPUT_GET, 'page'))
//{
//    $controller = new Frontend();
//    $controller->home_cv();
//    require_once "views/frontend/home_cv.php";
//}

// Affichage des autres page en fonction du GET


$request = $_GET['page'];

include_once("classes/Routeur.php");

$routeur = new Routeur($request);
$routeur->renderController();


