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
		$sql = 'SELECT * FROM GuestBookEntry ORDER BY CreatedAt DESC';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->execute ();
		
		$entries = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			
			$entry = self::assignValues ( new \BE\BEGuestBookEntry (), $result );
			$entries [] = $entry;
		}
		return $entries;
	}
	function save(\BE\BEGuestBookEntry $entry) {
		$sql = "";
		
		if ($entry->Id > 0)
			$sql = "UPDATE GuestBookEntry SET 
					Text = :Text,
					CreatedAt = :CreatedAt,
					UserId = :UserId
					WHERE Id = :Id
					";
		else
			$sql = 'INSERT INTO GuestBookEntry(Text,CreatedAt,UserId) VALUES (:Text,:CreatedAt,:UserId)';
		try {
			$stmt = self::getConnection ()->prepare ( $sql );
			if ($entry->Id > 0)
				$stmt->bindValue ( ":Id", $entry->Id );
			$stmt->bindValue ( ":UserId", $entry->UserId );
			$stmt->bindValue ( ":CreatedAt", $entry->CreatedAt );
			$stmt->bindValue ( ":Text", $entry->Text );
			
			$stmt->execute ();
		} catch ( \Exception $e ) {
			throw new \Exception\UnknownException( "An internal Error ocourred!");
		}
		
	}
	function delete(\BE\BEGuestBookEntry $entry) {
		$sql = "DELETE FROM GuestBookEntry WHERE Id = :Id";
		
		try {
			$stmt = self::getConnection ()->prepare ( $sql );
			
			$stmt->bindValue ( ":Id", $entry->Id );
			
			$stmt->execute ();
		} catch ( \Exception $e ) {
			throw new \Exception\UnknownException(  "Could not delete entry. An internal Error ocourred!");
		}
	}
}

