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
	public function bearbeiten($param, $data, $session) {
		$errors = "";
		$guestbook = null;
		if (isset ( $session ['userId'] )) {
			if (isset ( $param ) && isNumber ( $param ) && $param > 0) {
				$guestbook = \BO\BOGuestBook::find ( $number );
			} else {
				$guestbook = new \BE\BEGuestBookEntry ();
			}
			
			if (isset ( $data ['inhalt'] )) {
				$guestbook->Text = $data ['inhalt'];
				$guestbook->UserId = $session ['userId'];
				$guestbook->CreatedAt = (new \DateTime())->format('Y-m-d H:i:s');
				$errors += \BO\BOGuestBook::save($guestbook);
			}
		} else {
			$errors+="<li>Access denied!</li>";
			// TODO Permission warning
		}
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array (
				'errors' => $errors,
				'guestbookentry' => $guestbook 
		) );
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
