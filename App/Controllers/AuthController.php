<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action
{

	public function autenticar() {
        $usuario = Container::getModel("usuario");
        $usuario->__set('email', $_POST['email']);
        $senha = $_POST['senha'];
        $retorno = $usuario->autenticar();
      
        if (!empty($retorno) && password_verify($senha, $retorno['senha'])) {
            session_start();
            $_SESSION['id'] = $retorno['id'];
            $_SESSION['nome'] = $retorno['nome'];
            header('Location: /timeline');
        } else {
            header('Location: /?login=erro');
        }
    }

    public function sair(){
        session_start();
        session_destroy();
        header("Location: /");
    }
}


?>