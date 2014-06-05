<?php
require_once('encryption/autoload.php');
require_once('language/content.php');

$sn = new SendNew();
$snBox = new Box('snBox');
$snBox->specialfill($sn->toString());
$snBox->size(400, 200);

if(!empty($_POST['sendNew']) && $_POST['sendNew'] == 'Neues Passwort zusenden') {
	$snBox->specialfill($sn->sendNewPassword($_POST['m']));
}


class SendNew {
	
	public function __construct() {
		
	}
	
	public function toString() {
		$html = "";
		$html .= "<div id=\"reset_pw\">";
		$html .= "<form method=\"post\">";
		$html .= Content::$pleaseInsertEmail ."<br>";
		$html .= "<input type=\"text\" name=\"m\" />";
		$html .= "<input type=\"submit\" name=\"sendNew\" value=\"". Content::$sendNewPwBtn ."\" />";
		$html .= "</form>";
		$html .= "</div>";
		
		return $html;
	}
	
	public function sendNewPassword($email) {
		$html = "";
		$charsPassword = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?";
		$password = substr( str_shuffle( $charsPassword ), 0, 8 );
		$new_passw = md5($password);
	
		//infomail an user schreiben	////////////////////////////////////////
		$get_user = mysql_fetch_object(mysql_query("SELECT * FROM login WHERE emailMd5 LIKE '". md5($email) ."' ORDER BY id DESC LIMIT 1"));
	
		$data['type_of_email'] = "Neues Passwort";
		$data['sender_email'] = "info@michaela-und-raphael-heiraten.de";
		$data['sender_name'] = "Interner Bereich ". $_SERVER['SERVER_NAME'];
		$data['reply_to'] = "info@michaela-und-raphael-heiraten.de";
		$data['attachments'] = "null";
		$enc = new Autoload();
		$data['recipient_email'] = $enc->decrypt($get_user->eMail);
		$data['firstname'] = $get_user->firstname;
		$data['surname'] = $get_user->lastname;
		$data['password'] = $password;
		$data['url'] = SERVER;
		//  type_of_email, sender_email, sender_name, reply_to, attachments, recipient_email, firstname, surname, password, url
		require_once('intern/Mailer.php');
	
		$mail = new Mailer();
	
		if($mail->send('/email/newAccountModel.xml', '/email/sendPassword.php', $data)) {
			$upd_login = mysql_query("UPDATE login SET password='". $new_passw ."', firstLog='". $password ."' WHERE emailMd5 LIKE '". md5($email) ."'");
			$html .= Content::$passwordSent;
		}
		else
			$html .= Content::$error;
			
		return $html;
	}
}
?>