<?php
namespace Controller;
class gaestebuchController implements IController {
	public function __construct() {
	}
	public function index() {
		$inhalt = "";
		
		if ($db = SqlConnector::getOpenConnection ()) {
			
			$stmt = $db->prepare ( "SELECT name,email,url,datum,eintrag FROM gaestebuch;" );
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			if ($stmt->execute ()) {
				
				
				while ($result = $stmt->fetch () ) {
					$inhalt .= "$result->eintrag ";
				}
				
				$stmt->fetch ();
			}
			
			
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
