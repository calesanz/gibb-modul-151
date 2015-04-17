<?php
namespace Controller;

class DefaultController implements IController{
	
	public function __construct($param, $data, $session){
		
	}
	public function index(){
		header ( "Location: /gaestebuch" );
		header ( "HTTP/1.1 302 Found" );
	}
	public function create(){}
	public function  __destruct(){}

}
