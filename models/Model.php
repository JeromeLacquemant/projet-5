<?php
// Fichier nécessaire pour avoir les identifiants de la bdd
include('config/connexion_database.php');

class Model{
    protected $db; 

    // Retourne une connexion à la base de données
    function getPdo(): PDO
    {
        global $dbhost;
        global $dbname;
        global $dbuser;
        global $dbpswd;

            try{
                $db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }catch(PDOexception $e){
                echo("Une erreur est survenue lors de la connexion à la base de données");
            }

            return $db;
    }

    public function __construct()
    {
        $this->db = Model::getPdo();
    }

}