<?php
class registerController implements IController {
	
	
	public function __construct(){}
	
	public function index(){
		$this->create();
	}
	
	public function create(){
		$this->register();			
	}
	public function register($params){
	//check all  values
	if(isset($params['email']) && isset($params['passwort']) && isset($params['benutzername']) && isset($params['vorname']) && isset($params['nachname']) && isset($params['passwort2']) ){
		$fehler = false;
		$responses=array();
		$email = $params ['email'];
		$passwort = $params ['passwort'];
		$passwort2 = $params ['passwort2'];
		$benutzername=$params['benutzername'];
		$vorname=$params['vorname'];
		$nachname=$params['nachname'];
		
		if(!ctype_alnum ($benutzername)||strlen($benutzername)!=6){
			$fehler=true;
			$responses[]=array('field'=>'benutzername','status' => 'error','message'=>'Benutzername muss aus 6 alphanumerischen Zeichen bestehen.');
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$fehler=true;
			$responses[]=array('field'=>'email','status' => 'error','message'=>'E-Mail Adresse ungültig.');
		}
		if(!ctype_alnum ($vorname)){
			$fehler=true;
			$responses[]=array('field'=>'vorname','status' => 'error','message'=>'Vorname muss alphanumerisch sein.');
		}
		if(!ctype_alnum ($nachname)){
			$fehler=true;
			$responses[]=array('field'=>'nachname','status' => 'error','message'=>'Nachname muss alphanumerisch sein.');
		}
		
		if(1!=preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/",$passwort)){
			$fehler=true;
			$responses[]=array('field'=>'passwort','status' => 'error','message'=>'Passwort: mind. 8 Zeichen, Zahlen, Buchstaben (gross/klein) und Sonderzeichen');
		}
		if($passwort!=$passwort2){
			$fehler=true;
			$responses[]=array('field'=>'passwort2','status' => 'error','message'=>'Passwörter müssen übereinstimmen.');
		
		
		}
		
		
		if(!$fehler){
			$db = new DB();
			if ($db) {
				//Abfragen ob benutzer bereits registriert ist
				$stmt = $db->prepare("SELECT email,benutzername FROM BENUTZER WHERE email=:email OR benutzername=:benutzername");
    			$stmt->bindValue(":email", $email, SQLITE3_TEXT);
   				$stmt->bindValue(":benutzername",$benutzername, SQLITE3_TEXT);
   				$results=0;
   				if ($res=$stmt->execute()) {
          			while($data = $res->fetchArray())
    				{
    					$results++;
    				}
          		}
				$stmt->close();
				if($results>0){
					echo json_encode(array ('status' => 'error','error'=>'already-registered','message'=>'Benutzername oder E-Mail schon registriert!'));
				}
				else{
					//neuen User anlegen
					$stmt = $db->prepare("INSERT INTO BENUTZER(benutzername,vorname,nachname,passwort,email) VALUES (:benutzername,:vorname,:nachname,:passwort,:email);");
					$stmt->bindValue(":benutzername",$benutzername, SQLITE3_TEXT);
					$stmt->bindValue(":vorname", $vorname, SQLITE3_TEXT);
					$stmt->bindValue(":nachname", $nachname, SQLITE3_TEXT);
					$stmt->bindValue(":passwort", sha1($passwort), SQLITE3_TEXT);
					$stmt->bindValue(":email",$email, SQLITE3_TEXT);
					$stmt->execute();
				
						$_SESSION['email'] = $email;
						$_SESSION['benutzername']=$benutzername;
						$_SESSION['vorname']=$vorname;
						$_SESSION['nachname']=$nachname;
					echo json_encode( array ('status' => 'ok','message'=>'success','data'=>array(
						'benutzername'=>$_SESSION['benutzername'],
						'email'=>$_SESSION['email'],
						'vorname'=>$_SESSION['vorname'],
						'nachname'=>$_SESSION['nachname'])));
				}
			}
			else{
				echo json_encode(array ('status' => 'error','error'=>'database-error','message'=>'Database Error!'));
				
			}   
			$stmt->close();
			$db->close();
		}
		else
		{
			echo json_encode(array ('status' => 'error','error'=>'detailed-register-error','message'=>'Fehler','data'=>array('errors'=>$responses)));
		}
	}
	else{
		echo json_encode( array ('status' => 'error','error' => 'required-fields-missing','message'=>'Alle felder müssen ausgefüllt sein!')); 
	}
		
	}
	
	
	
	

	
	public function __destruct(){
	}
}