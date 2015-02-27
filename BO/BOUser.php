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
	
	static function register(\BEUser $user){
		
	}
	
	
	// TODO: Cchange Password
	static function changePassword(){
	
	}
	
	
}

