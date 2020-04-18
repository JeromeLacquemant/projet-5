<?php 

// Cette classe sert à manipuler tout ce qui touche aux users
class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $token;
    private $role;
    
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
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * 
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * 
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
