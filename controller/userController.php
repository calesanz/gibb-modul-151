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
			$this->create ();
		}
	}
	public function changepassword() {
		$errorMessage="";
		if (! isset ( $this->session ['userId'] ))
			\Redirector::redirect ( "/user/login?backurl=/user/changepassword" );
		else {
			$backurl = "/";
			if (isset ( $this->data ['backurl'] ))
				$backurl = $this->data ['backurl'];
			$user = \BO\BOUser::find ( $this->session ['userId'] );
			//If all data is set
			if (isset($user->Id)&&isset ( $this->data ['oldpassword'] ) && isset ( $this->data ['newpassword'] ) && isset ( $this->data ['newpassword2'] )) {
				try{
				\BO\BOUser::changePassword($user,
						 $this->data ['oldpassword'],
						$this->data ['newpassword'],
						$this->data ['newpassword2']);
				\Redirector::redirect($backurl);
				}
				
				catch(\Exception $ex){
					$errorMessage .="<li>".$ex->getMessage()."</li>";
				}
				
			}
			
			//Display
			
			$this->innerView = new \View\View ( 'user.changepassword', array (
					'errorMessage' => $errorMessage,
					'backurl' => $backurl,
					'email' => $user->Email 
			) );
			$this->create ();
		}
	}
	public function register() {
		$errorMessage = "";
		$error = false;
		$backurl = "/";
		if (isset ( $this->data ['backurl'] ))
			$backurl = $this->data ['backurl'];
			// Do the register logic and validation
		if (isset ( $this->data ['submit'] ))
			if (isset ( $this->data ['password'] ) && isset ( $this->data ['password2'] ) && isset ( $this->data ['email'] ) && isset ( $this->data ['fullname'] )) {
				
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
			
			// chached data
		$email = isset ( $this->data ['email'] ) ? $this->data ['email'] : "";
		$fullname = isset ( $this->data ['fullname'] ) ? $this->data ['fullname'] : "";
		// Display Login Page
		$this->innerView = new \View\View ( 'user.registrieren', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl,
				'fullname' => $fullname,
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
		$fullname = isset($this->session['FullName'])?$this->session['FullName']:null;
		
		$this->innerView = (new \View\View ( 'mainpage', array (
				'title' => 'User',
				'innercontent' => $this->innerView,
				'fullname'=>$fullname
		) ))->display ();
	}
	public function __destruct() {
	}
}
