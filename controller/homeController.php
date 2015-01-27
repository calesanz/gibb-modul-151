<?php
class homeController implements IController {
	
	
		public function __construct(){}
	
	public function index(){
		$this->create();
	}
	
	public function create(){
	 echo json_encode($_REQUEST);
			
	}
		
	public function __destruct(){
	}
}
