<?php

namespace DA;

USE \PDO;
USE \BE;

class DA_Base {
	public function __construct(PDO $connection = null) {
		
	}
	/**
	 * getConnection returns open and configured PDO Connection
	 * @return \PDO
	 */
	static protected function getConnection(){
		$connection = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
		$connection->setAttribute ( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION );
		return $connection;
	}
	
	/**
	 * Assigns all AssocArray values to Object
	 * @param \BE\BE_Base $object
	 * @param array $resultset
	 * @return \BE\BE_Base
	 */
	static protected function assignValues(\BE\BE_Base $object,$resultset){
		foreach ( $resultset as $field_name => $field_value )
			$object->{$field_name} = $field_value;
		return $object;
	}
	
	
}
