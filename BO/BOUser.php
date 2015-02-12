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
			
		}
		return  $error;
	}
	
	static function validate(\BEUser $user){
		$message ="";
		if($user.id == 0){
			$message .= "User cannot be null!";
		}
		
		return $message;
		
	}
	
	
}

