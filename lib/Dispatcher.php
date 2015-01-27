<?php

require_once ('lib/IController.php');
class DB extends SQLite3{
    function __construct(){
        $this->open('./db/database.db',SQLITE3_OPEN_READWRITE);
    }
}
class Dispatcher {
	protected $conn;
	public function dispatch() {
		//ini_set ( 'display_errors', TRUE );
		
		session_start ();
		
		//Header('Content-Type: application/json; charset=UTF8');
	
		// TODO: Connection
		//$this->conn = new SqlConnection ( pwd::$dbhost, pwd::$dbuser, pwd::$dbpassword, pwd::$dbname );
	
		
		//Used for contentType text/json
		//$jsonPost =json_decode(file_get_contents('php://input'), true);
		//$controller = ! empty ( $jsonPost['controller'] ) ? $jsonPost['controller'] . "Controller" : "DefaultController";
		//$method = ! empty ($jsonPost['action'] ) ? $jsonPost['action'] : 'index';
		//$params =  $jsonPost;
		
		//Used for contenttype urlencoded
// 		$controller = ! empty ( $_REQUEST['controller'] ) ? $_REQUEST['controller'] . "Controller" : "DefaultController";
// 		$method = ! empty ($_REQUEST['action'] ) ? $_REQUEST['action'] : 'index';
// 		$params =  $_REQUEST;
		//Used for / separated Urlencoded
		$url = explode ( '/', trim ( $_SERVER ['REQUEST_URI'], '/' ) );
		$controller = !empty($url[0]) ? $url[0]. "Controller" : "DefaultController";
		$method 	= !empty($url[1]) ? $url[1] : 'index';
		$params 	= !empty($url[2]) ? $url[2] : '';
		
		
		
		if (file_exists ( 'controller/' . $controller . '.php' )) {
			
			require_once ('controller/' . $controller . '.php');
		} 

		else {
			// Falls die seite nicht Existiert wird der Default controller genommen.
			$controller = 'DefaultController';
			require_once ('controller/' . $controller . '.php');
		}
		// Falls eine Ung���������ltige Funktion angegeben ist wird index verwendet
		if (! method_exists ( $controller, $method )) {
			$method = 'index';
		}
		

			$cont = new $controller ();
			$cont->$method ( $params );
			unset ( $cont );
	}
}

