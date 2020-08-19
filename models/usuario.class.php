<?php
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
            $this->errors['nome'] = "nome inválido";
        
        if(empty($this->getPassword()) || strlen($this->getUsername()) < 8)
            $this->errors['senha'] = "senha inválida";

        if(count($this->errors) > 0 )
            return false;

        return true;
    }   

    public function addUser(): bool{
        $query = "INSERT into usuarios(username, password) values(?, ?)";
        $sql = $this->pdo->prepare($query);
        $sql->pdo->execute(array(
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
        if($sql->fetch() > 0)
                    return $sql->fetch()['id'];

        return 0;
    }

    public function showErros(){
        print_r($this->errors);
    }

}


?>