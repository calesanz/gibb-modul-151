<?php 
namespace Controller;
interface IController{
	public function __construct();
	
	public function index();
	
	public function create();
	
	public function __destruct();
}
