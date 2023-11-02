<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		//get
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		//get
		$routes['register'] = array(
			'route' => '/register',
			'controller' => 'indexController',
			'action' => 'register'
		);

		//post
		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);
		

		$this->setRoutes($routes);
	}

}

?>