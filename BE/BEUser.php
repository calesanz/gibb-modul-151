<?php 
namespace BE;

class BEUser extends BE_Base{
	public $Id = 0;
	public $Email = null;
	public $FullName = null;
	
	
	public function isNew(){
		return $this->Id===0;
	}
	
	public function getCompareString(){
		return "$this->Id $this->Username $this->Email $this->FullName";
	}
	
}

