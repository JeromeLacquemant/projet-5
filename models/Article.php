<?php

// Cette classe sert à manipuler tout ce qui touche aux articles
class Article
{
    private $id;
    private $title;
    private $chapo;
    private $image;
    private $content;
    private $date;
    
    /**
     * 
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return type
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * 
     * @return type
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * 
     * @return type
     */
    public function setTitle($title)
    {
        $this->title= $title;
    }
    
    /**
     * 
     * @return type
     */
    public function getChapo()
    {
        return $this->chapo;
    }
    
    /**
     * 
     * @return type
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }
    
    /**
     * 
     * @return type
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * 
     * @return type
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    
    /**
     * 
     * @return type
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * 
     * @return type
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * 
     * @return type
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * 
     * @return type
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    
  
}