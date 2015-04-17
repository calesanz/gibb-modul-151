<?php 
namespace Controller;

interface IController{
	public function __construct($param, $data, $session);
	
	public function index();
	
	public function create();
	
	public function __destruct();
}
