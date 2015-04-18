<?php 
namespace BO;



class BOUser extends BO_Base{
	
	static function find($id){
		return \DA\DAUser::find($id);
	}
	
	static function findAll(){
		return \DA\DAUser::findAll();
	}
	
	static function save(\BEUser $user){
		throw new \Exception\NotImplementedException();
	}
	
	
	static function login($email,$password){
		
		 return \DA\DAUser::findByEmailPassword($email,$password);
	}
	
	static function register(\BE\BEUser $user,$password,$passwordrepeat){
		$errorMessages =[];
		
		if(!filter_var($user->Email, FILTER_VALIDATE_EMAIL)){
				
			$errorMessages[] ='Invalid email address!';
		}
		if(1!=preg_match ("/^[a-z0-9 ]*$/i",$user->FullName)){
		
			$errorMessages[] = 'Fullname must be alphanumeric.';
		}
		if(1!=preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/",$password)){
				
			$errorMessages[] = 'Password: min. 8 characters, numbers, letters (capital and lowercase) and special characters';
		}
		if($password!==$passwordrepeat){
				
			$errorMessages[] = 'Passwords do not match!';
		}
		
		if(empty($errorMessages)){
			return \DA\DAUser::addUser($user,$password);
		}
		else{
			$fault = new \Exception\MultiFaultException();
			$fault->setMessages($errorMessages);
			throw $fault;
		}
		
	}
	
	
	
	
	static function changePassword(\BE\BEUser $user,$oldpassword,$newpassword,$newpasswordrepeat){
	
		if(1!=preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/",$newpassword)){
		
			$errorMessage .= '<li>Password: min. 8 characters, numbers, letters (capital and lowercase) and special characters</li>';
		}
		if($newpassword!=$newpasswordrepeat){
		
			$errorMessage .= '<li>Passwords do not match!</li>';
		}
		
		if($errorMessage == ""){
			return \DA\DAUser::changePassword($user,$oldpassword,$newpassword);
		}
		else{
			throw new \Exception($errorMessage);
		}
	}
	
	
}

