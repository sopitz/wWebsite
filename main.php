<?php 
 if(!empty($_GET['logout']))
 {
 session_start();
 session_destroy();
 }

session_start();
 
if(isset($_SESSION['usrname']))
{	
  if(isset($_GET['setloginCookie']) && $_GET['setloginCookie'] == 'yes')
  {
    $_1653 = md5($_SESSION['usrname']);
	setcookie("hzwebsite", "".$_1653."");	
	unset($_1653);
	if(isset($_SESSION['group']) && $_SESSION['group'] == 'admin')
		$redirect = $SERVERPATH ."/?p=login";
	elseif(!empty($_GET['firstLog']))
		$redirect = $SERVERPATH ."/?p=login&firstLog=yes";
	else
		$redirect = $SERVERNAME ."/home";
		
    echo "<script language=\"JavaScript\">location.href=\"".$redirect."\";</script>";
  }
}

unset($LOGIN);
if(isset($_SESSION['usrname']) AND md5($_SESSION['usrname']) == isset($_COOKIE['hzwebsite']))
	$LOGIN = 1;
?>