<?php

namespace App\Model;

class User{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    //GETTERS

    /**
     * Get the value of username
     */ 
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): ?string
    {
        return $this->password;
    }
    

    //SETTERS

    public function setUsername($username) :self
    {
        $this->username = $username;

        return $this;
    }


    public function setPassword($password) : self
    {
        $this->password = $password;

        return $this;
    }



    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}