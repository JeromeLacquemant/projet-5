<?php

class MyAutoload
{
    public static function start()
    {
        spl_autoload_register('MyAutoload::autoload');
    }
    
    public static function autoload($class)
    {
        if(file_exists("model/$class.php"))
        {
            include_once("model/$class.php");
        }
        else if (file_exists("controllers/$class.php"))
        {
            include_once("controllers/$class.php");
        }
        else if (file_exists("classes/$class.php"))
        {
            include_once("classes/$class.php");
        }
    }
}

