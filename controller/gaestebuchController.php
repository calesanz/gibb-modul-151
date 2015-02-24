<?php

namespace Controller;

class gaestebuchController implements IController {
	public function __construct() {
	}
	public function index() {
		$entries = array ();
		$entries = \BO\BOGuestBook::findAll ();
		$this->innerView = new \View\View ( 'gaestebuch.anzeigen', array (
				'entries' => $entries 
		) );
		
		$this->create ();
	}
	public function bearbeiten() {
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array () );
		$this->create ();
	}
	public function create() {
		(new \View\View ( 'gaestebuch', array (
				'title' => 'Gästebuch',
				'innercontent' => $this->innerView 
		) ))->display ();
	}
	public function __destruct() {
	}
}
