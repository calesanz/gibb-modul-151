<?php 
namespace Controller;

interface IController{
	public function __construct();
	
	public function index($param, $data, $session);
	
	public function create();
	
	public function __destruct();
}
