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
		if ($user && !$user->isNew()) {
			
			(new \View\View ( 'user.detail', array (
					'user' => $user 
			) ))->display ();
		}
		else{
			$this->listusers ();
		}
	}
	public function listusers() {
		$users = \BO\BOUser::findAll ();
		
		(new \View\View ( 'user.list', array (
				'users' => $users 
		) ))->display ();
	}
	public function create() {
	}
	public function __destruct() {
	}
}
