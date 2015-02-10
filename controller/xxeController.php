<?php
class xxeController implements IController{
	
	public function __construct(){
		
	}
	public function index(){
	
		(new View('xmlsearch',array('nestedview'=>
				(new View('works',array('titel'=>'thafuuug'))))
		))->display();
	}
	public function search(){
		//libxml_disable_entity_loader(true);
		//$contents=file_get_contents($_FILES['filename']['tmp_name']);
		$contents = file_get_contents('php://input');
		var_dump($contents);
// 		$dom = new DOMDocument();
		
// 		if ($dom->load($xml) !== FALSE)
// 			echo "loaded remote xml!\n";
// 		else
// 			echo "failed to load remote xml!\n";
		
		
	}
	
	public function create(){}
	public function  __destruct(){}

}
