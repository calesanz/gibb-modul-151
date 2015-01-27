<?php

require_once ('lib/IController.php');
require_once ('lib/View.php');
class Dispatcher {
	
	public function dispatch() {
		
		ini_set ( 'display_errors', TRUE );
		
		session_start ();
		
	
		$url = explode ( '/', trim ( $_SERVER ['REQUEST_URI'], '/' ) );
		$controller = !empty($url[0]) ? $url[0]. "Controller" : "DefaultController";
		$method 	= !empty($url[1]) ? $url[1] : 'index';
		$params 	= !empty($url[2]) ? $url[2] : '';
		
		
		
		if (file_exists ( 'controller/' . $controller . '.php' )) {
			
			require_once ('controller/' . $controller . '.php');
		} 

		else {
			$controller = 'DefaultController';
			require_once ('controller/' . $controller . '.php');
		}
			if (! method_exists ( $controller, $method )) {
			$method = 'index';
		}
		

			$cont = new $controller ();
			$cont->$method ( $params );
			unset ( $cont );
	}
}

