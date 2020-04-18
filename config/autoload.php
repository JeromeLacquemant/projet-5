<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($class){
        if(file_exists("models/$class.php"))
        {
            include_once("models/$class.php");
        }
        else if (file_exists("controllers/$class.php"))
        {
            include_once("controllers/$class.php");
        }
        else if (file_exists("classes/$class.php"))
        {
            include_once("classes/$class.php");
        }
};