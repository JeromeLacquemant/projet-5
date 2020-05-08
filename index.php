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
require_once "config/autoload.php";

$request = filter_input(INPUT_GET, 'page');

$routeur = new Routeur($request);
$routeur->renderController();




