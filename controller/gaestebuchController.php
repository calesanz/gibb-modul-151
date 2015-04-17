<?php

namespace Controller;

class gaestebuchController implements IController {
	public function __construct($param, $data, $session) {
		$this->param = $param;
		$this->data = $data;
		$this->session = $session;
	}
	public function index() {
		$entries = array ();
		$entries = \BO\BOGuestBook::findAll ();
		if (isset ( $this->session ['userId'] )) {
			foreach ( $entries as $entry ) {
				if ($entry->User->Id == $this->session ['userId']) {
					// Show Edit
					$entry->editLink = "/gaestebuch/bearbeiten/" . $entry->Id;
				}
			}
		}
		$this->innerView = new \View\View ( 'gaestebuch.anzeigen', array (
				'entries' => $entries 
		) );
		
		$this->create ();
	}
	public function bearbeiten() {
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		
		$errors = "";
		
		$guestbookId = $this->param;
		if (! (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0))
			$guestbookId = isset ( $this->data ['guestbookId'] ) ? $this->data ['guestbookId'] : 0;
		
		$guestbook = new \BE\BEGuestBookEntry ();
		
		if (isset ( $this->session ['userId'] )) {
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0) {
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
			}
			
			// Checks if user is allowed to modify
			if ($guestbook->UserId == $this->session ['userId'] || $guestbook->UserId == 0) {
				if (isset ( $this->data ['inhalt'] )) {
					$guestbook->Text = $this->data ['inhalt'];
					$guestbook->UserId = $this->session ['userId'];
					$guestbook->CreatedAt = date ( 'Y-m-d H:i:s' );
					
					$errors .= \BO\BOGuestBook::save ( $guestbook );
					if ($errirs == "") {
						// Redirect back
						\Redirector::redirect ( $backurl );
						return;
					}
				}
			} else {
				$errors .= "<li>Warning: You can only modify your own posts!</li>";
			}
		} else {
			$errors .= "<li>Access denied!</li>";
		}
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array (
				'errors' => $errors,
				'guestbookentry' => $guestbook,
				'backurl' => $backurl 
		) );
		$this->create ();
	}
	public function loeschen() {
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		
		$errors = "";
		$guestbook = new \BE\BEGuestBookEntry ();
		$guestbookId = $this->data ['guestbookId'];
		if (isset ( $this->session ['userId'] )) {
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0) {
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
				
				// Checks if user is allowed to modify
				if ($guestbook->UserId == $this->session ['userId']) {
					$errors .= \BO\BOGuestBook::delete ( $guestbook );
					if ($errors == "") {
						// Redirect back
						\Redirector::redirect ( $backurl );
						return;
					}
				} else {
					$errors .= "<li>Warning: You can only delete your own posts!</li>";
				}
			} else
				$errors .= "<li>No entry specified!</li>";
		} else {
			$errors .= "<li>Access denied!</li>";
		}
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array (
				'errors' => $errors,
				'guestbookentry' => $guestbook,
				'backurl' => $backurl 
		) );
		$this->create ();
	}
	public function create() {
		$fullname = isset($this->session['fullname'])?$this->session['fullname']:null;
		(new \View\View ( 'mainpage', array (
				'title' => 'Guestbook',
				'innercontent' => $this->innerView,
				'fullname' => $fullname
		) ))->display ();
	}
	public function __destruct() {
	}
}
