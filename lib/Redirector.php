<?php 

class Redirector{
	public static function redirect($url){
	
		if(!preg_match("/^\/.*$/",$url))
			$url = "/";
		
		if(strpos($url, '?') !== FALSE)
			$url = "/";
		
		header ( "Location: $url" );
		header ( "HTTP/1.1 302 Found" );
		
	}
	
}