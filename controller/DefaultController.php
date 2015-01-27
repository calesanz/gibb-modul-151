<?php
class DefaultController implements IController{
	
	public function __construct(){
		
	}
	public function index(){
	
	(new View('works',array('titel'=>'Wohooo')))->display();
	}
	public function create(){}
	public function  __destruct(){}

}
