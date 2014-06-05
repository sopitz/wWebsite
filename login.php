<?php 
require_once('main.php');
require_once('includes/intern.php'); 
require_once('language/content.php');


if(isset($LOGIN) && $PAGE == 'login' && empty($_GET['firstLog'])) {	// logged in succesfully
	$intern = new Intern();
		
	$login = new Login();
	$loginBox = new Box('loginBoxIntern');
	$loginBox->specialfill($intern->toString());
	
}
elseif(isset($LOGIN) && $PAGE == 'login' && !empty($_GET['firstLog'])) { // logged in succesfully AND firstLogin
	$login = new Login();
	$loginBox = new Box('loginBoxIntern');
	$loginBox->specialfill($login->firstLog());
}
elseif(!isset($LOGIN) && $PAGE == 'login') { // not logged in
	$login = new Login();
	$loginBox = new Box('loginBoxIntern');
	$loginBox->specialfill($login->toString());
}

class Login {

	function __construct() {
		
	}	
	
	
	function toString($wrongLog = '') {
		if(isset($LOGIN)) { 	
			
				include 'includes/intern.php';
			
		} 
		else { 
			$html = "";
						
			$html .= "<form action=\"". SERVER ."/?p=login-pruefung\" method=\"post\">";
				$html .= Content::$emailAdress ."<br><input class=\"input_text\" name=\"email\" type=\"text\" style=\"color: #666666;\" /><br><br>";
				$html .= Content::$password ."<br><input class=\"input_text\" name=\"password\" type=\"password\" style=\"color: #666666;\" />";
				$html .= "<br><input class=\"btn\" name=\"Send\" type=\"submit\" value=\"". Content::$loginBtn ."\" />";
			$html .= "</form>";
$html .= "<br><a href=\"". SERVER ."/de/sendNew\">". Content::$forgotPassword ."</a><br>";
			
			if(!empty($wrongLog)) {
				$html .= "<br><br>". Content::$wrongLog;
				
			}
					
		}
		return $html;
	}
	
	
	
	function firstLog() {
		$html = "";
		if(!empty($_GET['firstLog'])) {
				
				$html .= "<div id=\"firstLogEditPW\">";
					$html .= Content::$insertNewPassword;
					$html .= "<form method=\"post\"><br>";
						$html .= Content::$choosePassword ."<input type=\"password\" class=\"form1\" name=\"passwort1\"><br><br>";
						$html .= Content::$repeatPassword ."<input type=\"password\" class=\"form1\" name=\"passwort2\"><br><br>";
						$html .= "<input type=\"hidden\" name=\"edit_pass\" value=\"yes\">";
						$html .= "<input id=\"firstLogEditPWBtn\" type=\"submit\" class=\"btn\" value=\"". Content::$editBtn ."\">";
					$html .= "</form><br>";
				$html .= "</div>";
						  
						  if($_POST['edit_pass'] == 'yes')
						  {
							$passwort1 = $_POST['passwort1'];
							$passwort2 = $_POST['passwort2'];
							
							if($passwort1 == $passwort2 AND $passwort1 != '')
							{
							  $html .= "<script type=\"text/javascript\" src=\"". SERVER ."/js/hideForm.php?hideId=firstLogEditPW\" />";
							
							  $passwort = md5($passwort1);
							  $entry = mysql_query("UPDATE login SET firstLog='', password='". $passwort ."' WHERE userID='". $_SESSION['userID'] ."'");	
							  
							  if($entry == true)
							   {
								$html .= "<b>". Content::$passwordEdited ."</b>";	
								//$html .= "<br><br><a href=\"". SERVER ."\">". Content::$linkToInternArea ."</a>";
																
							   }
							  else
								$html .= Content::$error;
							  
							}
							else
							  $html .= Content::$passwordsDontMatch;
						  }
			}
		return $html;
	}
	
}
if(!isset($LOGIN) OR !empty($_GET['firstLog']) OR $_GET['p'] == 'login')
	echo "<script>$('#navi').animate({left: \"10px\"}, \"slow\");</script>";

  ?>