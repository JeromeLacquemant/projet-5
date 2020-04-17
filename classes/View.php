<?php

class View
{
    private $template;
    
    public function __construct($template)
    {
        $this->template = $template;
    }
    
    public function render($posts)
    {
        $template = $this->template;
        
        include_once(views/$template.php)
;    }
}
