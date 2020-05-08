<?php

class Model{

    public function __construct()
    {
        $this->db = Model::getPdo();
    }
    
    // Retourne une connexion à la base de données
    function getPdo(): PDO
    {
        require_once "config/connexion_database.php";
        $dbhost = bdd_host();
        $dbname = bdd_name();
        $dbuser = bdd_user();
        $dbpswd = bdd_pswd();

            try{
                $db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }catch(PDOexception $e){
                echo("Une erreur est survenue lors de la connexion à la base de données");
            }

            return $db;
    }
}