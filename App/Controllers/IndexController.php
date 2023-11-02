<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action
{

	public function index()
	{

		$this->render('index');
	}

	public function register()
	{
		$this->view->ErroCadastro = false;
		$this->render('register');
	}

	public function registrar()
	{
		$usuario = Container::getModel('Usuario');
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);
		$qtd_usuario = count($usuario->getUsuarioPorEmail());
		
		if ($qtd_usuario > 0) {
			$this->view->ErroCadastro = true;
			$this->view->errorUsuario = 'Usuário com este email já cadastrado.';
		}

		$response = $usuario->validar(); 
		if ($response['valido'] && $qtd_usuario == 0) {
			$usuario->save();
			$this->render('cadastro');
		} else {
			$this->view->ErroCadastro = true;
			$this->view->errorName = $response['errorName'];
			$this->view->errorEmail = $response['errorEmail'];
			$this->view->errorSenha = $response['errorSenha'];
			$this->render('register');
		}
		
	}

}


?>