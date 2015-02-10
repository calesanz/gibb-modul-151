<?php
namespace Controller;

class userController implements IController{
	
	public function __construct(){
		
	}
	public function index(){
		
		$users = \BO\BOUser::findAll();
		
	(new \View\View('user.anzeigen',array('users'=>$users)))->display();
	
	
	
	}
	public function create(){}
	public function  __destruct(){}

}
