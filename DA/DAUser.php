<?php

namespace DA;

class DAUser extends DA_Base {
	
	function find($id) {
		$sql = 'SELECT * FROM person WHERE id = :id';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":id", $id );
		$stmt->execute ();
		
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
		$user->compareString = $user->getCompareString ();
		return $user;
	}
	
	function findAll() {
		$sql = 'SELECT * FROM person';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->execute ();
		
		$people = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			
			$user = self::assignValues ( new \BE\BEUser (), $result );
			$user->compareString = $user->getCompareString ();
			$people [] = $user;
		}
		return $people;
	}
	
	function save(\BE\BEUser $user) {
		
	}
	
	
	
}

