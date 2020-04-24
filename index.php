<?php
// Démarrage de la session
session_start();

// Pour afficher les erreurs de php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Appel d'un fichier pour l'url rewritting
require_once "config/function_url.php";

//Appel de l'autoloader
require_once("config/autoload.php");

//AFFICHAGE DES PAGES
// Affichage de la page d'accueil lors du lancement de l'index.php
if (filter_has_var(INPUT_GET, 'page'))
{
    // Affichage des autres page en fonction du GET
    $request = $_GET['page'];
}
// Affichage de la page d'accueil lors du lancement de l'index.php
 else {
    $request = 'home_cv';    
}

$routeur = new Routeur($request);
$routeur->renderController();




