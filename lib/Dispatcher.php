<?php

require_once ('lib/IController.php');
require_once ('lib/View.php');
require_once('lib/SqlConnector.php');
/*
 * DB_NAME
 * DB_USER
 * DB_PASSWORD
 * must be defined in passwd file
 * */
require_once('lib/passwd.php');

class Dispatcher {
	
	public function dispatch() {
		
		ini_set ( 'display_errors', TRUE );
		
		session_start ();
		
		array_walk ( $_POST,   array($this , 'myStripTags')  );
		array_walk ( $_GET,     array($this , 'myStripTags')  );
		array_walk ( $_REQUEST, array($this , 'myStripTags')  );	
	
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
	
	function myStripTags(&$value, $key)
	{
		$value = strip_tags($value, '<p><br /><b><strong>');
		$value = htmlspecialchars($value, ENT_QUOTES);
		$value = trim($value);
	}
}

