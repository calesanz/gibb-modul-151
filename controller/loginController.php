<?php
class loginController implements IController {
	public function __construct() {
		
	}
	public function create() {
	
		$this->login();
	}
	
	public function index() {
		$this->create ();
	}

	public function login($params) {
		if(isset($params['email'])&&isset($params['passwort'])){
		$email = $params ['email'];
		$passwd = $params ['passwort'];}
		if ($email !=null && $passwd!=null) {
					
			if ($db = new DB()) {
   				$stmt = $db->prepare("SELECT email,benutzername,vorname,nachname,passwort FROM BENUTZER WHERE email=:email AND passwort=:passwort");
    			$stmt->bindValue(":email", $email, SQLITE3_TEXT);
   				$stmt->bindValue(":passwort", sha1($passwd), SQLITE3_TEXT);
				
    			if ($res=$stmt->execute()) {
          			$rows = array();
          		
    				while($data = $res->fetchArray())
    				{
        				
        				 $rows[] = $data;
    				}
    				$stmt->close();
    				$db->close();
    				if(count($rows)>0){
						// Login Successful
						$_SESSION['email'] = $rows[0]['email'];
						$_SESSION['benutzername']=$rows[0]['benutzername'];
						$_SESSION['vorname']=$rows[0]['vorname'];
						$_SESSION['nachname']=$rows[0]['nachname'];
						
						echo json_encode( array ('status' => 'ok','message'=>'success','data'=>array(
						'benutzername'=>$_SESSION['benutzername'],
						'email'=>$_SESSION['email'],
						'vorname'=>$_SESSION['vorname'],
						'nachname'=>$_SESSION['nachname']
						)));
					}else{
						echo json_encode( array ('status' => 'error','error' => 'wrong-username-password','message'=>"Benutzername und Passwort stimmen nicht überein."));
					}
			
				}
      
    		}
    		else{
					echo json_encode(array ('status' => 'error','error'=>'database-error','message'=>'Datenbank Fehler'));
				}             
		}else{
			echo json_encode( array ('status' => 'error','error' => 'username-password-empty','message'=>'Benutzername und Passwort sind leer.'));
		}
	}
	public function logout() {
		session_destroy ();
		echo json_encode( array ('status' => 'ok','message' => 'Erfolgreich ausgeloggt!'));
	}
	public function status() {
		if(isset($_SESSION['benutzername'])&&
		isset($_SESSION['email']) && 
		isset($_SESSION['vorname']) &&
		isset($_SESSION['nachname']))
		{						
			echo json_encode( array ('status' => 'ok','message'=>'success','data'=>array(
						'benutzername'=>$_SESSION['benutzername'],
						'email'=>$_SESSION['email'],
						'vorname'=>$_SESSION['vorname'],
						'nachname'=>$_SESSION['nachname']
						)));
		}
		else{
			echo json_encode( array ('status' => 'error','error' => 'session-invalid','message'=>'Session abgelaufen'));
	
		}
	}
	public function __destruct() {
		
	}
}
