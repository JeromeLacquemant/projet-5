<?php

// Retourne une connexion à la base de données
function getPdo(): PDO
{
    global $db;
    $dbhost = 'db5000279167.hosting-data.io';
    $dbname = 'dbs272494';
    $dbuser = 'dbu284835';
    $dbpswd = 'LeProjet-5';

    try{
        $db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }catch(PDOexception $e){
        die("Une erreur est survenue lors de la connexion à la base de données");
    }

    return $db;
}

class Model{
    protected $db; 

    // Comportement appelé dès qu'on créé une instance de la classe => LE CONSTRUCTEUR
    // A la naissance de l'objet $db on l'hydrate
    public function __construct()
    {
        $this->db = getPdo();
    }

}