<?php

// Cette classe sert à manipuler tout ce qui touche aux commentaires
class Comment
{
    private $id;
    private $name;
    private $comment;
    private $date;
    private $article_id;
    private $email;
    private $seen;
    
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
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * 
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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
    public function getArticleId()
    {
        return $this->article_id;
    }
    
    /**
     * 
     * @param mixed $article_id
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * 
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * 
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }
    
    /**
     * 
     * @param mixed $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }
}