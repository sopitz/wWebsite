<?php
error_reporting(null);

require_once('encryption/autoload.php');
require_once('language/content.php');

$getRegister = $_GET['register'];


$register = new Register();
$registerBox = new Box('registerBox');
if(!empty($getRegister)) // message
	$registerBox->specialfill($register->message($getRegister));
else
	$registerBox->specialfill($register->toString());
$registerBox->size(500, 500);


class Register {
	
	public function __construct() {
		
	}
	
	public function toString() {
		$html = "";
		$html .= "<div id=\"registration\">";
			$html .= "". Content::$welcomeRegister;
			$html .= "<br><br>";
			$html .= "<form action=\"". SERVER ."/de/register-pruefung\" method=\"post\">";
				$html .= Content::$yourLastname ."<br><input class=\"input_text\" name=\"lastname\" type=\"text\" style=\"color: #666666;\" /><br><br>";
				$html .= Content::$passwordFromInvite ."<br><input class=\"input_text\" name=\"password\" type=\"text\" style=\"color: #666666;\" />";
				$html .= "<br>". Content::$yourEmail ."<br><input class=\"input_text\" name=\"email\" type=\"text\" style=\"color: #666666;\" /><br><br>";
				$html .= "<br><input class=\"btn\" name=\"Send\" type=\"submit\" value=\"". Content::$linkToRegister ."\" />";
			$html .= "</form>";
		$html .= "</div>";
		
		return $html;		
	}
	
	public function message($msg) {
		
		switch($msg) {
			case "yes": $html = Content::$succesfulRegistration ."<br><br>". Content::$emailSent; break;
			case "empty": $html = Content::$emptyField; break;
			case "alreadyRegistered": $html = Content::$alreadyRegistered; break;
			case "wrongLog": $html = Content::$wrongReg;  break;
			default: $html = Content::$error;  break;
		}
		return $html;
	}
}
?>
<script>$('#navi').animate({left: "10px"}, "slow");</script>