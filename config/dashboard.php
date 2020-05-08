<?php

 // Fonction qui récupère le nombre d'éléments dans la table
    function inTable($table){
        $db = new Model();
        $connexion = $db->getPdo();
        $query = $connexion->query("SELECT COUNT(id) FROM $table");
        return $query->fetch();

    }

    // Fonction qui obtient les couleurs pour les différents encadrés du tableau de bord
    function getColor($table,$colors){
        
        if(isset($colors[$table])){
            return $colors[$table];
        }else{
            return "orange";
        }
    }

