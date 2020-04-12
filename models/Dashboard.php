<?php

class Dashboard extends Model
{
    // Fonction qui récupère le nombre d'éléments dans la table
    function inTable($table){
        $query = $this->db->query("SELECT COUNT(id) FROM $table");
        return $nombre = $query->fetch();
    }

    // Fonction qui obtient les couleurs pour les différents encadrés du tableau de bord
    function getColor($table,$colors){
        if(isset($colors[$table])){
            return $colors[$table];
        }else{
            return "orange";
        }
    }
}