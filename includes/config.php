<?php

// config
if(!empty($_POST['lang'])) {
	switch($_POST['lang']) {
		case "en": $LANG = 'en';
		case "de": $LANG = 'de';
		default: $LANG = 'de';	
	}
}
else
	$LANG = 'de';
	
$SERVERPATH = "http://". $_SERVER['SERVER_NAME'] ."/hzWebsite";
define("SERVER", $SERVERPATH);
$SERVERNAME = $SERVERPATH ."/". $LANG;
$PATH = 'c:\xampp\htdocs\hzWebsite';
$presetCat = "Wohnzimmer";
$presetOrt = "Alle";

// database
$dbHost = "127.1.0.0";
$dbUser = "root";
$dbPassword = "";
$dbName = "hzWebsite";


/////////////////////////////////////////////////////////////////////////////////

define("PRESETCAT", format_text($presetCat));
define("PRESETORT", format_text($presetOrt));
define('ROOT_DIR', $PATH);
//$USERID = $_SESSION['userID'];
include ROOT_DIR .'/574877485746748/a.php';

if(isset($_GET['p']))
	$PAGE = $_GET['p'];
if(empty($PAGE))
	$PAGE = 'home';




function format_text($text) {
	$umlaute = Array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/");
    $replace = Array("&ae","&oe","&ue","&Ae","&Oe","&Ue","&sz");
	$text = preg_replace($umlaute,$replace,$text);
	$text = nl2br(stripslashes($text));
	$text = str_replace('  ', ' &nbsp;', $text);
	$text = str_replace('->', '&rarr;', $text);
	$text = str_replace('<-', '&larr;', $text);
	$text = str_replace('<big>', '<font style="font-size: 14px;font-weight: bold;">', $text);
	$text = str_replace('</big>', '</font>', $text);
	return $text;
}


function formatUmlauts($text) {
	$umlaute = Array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/");
    $replace = Array("&auml;","&ouml;","&uuml;","&Auml;","&Ouml;","&Uuml;","&szlig;");
	$text = preg_replace($umlaute,$replace,$text);
	return $text;
}
function formatUmlautsBack($text) {
    $umlaute = Array("&auml;","&ouml;","&uuml;","&Auml;","&Ouml;","&Uuml;","&szlig;");
	$replace = Array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/");
	$text = preg_replace($umlaute,$replace,$text);
	return $text;
}

function formatUmlautsE($text) {
    $umlaute = Array("&auml;","&ouml;","&uuml;","&Auml;","&Ouml;","&Uuml;","&szlig;");
	$replace = Array("/&ae/","/&oe/","/&ue/","/&Ae/","/&Oe/","/&Ue/","/&sz/");
	$text = preg_replace($umlaute,$replace,$text);
	return $text;
}
function formatUmlautsEback($text) {
	$umlaute = Array("/&ae/","/&oe/","/&ue/","/&Ae/","/&Oe/","/&Ue/","/&sz/");
    $replace = Array("&auml;","&ouml;","&uuml;","&Auml;","&Ouml;","&Uuml;","&szlig;");
	$text = preg_replace($umlaute,$replace,$text);
	return $text;
}

?>