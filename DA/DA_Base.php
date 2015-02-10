<?php

namespace DA;

USE \PDO;
USE \BE;

class DA_Base {
	public function __construct(PDO $connection = null) {
		
	}
	
	static protected function getConnection(){
		$connection = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
// 		$connection->setAttribute ( \PDO::ATTR_ERRMODE,PDO\PDO::ERRMODE_EXCEPTION );
		return $connection;
	}
}
