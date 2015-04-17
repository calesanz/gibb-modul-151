<?php

namespace Controller;

class gaestebuchController implements IController {
	public function __construct() {
	}
	public function index($param, $data, $session) {
		$entries = array ();
		$entries = \BO\BOGuestBook::findAll ();
		if (isset ( $session ['userId'] )) {
			foreach ( $entries as $entry ) {
				if ($entry->User->Id == $session ['userId']) {
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
	public function bearbeiten($param, $data, $session) {
		$backurl = "/";
		if (isset ( $data ['backurl'] ))
			$backurl = $data ['backurl'];
		
		$errors = "";
		
		$guestbookId = $param;
		if (! (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0))
			$guestbookId = isset ( $data ['guestbookId'] ) ? $data ['guestbookId'] : 0;
		
		$guestbook = new \BE\BEGuestBookEntry ();
		
		if (isset ( $session ['userId'] )) {
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0) {
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
			}
			
			// Checks if user is allowed to modify
			if ($guestbook->UserId == $session ['userId'] || $guestbook->UserId == 0) {
				if (isset ( $data ['inhalt'] )) {
					$guestbook->Text = $data ['inhalt'];
					$guestbook->UserId = $session ['userId'];
					$guestbook->CreatedAt = date ( 'Y-m-d H:i:s' );
					var_dump ( $guestbook );
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
	public function loeschen($param, $data, $session) {
		$backurl = "/";
		if (isset ( $data ['backurl'] ))
			$backurl = $data ['backurl'];
		
		$errors = "";
		$guestbook = new \BE\BEGuestBookEntry ();
		$guestbookId = $data ['guestbookId'];
		if (isset ( $session ['userId'] )) {
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0) {
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
				
				// Checks if user is allowed to modify
				if ($guestbook->UserId == $session ['userId']) {
					$errors .= \BO\BOGuestBook::delete ( $guestbook );
					if ($errirs == "") {
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
		(new \View\View ( 'mainpage', array (
				'title' => 'Gästebuch',
				'innercontent' => $this->innerView 
		) ))->display ();
	}
	public function __destruct() {
	}
}
