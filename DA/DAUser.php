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
		
		
		$sql = 'SELECT * FROM User WHERE Email = :Email';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Email", $email );
		
		$stmt->execute ();
		
		
		if($stmt->rowCount() < 1)
			throw new \Exception("Incorrect credentials!");
		
				
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
			
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
		
		if(self::getPasswordHash($password,$user->PasswordSalt) === $user->Password){
			return $user;
		}
		else{
			throw new \Exception("Incorrect credentials!");
			
		}
		
	}
	
	function changePassword($user,$oldpassword,$newpassword){
		$sql = 'SELECT * FROM User WHERE Email = :Email';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Email", $email );
		
		$stmt->execute ();
		
				
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
			
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
	//Check if old password is correct
		if(self::getPasswordHash($oldpassword,$user->PasswordSalt) === $user->Password){
			
			$salt =  \mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
			$newpassword = self::getPasswordHash($newpassword,$salt);
			
			
			$sql = "UPDATE User SET Password = :Password, PasswordSalt = :PasswordSalt WHERE Email = :Email";
			$db = self::getConnection ();
			$stmt = $db->prepare ( $sql );
			$stmt->bindValue ( ":Email", $user->Email );
			$stmt->bindValue ( ":Password", $newpassword );
			$stmt->bindValue ( ":PasswordSalt", $salt );
			
			$stmt->execute ();
			$userId = $db->lastInsertId();
			$user =  self::find($userId);
			return $user;
			
			
		}
		else{
			throw new \Exception("Incorrect credentials!");
				
		}
		
	}
	
	
	
}

