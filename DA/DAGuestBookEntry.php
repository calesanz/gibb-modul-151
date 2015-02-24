<?php

namespace DA;

class DAGuestBookEntry extends DA_Base {
	
	function find($id) {
		$sql = 'SELECT * FROM GuestBookEntry WHERE Id = :Id';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Id", $id );
		$stmt->execute ();
		
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
		
		$entry = self::assignValues ( new \BE\BEGuestBookEntry (), $result );
		
		return $entry;
	}
	
	function findAll() {
		$sql = 'SELECT * FROM GuestBookEntry';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->execute ();
		
		$entries = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			
			$entry = self::assignValues ( new \BE\BEGuestBookEntry (), $result );
			$entries [] = $entry;
		}
		return $entries;
	}
	
	function save(\BE\BEUser $user) {
		
	}
	
	
	
}

