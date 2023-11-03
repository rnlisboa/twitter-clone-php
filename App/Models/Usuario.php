<?php

namespace App\Models;
use MF\Model\Model;

class Usuario extends Model{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //salvar
    public function save(){   
        $query = "insert into usuario(nome, email, senha)
        values(:nome, :email, :senha)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        return $this;
    }
    
    //validar cadastro
    public function validar(){
        $errorName = '';
        $errorEmail = '';
        $errorSenha = '';
        $valido = true;
        if (strlen($this->__get('nome')) < 3) {
            $errorName ='Nome deve ter mais que 3 caracteres.';
            $valido = false;
        }
        
        if (!filter_var($this->__get('email'), FILTER_VALIDATE_EMAIL)) {
            $errorEmail = 'Email inválido.';
            $valido = false;
        }
        
        if (strlen($this->__get('senha')) <= 8) {
            $errorSenha = 'Senha deve ter 8 ou mais caracteres.';
            $valido = false;
        }
        $response = Array(
            'valido'=>$valido,
            'errorName'=>$errorName,
            'errorEmail'=>$errorEmail,
            'errorSenha'=>$errorSenha,
        );
        return $response;
    }
    //recuperar usuario por email
    public function getUsuarioPorEmail(){
        $query = 'select nome, email from usuario where email = :email';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar(){
        $query = 'select id, nome, email from usuario where email = :email and senha = :senha';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();
        
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!empty($usuario['id']) && !empty($usuario['nome'])){
            $this->__set('email', $usuario['id']);    
            $this->__set('senha', $usuario['nome']);    
        }

        return $usuario;
    }
}

?>