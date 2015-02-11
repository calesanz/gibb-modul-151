<?php 
namespace BE;

class BEUser extends BE_Base{
	public $id = 0;
	public $username = null;
	public $email = null;
	
	public function isNew(){
		return $this->id===0;
	}
	
	public function getCompareString(){
		return "$this->id $this->username $this->email";
	}
	
}

