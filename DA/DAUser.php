<?php

namespace DA;

class DAUser extends DA_Base {
	function find($id) {
	
	}
	function findAll() {
		$sql = 'SELECT * FROM person';
		$stmt = $this->connection->prepare ( $sql );
		$stmt->execute ();
		
		$people = array ();
		while ( $result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
			$p = new Person ();
			foreach ( $result as $field_name => $field_value )
				$p->{$field_name} = $field_value;
			$people [] = $p;
		}
	}
	function save(\BE\BEUser $user) {
	}
}

