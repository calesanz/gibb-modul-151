<?php

namespace Controller;

class userController implements IController {
	public function __construct() {
	}
	public function index() {
		$this->listusers ();
	}
	public function detail($param) {
		$user = \BO\BOUser::find ( $param );
		if ($user && ! $user->isNew ()) {
			
			(new \View\View ( 'user.detail', array (
					'user' => $user 
			) ))->display ();
		} else {
			$this->listusers ();
		}
	}
	public function listusers() {
		$users = \BO\BOUser::findAll ();
		
		(new \View\View ( 'user.list', array (
				'users' => $users 
		) ))->display ();
	}
	public function register() {
	}
	public function login($param, $data, $session) {
		$errorMessage = "";
		$backurl = "/";
		if (isset ( $data ['backurl'] ))
			$backurl = $data ['backurl'];
		
		if (isset ( $data ['email'] ) && isset ( $data ['password'] )) {
			$user = \BO\BOUser::login ( $data ['email'], $data ['password'] );
			if ($user->Id > 0) {
				
				$session ['userId'] = $user->Id;
				$session ['FullName'] = $user->FullName;
				// Logged In
						
				header ( "Location: $backurl" );
				header ( "HTTP/1.1 302 Found" );
				return;
			} else
				$errorMessage = "Incorrect credentials!";
		} else
			$errorMessage = "Please enter credentials!";
			
			// Display Login Page
		(new \View\View ( 'user.login', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl 
		) ))->display ();
	}
	public function create() {
	}
	public function __destruct() {
	}
}
