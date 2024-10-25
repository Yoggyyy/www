<?php
class User {
    public $username;
    public $password;
    public $mail;
    public $logged = false;

    public function __construct($username,$password, $mail) {
        $this->username = $username;
        $this->password = $password;
        $this->mail = $mail; 
    }
    
    // Login, primero compruebo si esta loggeado el usuario si es true,
    // devuelvo false. luego 
    public function login(string $password): bool{
        if($this->logged){
            return false;
        }else {
            if($password === $this->password;)
        }

        return $logged = false;
    }
    
    public function logout(){

    }

    public function __toString(): string 
    {
        
    }
        
    
}
?>