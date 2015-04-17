<?php

namespace DA;

class DAUser extends DA_Base {
	
	function find($id) {
		$sql = 'SELECT * FROM User WHERE Id = :Id';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Id", $id );
		$stmt->execute ();
		
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
		
		return $user;
	}
	
	function findAll() {
		$sql = 'SELECT * FROM User';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->execute ();
		
		$people = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			
			$user = self::assignValues ( new \BE\BEUser (), $result );
			$people [] = $user;
		}
		return $people;
	}
	
	function save(\BE\BEUser $user) {
		
	}
	
	function addUser(\BE\BEUser $user,$password){
		//Check if user already exists
		$sql = "SELECT * FROM User WHERE Email = :Email";
	
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Email", $user->Email );
		$stmt->execute ();
		if($stmt->rowCount()>0)
			throw new \Exception("Email already in use!");
		
		//If user does not exist generate salt an pw hash
		$salt =  \mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
		$password = self::getPasswordHash($password,$salt);
		
		
		$sql = "INSERT INTO User(Username,Email,Password,PasswordSalt,FullName) VALUES (:Username,:Email,:Password,:PasswordSalt,:FullName);";
		$db = self::getConnection ();
		$stmt = $db->prepare ( $sql );
		$stmt->bindValue ( ":Email", $user->Email );
		$stmt->bindValue ( ":Username", $user->Username );
		$stmt->bindValue ( ":Password", $password );
		$stmt->bindValue ( ":PasswordSalt", $salt );
		$stmt->bindValue ( ":FullName", $user->FullName );
		$stmt->execute ();
		$userId = $db->lastInsertId();
		$user =  self::find($userId);
		return $user;
	}
	
	private static function getPasswordHash($password,$salt){ 
		return  \hash('sha256', $password . $salt );
	}
	
	function findByEmailPassword($email,$password){
		//TODO Salt
		
		
		$sql = 'SELECT * FROM User WHERE Email = :Email AND Password = :Password';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Email", $email );
		$stmt->bindValue ( ":Password", $password );
		$stmt->execute ();
		
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
			
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
		var_dump($user);
		
		return $user;
	}
	
	
	
	
	
}

