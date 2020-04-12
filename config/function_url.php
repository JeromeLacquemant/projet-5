<?php

// SUPPRIME LES CARACTÃˆRES ACCENTUÃ‰S
function supprime_accents($texte){
    $accents = array("Ã€","Ã ","Ã‚","Ãƒ","Ã„","Ã…","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¸","Ãˆ","Ã‰","ÃŠ","Ã‹","Ã¨","Ã©","Ãª","Ã«","Ã‡","Ã§","ÃŒ","Ã ","ÃŽ","Ã ","Ã¬","Ã­","Ã®","Ã¯","Ã™","Ãš","Ã›","Ãœ","Ã¹","Ãº","Ã»","Ã¼","Ã¿","Ã‘","Ã±","Å“");
    $remplace = array("A","A","A","A","A","A","a","a","a","a","a","a","O","O","O","O","O","O","o","o","o","o","o","o","E","E","E","E","e","e","e","e","C","c","I","I","I","I","i","i","i","i","U","U","U","U","u","u","u","u","y","N","n","oe");
    $texte = str_replace($accents, $remplace, $texte);
    
    return($texte);
}

// TRANSFORME UN TEXTE EN FORMAT URL
function transforme_en_url($texte, $limite=100){
    if(!empty($texte)){
        $a_remplacer = array("ê","è","é","&agrave;","&iuml;","&eacute;","<strong>","</strong>","â‚¬","&",":","_","!","?","'","\""," ","(",")","+",".",",","/","%","â€¦"," ","Â²","'","â€™","Â®","Â©","ï","ç","ô","&Agrave;");
        $remplacer_par = array("e","e","e","a","i","e","","","euros","et","-","-","","","-","-","-","","","-","-","-","-","pourcent","","-","2","-","","","","i","c","o","A");
       
        $texte = htmlspecialchars_decode($texte);
        $texte = supprime_accents($texte);
        $texte = strtolower($texte);
        $texte = str_replace($a_remplacer, $remplacer_par, $texte);

        while(preg_match('/--/',$texte)) $texte = str_replace('--', '-', $texte);

        $texte = htmlentities($texte);
        $texte = str_replace(array("&", ";"), "", $texte);
       
        if($limite > 0 && strlen($texte) > $limite) $texte = substr($texte, 0, $limite);

        $longueur = strlen($texte)-1;
        while($texte{$longueur}=='-'){
            $texte = substr($texte, 0, $longueur);
            $longueur--;
        }
    }
    return($texte);
}
