<?php
class gaestebuchController implements IController {
	public function __construct() {
	}
	public function index() {
		$inhalt = "";
		
		if ($db = SqlConnector::getOpenConnection ()) {
			
			$stmt = $db->prepare ( "SELECT name,email,url,datum,eintrag FROM gaestebuch;" );
			
			if ($stmt->execute ()) {
				$stmt->bind_result ( $name, $email,$url,$datum,$eintrag );
				
				while ( $stmt->fetch () ) {
					$inhalt .= "$name $email $url $datum $eintrag";
				}
				
				$stmt->fetch ();
			}
			$db->close ();
			
			$this->innerView = new View ( 'gaestebuch.anzeigen', array (
					'inhalt' => $inhalt 
			) );
			
			$this->create ();
		}
	}
	public function bearbeiten() {
		$this->innerView = new View ( 'gaestebuch.bearbeiten', array () );
		$this->create ();
	}
	public function create() {
		(new View ( 'gaestebuch', array (
				'title' => 'Gästebuch',
				'innercontent' => $this->innerView 
		) ))->display ();
	}
	public function __destruct() {
	}
}
