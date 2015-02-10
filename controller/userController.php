<?php
namespace Controller;

class userController implements IController{
	
	public function __construct(){
		
	}
	public function index(){
		
		$users = \BO\BOUser::findAll();
		var_dump($users);
	(new View('user.anzeigen',array('users'=>$users)))->display();
	
	
	
	}
	public function create(){}
	public function  __destruct(){}

}
