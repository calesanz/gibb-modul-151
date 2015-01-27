<?php
require_once ('controller/homeController.php');
class DefaultController implements IController{
	
	public function __construct(){
		
	}
	public function index(){
		(new homeController())->index();
	}
	public function create(){}
	public function  __destruct(){}

}
?>