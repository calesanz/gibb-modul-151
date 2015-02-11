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
	
	}
	
	
}

