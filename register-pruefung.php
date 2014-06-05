<?php
error_reporting(null);

require_once('language/content.php');

$lastname = strtolower($_POST['lastname']);
$password = $_POST['password'];
$email = strtolower($_POST['email']);

if(empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['lastname'])) {
	echo "<script>location.href=\"". SERVER ."/de/register/empty\";</script>";
	exit;
}
	// id userID lastname password registered
$getAllEntries = "SELECT * FROM registration ORDER BY id ASC";	
$getAllEntriesQuery = mysql_query($getAllEntries);
while($row = mysql_fetch_object($getAllEntriesQuery)) {
	
	$lname = $row->lastname;
	
	if($row->password == $password AND strtolower($lname) == $lastname) {
		if($row->registered == 'yes') { // case: already registered
			echo "<script>location.href=\"". SERVER ."/de/register/alreadyRegistered\";</script>";
			exit;
		}
		$loginQuery = mysql_fetch_object(mysql_query("SELECT * FROM login WHERE userID LIKE '". $row->userID ."' ORDER BY id ASC LIMIT 1"));
			
		if($lname == $loginQuery->lastname) {
										
			$sendPassword = new RegisterP();
			echo $sendPassword->sendNewPassword($row->userID, $email);
					
			echo "<script>location.href=\"". SERVER ."/de/register/yes\";</script>";
			exit;
		}
						
	}
		
}

class RegisterP {
	
	public function __construct() {}
	
	public function sendNewPassword($userID, $email) {
		require_once('encryption/autoload.php');
		$enc = new Autoload();
		
		$html = "";
		$charsPassword = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		$password = substr( str_shuffle( $charsPassword ), 0, 5 );
		$new_passw = md5($password);
		
			
	
		//infomail an user schreiben	////////////////////////////////////////
		$get_user = mysql_fetch_object(mysql_query("SELECT * FROM login WHERE userID LIKE '". $userID ."' ORDER BY id DESC LIMIT 1"));
	
		$data['type_of_email'] = "Neues Passwort";
		$data['sender_email'] = "info@michaela-und-raphael-heiraten.de";
		$data['sender_name'] = "Interner Bereich ". $_SERVER['SERVER_NAME'];
		$data['reply_to'] = "info@michaela-und-raphael-heiraten.de";
		$data['attachments'] = "null";
		$data['recipient_email'] = $email;
		$data['firstname'] = $get_user->firstname;
		$data['surname'] = $get_user->lastname;
		$data['password'] = $password;
		$data['url'] = SERVER;
		//  type_of_email, sender_email, sender_name, reply_to, attachments, recipient_email, firstname, surname, password, url
		require_once('intern/Mailer.php');
	
		$mail = new Mailer();
	
		if($mail->send('/email/newAccountModel.xml', '/email/newAccount.php', $data)) {
			$setRegistered = mysql_query("UPDATE registration SET registered='yes' WHERE userID LIKE '". $userID ."'");
			$upd_login = mysql_query("UPDATE login SET emailMd5='". md5($email) ."', eMail='". $enc->encrypt($email) ."', password='". $new_passw ."', firstLog='". $password ."' WHERE userID LIKE '". $userID ."'");
			$html .= Content::$emailSent; 
		}
		else
			$html .= Content::$error;
	
		return $html;
	}
}
echo "<script>location.href=\"". SERVER ."/de/register/wrongLog\";</script>";
exit;
?>