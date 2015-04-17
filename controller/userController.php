<?php

namespace Controller;

class userController implements IController {
	public function __construct($param, $data, $session) {
		$this->param = $param;
		$this->data = $data;
		$this->session = $session;
	}
	public function index() {
		$this->listusers ();
	}
	public function detail() {
		$user = \BO\BOUser::find ( $this->param );
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
		
		$this->innerView = new \View\View ( 'user.list', array (
				'users' => $users 
		) );
		$this->create ();
	}
	public function register() {
		$errorMessage = "";
		$error = false;
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
			// Do the register logic and validation
		if (isset ( $this->data ['submit'] ))
			if ( isset ( $this->data ['password'] ) && isset ( $this->data ['password2'] ) && isset ( $this->data ['email'] ) && isset ( $this->data ['fullname'] )) {
				
				$password = $this->data ['password'];
				$password2 = $this->data ['password'];
				
				$user = new \BE\BEUser ();
				$user->Email = $this->data ['email'];
				$user->FullName = $this->data ['fullname'];
				// add user
				
				try {
					$user = \BO\BOUser::register ( $user, $password, $password2 );
					
					if ($user->Id > 0) {
						
						$_SESSION ['userId'] = $user->Id;
						$_SESSION ['FullName'] = $user->FullName;
						// Logged In
						\Redirector::redirect ( $backurl );
						return;
					} else
						$errorMessage .= "<li>Unknown error!</li>";
				} catch ( \Exception $ex ) {
					$errorMessage .= $ex->getMessage ();
				}
			} else
				$errorMessage .= "<li>Please fill in all fields!</li>";
			
			//chached data
			$email = isset($this->data ['email']) ? $this->data['email']:"" ;
			$fullname =isset($this->data ['fullname']) ? $this->data['fullname']:"" ;
			// Display Login Page
		$this->innerView = new \View\View ( 'user.registrieren', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl ,
				'fullname' =>$fullname,
				'email' => $email
			
		) );
		$this->create ();
	}
	public function logout() {
		session_destroy ();
		\Redirector::redirect ( "/" );
	}
	public function login() {
		$errorMessage = "";
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		if (isset ( $this->data ['submit'] ))
			if (isset ( $this->data ['email'] ) && isset ( $this->data ['password'] )) {
				try {
					$user = \BO\BOUser::login ( $this->data ['email'], $this->data ['password'] );
					if ($user->Id > 0) {
						
						$_SESSION ['userId'] = $user->Id;
						$_SESSION ['FullName'] = $user->FullName;
						// Logged In
						\Redirector::redirect ( $backurl );
						return;
					} else
						$errorMessage = "Incorrect credentials!";
				} catch ( \Exception $ex ) {
					// Show error
					$errorMessage .= "<li>" . $ex->getMessage () . "</li>";
				}
			} else
				$errorMessage = "Please enter credentials!";
			
			// Display Login Page
		$this->innerView = new \View\View ( 'user.login', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl 
		) );
		$this->create ();
	}
	public function create() {
		$this->innerView = (new \View\View ( 'mainpage', array (
				'title' => 'Login',
				'innercontent' => $this->innerView 
		) ))->display ();
	}
	public function __destruct() {
	}
}
