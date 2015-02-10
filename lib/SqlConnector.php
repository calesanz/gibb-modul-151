<?php 
class SqlConnector {
    function __construct(){
       
    }
    
    static function getOpenConnection(){
    	
    	return  new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    }
}