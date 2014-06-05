<?php
error_reporting(null);


$mail_adrr = md5(strtolower($_POST['email']));
$passwort = md5($_POST["password"]);

if(empty($_POST['email']) OR empty($_POST['password'])) {
	echo "<script language=\"javascript\">location.href=\"". SERVER ."/?wrong_log=yes\";</script>";
	exit;
}
	
$abfrage2 = "SELECT * FROM login WHERE emailMd5 LIKE '". $mail_adrr ."' ORDER BY id ASC LIMIT 1";	
$ergebnis2 = mysql_query($abfrage2);
$row = mysql_fetch_object($ergebnis2);

if($row->password == $passwort AND $row->emailMd5 == $mail_adrr)
    {
	
		$client_erg = mysql_fetch_object(mysql_query("SELECT * FROM login WHERE emailMd5 LIKE '". $mail_adrr ."' ORDER BY id ASC LIMIT 1"));
		
		
		$_SESSION['userID'] = $client_erg->userID;
		$_SESSION['group'] = $client_erg->usergroup;
		$_SESSION['usrname'] = $client_erg->firstname;
		$_SESSION['lastname'] = $client_erg->lastname;
		$_SESSION['password'] = $client_erg->password;
		$_SESSION['mail'] = $client_erg->eMail;
		

		
		$redirect = "index.php?p=login&setloginCookie=yes";
		if(!empty($client_erg->firstLog))
			$redirect .= "&firstLog=yes";
		echo "<script language=\"JavaScript\">location.href=\"". $redirect ."\";</script>";		
    }
else
    {
	echo "<script language=\"javascript\">location.href=\"". SERVER ."/?wrong_log=yes\";</script>";
    }
?>