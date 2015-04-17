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
		$error= $this->validate($user);
		if ($error!=""){
			// TODO: Save User
		}
		return  $error;
	}
	
	static function validate(\BEUser $user){
		$message ="";
		if($user.id == 0){
			$message .= "<li>User cannot be null!</li>";
		}
		return $message;
		
	}
	
	static function login($email,$password){
		
		 return \DA\DAUser::findByEmailPassword($email,$password);
	}
	
	static function register(\BE\BEUser $user,$password,$passwordrepeat){
		$errorMessage ="";
		if(!ctype_alnum ($user->Username)||strlen($user->Username)!=6){
		
			$errorMessage .= '<li>Username must be alphanumeric and six characters long.</li>';
		}
		if(!filter_var($user->Email, FILTER_VALIDATE_EMAIL)){
				
			$errorMessage .='<li>Invalid email address!</li>';
		}
		if(1!=preg_match ("/^[a-z0-9 ]*$/i",$user->FullName)){
		
			$errorMessage .= '<li>Fullname must be alphanumeric.</li>';
		}
		if(1!=preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/",$password)){
				
			$errorMessage .= '<li>Password: min. 8 characters, numbers, letters (capital and lowercase) and special characters</li>';
		}
		if($password!=$passwordrepeat){
				
			$errorMessage .= '<li>Passwords do not match!</li>';
		}
		
		if($errorMessage == ""){
			return \DA\DAUser::addUser($user,$password);
		}
		else{
			throw new \Exception($errorMessage);
		}
		
	}
	
	static function validateUser(\BEUser $user){
		$errorMessage = FALSE;
		
		return $errorMessage;
		
		
	}
	static function validatePassword($password,$repeatpassword){
		$errorMessage = FALSE;
		
		return $errorMessage;
		
	}
	
	// TODO: Cchange Password
	static function changePassword(){
	
	}
	
	
}

