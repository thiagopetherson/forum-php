<?php
ini_set('display_errors', '1');
declare(strict_types=1);

class Usuario{


    private $pdo;
    private string $username;
    private string $password;
    private string $ip_registro;
    private $errors;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setUsername(string $username){
        $this->username = $username;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function checkVars(): bool{
        if(empty($this->getUsername()) || strlen($this->getUsername()) < 5)
            $this->errors['nome'][] = "nome inválido";
        
        if(empty($this->getPassword()) || strlen($this->getPassword()) < 8)
            $this->errors['senha'][] = "senha inválida";

        if(isset($this->errors) && !empty($this->errors) )
            return false;

        return true;
    }   


    public function userExists($username): bool{
        $sql = "SELECT id from usuarios where username = ?";
        $sql = $this->pdo->prepare($sql);
        $sql->execute(array(
                        $username
                        ));
        if($sql->rowCount()>0)
            return true;

        return false;
    }


    public function addUser(): bool{

        if($this->checkVars() == false){
            return false;
        }

        if($this->userExists($this->getUsername()))
        {
            $this->errors[] = "este usuário já existe"; 
            return false;
        }


        $query = "INSERT into usuarios(username, password) values(?, ?)";
        $sql = $this->pdo->prepare($query);
        $sql->execute(array(
                                  $this->getUsername()    ,
                                  md5($this->getPassword())
                                ));
        if($this->pdo->lastInsertId() > 0)
            return true;

        return false;
    
    }


    public function loginUser() : int{
        $sql = $this->pdo->prepare("SELECT id from usuarios where username = ? and password = ?");
        $sql->execute(array(
                            $this->getUsername()    ,
                            md5($this->getPassword())
                      ));
        if($sql->rowCount() > 0)
                    return 1;

        return 0;
    }

    public function showErros(){
        print_r($this->errors);
    }

}


?>