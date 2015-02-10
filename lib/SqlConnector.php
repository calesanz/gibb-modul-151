<?php 
class SqlConnector {
    function __construct(){
       
    }
    
    static function getOpenConnection(){
    	return new mysqli("localhost", "phpuser", "dGrrU5Jcwhp9prX2", "homepageanwendungen");
    }
}