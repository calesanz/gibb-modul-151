<?php

namespace DA;

class DAUser extends DA_Base {
	function find($id) {
	
	}
	function findAll() {
		$sql = 'SELECT * FROM person';
		$stmt = self::getConnection()->prepare ( $sql );
		$stmt->execute ();
		
		$people = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			$p = new \BE\BEUser ();
			foreach ( $result as $field_name => $field_value )
				$p->{$field_name} = $field_value;
			$people [] = $p;
		}
		return $people;
	}
	function save(\BE\BEUser $user) {
	}
}

