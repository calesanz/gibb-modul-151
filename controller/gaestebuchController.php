<?php

namespace Controller;

class gaestebuchController implements IController {
	public function __construct($param, $data, $session) {
		$this->param = $param;
		$this->data = $data;
		$this->session = $session;
		$this->exceptionMessages = [ ];
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
	}
	public function bearbeiten() {
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		
		try {
			$errors = "";
			
			$guestbookId = $this->param;
			if (! (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0))
				$guestbookId = isset ( $this->data ['guestbookId'] ) ? $this->data ['guestbookId'] : 0;
			
			$guestbook = new \BE\BEGuestBookEntry ();
			
			if (empty ( $this->session ['userId'] ))
				throw new \Exception\AccessDeniedException ();
			
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0) {
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
			}
			
			// Checks if user is allowed to modify
			if (! ($guestbook->UserId == $this->session ['userId'] || $guestbook->UserId == 0))
				throw new \Exception\AccessDeniedException ( "You can only modify your own posts!" );
			
			if (isset ( $this->data ['inhalt'] )) {
				$guestbook->Text = $this->data ['inhalt'];
				$guestbook->UserId = $this->session ['userId'];
				$guestbook->CreatedAt = date ( 'Y-m-d H:i:s' );
				
				\BO\BOGuestBook::save ( $guestbook );
				\Redirector::redirect ( $backurl );
				return;
			}
		} catch ( \Exception\AccessDeniedException $adx ) {
			$this->exceptionMessages [] = $adx->getMessage ();
		} catch ( \Exception $ex ) {
			// This should never happen!
			$this->exceptionMessages [] = (new UnknownException ())->getMessage ();
		}
		
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array (
				'guestbookentry' => $guestbook,
				'backurl' => $backurl 
		) );
	}
	public function loeschen() {
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		
		$guestbook = new \BE\BEGuestBookEntry ();
		$guestbookId = $this->data ['guestbookId'];
		try {
			if (empty ( $this->session ['userId'] ))
				throw new \Exception\AccessDeniedException ();
			
			if (isset ( $guestbookId ) && is_numeric ( $guestbookId ) && $guestbookId > 0)
				$guestbook = \BO\BOGuestBook::find ( $guestbookId );
			
			if ($guestbook->Id == 0)
				throw new \Exception\UserFaultException ( "No valid entry specified!" );
				
				// Checks if user is allowed to modify
			if ($guestbook->UserId != $this->session ['userId'])
				throw new \Exception\AccessDeniedException ( "You can only delete your own posts!" );
				
				// Call to delete
			\BO\BOGuestBook::delete ( $guestbook );
			
			// Redirect back
			\Redirector::redirect ( $backurl );
			return;
		} catch ( \Exception\AccessDeniedException $adx ) {
			$this->exceptionMessages [] = $adx->getMessage ();
		} catch ( \Exception $ex ) {
			// This should never happen!
			$this->exceptionMessages [] = $ex->getMessage ();
		}
		$this->innerView = new \View\View ( 'gaestebuch.bearbeiten', array (
				'guestbookentry' => $guestbook,
				'backurl' => $backurl 
		) );
	}
	public function create() {
	}
	public function __destruct() {
		$fullname = isset ( $this->session ['FullName'] ) ? $this->session ['FullName'] : null;
		(new \View\View ( 'mainpage', array (
				'title' => 'Guestbook',
				'innercontent' => $this->innerView,
				'fullname' => $fullname,
				'exceptionMessages' => $this->exceptionMessages 
		) ))->display ();
	}
}
