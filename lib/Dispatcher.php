<?php

namespace Main;

require_once ('lib/IController.php');
require_once ('lib/View.php');
require_once ('lib/SqlConnector.php');
require_once ('lib/Redirector.php');
require_once ('lib/Exception.php');

/**
 * DB_NAME DB_USER DB_PASSWORD must be defined in passwd file
 */
require_once ('lib/passwd.php');
class Dispatcher {
	public function dispatch() {
		ini_set ( 'display_errors', FALSE );

		
		session_start ();
		/**
		 * Registers the onload funciton to require not required files 
		 */
		spl_autoload_register ( array (
				$this,
				'on_load' 
		) );
		/**
		 * Run strip tags on all incoming requests
		 * */
		array_walk_recursive ( $_REQUEST, array (
				$this,
				'myStripTags' 
		) );
		
		$requestUri = trim ( $_SERVER ['REQUEST_URI'],'/');
		// strip the ? part
		if (isset ($requestUri ))
			$requestUri = explode ( '?', $requestUri )[0];
		$url = explode ( '/', $requestUri );
		
		
		$controller = ! empty ( $url [0] ) ? $url [0] . "Controller" : "DefaultController";
		$method = ! empty ( $url [1] ) ? $url [1] : 'index';
		$param = ! empty ( $url [2] ) ? $url [2] : '';
		
		$data = $_REQUEST;
		$session = $_SESSION;
		
		
		if (file_exists ( 'controller/' . $controller . '.php' )) {
			
			require_once ('controller/' . $controller . '.php');
		} 

		else {
			$controller = 'DefaultController';
			require_once ('controller/' . $controller . '.php');
		}
		
		$classPath = "\\Controller\\" . $controller;
		if (! method_exists ( $classPath, $method )) {
			$method = 'index';
		}
		
		$cont = new $classPath ($param, $data, $session);
		$cont->$method ();
		unset ( $cont );
	}
	
	/**
	 * Strips prohibidden tags
	 * */
	function myStripTags(&$value, $key) {
		$value = strip_tags ( $value, '<p><br /><b><strong>' );
		$value = htmlspecialchars ( $value, ENT_QUOTES );
		$value = trim ( $value );
	}
	/**
	 * Requires Files according to Namespace
	 * */
	function on_load($class) {
		$filePath = '' . str_replace ( '\\', '/', $class ) . '.php';
		if (file_exists ( $filePath ))
			require_once ($filePath);
	}
}

