<?php

namespace Controller;

class userController implements IController {
	public function __construct($param, $data, $session) {
		$this->param = $param;
		$this->data = $data;
		$this->session = $session;
		$this->exceptionMessages = [ ];
	}
	public function index() {
		$this->listusers ();
	}
	public function detail() {
		if (! isset ( $this->session ['userId'] ))
			\Redirector::redirect ( "/user/login?backurl=/user/listusers" );
		else {
			$user = \BO\BOUser::find ( $this->param );
			if ($user && ! $user->isNew ()) {
				
				(new \View\View ( 'user.detail', array (
						'user' => $user 
				) ))->display ();
			} else {
				$this->listusers ();
			}
		}
	}
	public function listusers() {
		if (! isset ( $this->session ['userId'] ))
			\Redirector::redirect ( "/user/login?backurl=/user/listusers" );
		else {
			
			$users = \BO\BOUser::findAll ();
			
			$this->innerView = new \View\View ( 'user.list', array (
					'users' => $users 
			) );
		}
	}
	public function changepassword() {
		$errorMessage = "";
		if (empty ( $this->session ['userId'] )) {
			\Redirector::redirect ( "/user/login?backurl=/user/changepassword" );
			return;
		}
		
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		$user = \BO\BOUser::find ( $this->session ['userId'] );
		// If all data is set
		if (isset ( $user->Id ) && isset ( $this->data ['oldpassword'] ) && isset ( $this->data ['newpassword'] ) && isset ( $this->data ['newpassword2'] )) {
			try {
				\BO\BOUser::changePassword ( $user, $this->data ['oldpassword'], $this->data ['newpassword'], $this->data ['newpassword2'] );
				\Redirector::redirect ( $backurl );
			} 

			catch ( \Exception $ex ) {
				$this->exceptionMessages [] = $ex->getMessage ();
			}
		}
		
		// Display
		
		$this->innerView = new \View\View ( 'user.changepassword', array (
				'backurl' => $backurl,
				'email' => $user->Email 
		) );
	}
	public function register() {
		$errorMessage = "";
		$error = false;
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
		try {
			// Do the register logic and validation
			if (isset ( $this->session ['userId'] ))
				throw new \Exception\UserFaultException ( "You are already Logged in!" );
			
			if (isset ( $this->data ['submit'] )) {
				if (empty ( $this->data ['password'] ) || empty ( $this->data ['password2'] ) || empty ( $this->data ['email'] ) || empty ( $this->data ['fullname'] ))
					throw new \Exception\UserFaultException ( "Please fill in all fields!" );
				
				$password = $this->data ['password'];
				$password2 = $this->data ['password2'];
				
				$user = new \BE\BEUser ();
				$user->Email = $this->data ['email'];
				$user->FullName = $this->data ['fullname'];
				// add user
				
				$user = \BO\BOUser::register ( $user, $password, $password2 );
				
				if ($user->Id > 0) {
					
					$_SESSION ['userId'] = $user->Id;
					$_SESSION ['FullName'] = $user->FullName;
					// Logged In
					\Redirector::redirect ( $backurl );
					return;
				} else
					throw new \Exception\UnknownException ( "Unknown Error!" );
			}
		} catch ( \Exception $ex ) {
			$this->exceptionMessages [] = $ex->getMessage ();
		}
		
		// chached data
		$email = isset ( $this->data ['email'] ) ? $this->data ['email'] : "";
		$fullname = isset ( $this->data ['fullname'] ) ? $this->data ['fullname'] : "";
		
		// Display Login Page
		$this->innerView = new \View\View ( 'user.registrieren', array (
				'backurl' => $backurl,
				'fullname' => $fullname,
				'email' => $email 
		) );
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
			try {
				if (empty ( $this->data ['email'] ) || empty ( $this->data ['password'] ))
					throw new \Exception\UserFaultException ( "Please enter credentials!" );
				
				$user = \BO\BOUser::login ( $this->data ['email'], $this->data ['password'] );
				if ($user->Id > 0) {
					
					$_SESSION ['userId'] = $user->Id;
					$_SESSION ['FullName'] = $user->FullName;
					// Logged In
					\Redirector::redirect ( $backurl );
					return;
				} else
					throw new \Exception\AccessDeniedException ( "Incorrect credentials!" );
			} catch ( \Exception $ex ) {
				$this->exceptionMessages [] = $ex->getMessage ();
			}
			// Display Login Page
		$this->innerView = new \View\View ( 'user.login', array (
				'backurl' => $backurl 
		) );
	}
	public function create() {
	}
	public function __destruct() {
		$fullname = isset ( $this->session ['FullName'] ) ? $this->session ['FullName'] : null;
		
		$this->innerView = (new \View\View ( 'mainpage', array (
				'title' => 'User',
				'exceptionMessages' => $this->exceptionMessages,
				'innercontent' => $this->innerView,
				'fullname' => $fullname 
		) ))->display ();
	}
}
