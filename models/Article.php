<?php

class Article
{
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $date;
    private $writer;
    private $posted;
    private $image;
    
    /**
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * 
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title= $title;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }
    
    /**
     * 
     * @param mixed $chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * 
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * 
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getWriter()
    {
        return $this->writer;
    }
    
    /**
     * 
     * @param mixed $writer
     */
    public function setWriter($writer)
    {
        $this->writer = $writer;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getPosted()
    {
        return $this->posted;
    }
    
    /**
     * 
     * @param mixed $posted
     */
    public function setPosted($posted)
    {
        $this->posted = $posted;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * 
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }  
}