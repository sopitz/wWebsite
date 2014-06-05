<?php
// Pflichtangaben mit * am Ende kennzeichnen (Bsp: "Vorname*")
$anzeigeWerte = array(
	"Anrede*",
	"Ihr Vorname",
	"Ihr Nachname*",
	"Ihre Telefonnummer",
	"Ihre E-Mail-Adresse*",
	"Wann Sie uns buchen möchten",
	"Wo wir auftreten sollen",
	"Was Sie uns sonst noch mitteilen möchten*"
);	
$anzeigeWerteSub = array(
	
);

/* Auswahl von verschiedenen Möglichkeiten:
	- leerlassen -> Normalfall
	- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"yesNo"  -> radio buttons Yes/No
	- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"yesNo_show"  -> radio buttons Yes/No + Bei Yes wird eine weitere Zeile mit Eingabefeld angezeigt
	- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"text"   -> Textfeld
*/
$anzeigeSub = array(
	7=>"text"
);

// keinen Wert mit dem Namen: homepage !!!!!
$uebergabeWerte = array(		
	"anrede",
	"vorname",
	"nachname",
	"telefon",
	"email",
	"wann",
	"wo",
	"was"
);	
$uebergabeWerteSub = array(
	
);
// für uebergabeWerte vordefiniert
$vordefinierteWerte = array(

);	

$requiredData = "Pflichtfelder";
$preText = "Senden Sie uns über dieses Formular eine Buchungsanfrage.";
$pastText = "";
$admin_mail = $ADMIN_MAIL;
$from = "Buchung";
$eMailBetreff = "Neue Buchungsanfrage";
$mailText = "Folgende Buchungs-Anfrage wurde gerade über das Anfrageformular gesendet:";
$gesendetNachricht = "Vielen Dank für Ihre Anfrage.";
$cGreen = "green";
$cRed = "grey";
$yes = "ja";
$no = "nein";
$sendBtn = "senden";

/////////////// END OF EDIT /////////////////////////////////////////////////////////////////

////// creating arrays

// copy entries from anzeigeWerte
$entriesTmp = new ArrayObject($anzeigeWerte);
$entries = $entriesTmp->getArrayCopy();
unset($entriesTmp);

// create required and fill it with values from anzeigeWerte marked with an *
$required = array();
foreach($anzeigeWerte as $key => $value) {
	if(strpos($value, "*") !== false)
		array_push($required, $uebergabeWerte[$key]);
}
// fill vordefinierteWerte with empty values when not empty in vordefinierteWerte 
foreach($uebergabeWerte as $key => $value) {
	if(empty($vordefinierteWerte[$key]))
		array_push($vordefinierteWerte, "");
}
// fill anzeigeWerteSub with empty values where not empty in anzeigeWerteSub 
foreach($anzeigeWerte as $key => $value) {
	if(empty($anzeigeWerteSub[$key]))
		$anzeigeWerteSub[$key] =  "";
}
// create names from ubergabeWerte as keys and vordefinierteWerte as values
$names = array_combine($uebergabeWerte, $vordefinierteWerte);
// create namesSub from uebergabeWerteSub as keys and anzeigeWerteSub as values
//$namesSub = array_combine($uebergabeWerteSub, $anzeigeWerteSub);
/*
		// show arrays
echo "<div style=\"border: 2px dashed #000;\">entires:";
	print_r($entries);
	echo "<br><br>names:";
	print_r($names);
	echo "<br><br>required:";
	print_r($required);
	echo "<br><br>anzeigeWerteSub:";
	print_r($anzeigeWerteSub);
echo "</div>";
*/


echo "<div id='msgSent_ContactForm' style=\"display: none;\"></div>";
echo "<div style=\"height: 200px;display: none;\">". $preText ."</div>";
echo "<form method=\"post\">";
	echo "<table class=\"table_norm\" id=\"table_ContactForm\">";


		$i = 0;
		$j = 0;
		foreach($names as $key => $value)
		{
			switch($anzeigeSub[$i]) {
			/*	case "":
					echo "<tr>";
						echo "<td colspan=\"2\">";
							echo $entries[$i];
						echo "</td>";
					echo "</tr>";
				break;
			*/	case "text":
					echo "<tr>";
						echo "<td id=\"".$key."_l\" class=\"left\">";
							echo $entries[$i];
						echo "</td>";
						echo "<td id=\"".$key."_r\" class=\"right\">";
							echo "<textarea id=\"".$key."_d\" name=\"".$key."\" class=\"_ContactForm\"></textarea>";
						echo "</td>";
					echo "</tr>";
				break;
				case "yesNo":
					echo "<tr>";
						echo "<td id=\"".$key."_l\" class=\"left\">";
							echo $entries[$i];
						echo "</td>";
						echo "<td id=\"".$key."_r\" class=\"right\">";
							echo $yes ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"yes\" class=\"_ContactForm\">";
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							echo $no ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"no\" class=\"_ContactForm\">";
						echo "</td>";
					echo "</tr>";
				break;
				case "yesNo_show":
					echo "<tr>";
						echo "<td id=\"".$key."_l\" class=\"left\">";
							echo $entries[$i];
						echo "</td>";
						echo "<td id=\"".$key."_r\" class=\"right\">";
							echo $yes ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"yes\" class=\"_ContactForm\" onclick=\"document.getElementById('". $key ."Sub_l').style.visibility = 'visible';document.getElementById('". $key ."Sub_r').style.visibility = 'visible';\">";
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							echo $no ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"no\" class=\"_ContactForm\" onclick=\"document.getElementById('". $key ."Sub_l').style.visibility = 'hidden';document.getElementById('". $key ."Sub_r').style.visibility = 'hidden';\">";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td id=\"".$key."Sub_l\" class=\"hidden\">";
							echo $entries[$i];
						echo "</td>";
						echo "<td id=\"".$key."Sub_r\" class=\"hidden\">";
							echo "<input id=\"".$key."Sub_d\" type=\"text\" class=\"_ContactForm\" name=\"".$namesSub[$j]."\">";
						echo "</td>";
					echo "</tr>";
					$j++;
				break;
				default:
					echo "<tr>";
						echo "<td id=\"".$key."_l\" class=\"left\">";
							echo $entries[$i];
						echo "</td>";
						echo "<td id=\"".$key."_r\" class=\"right\">";
							echo "<input id=\"".$key."_d\" type=\"text\" class=\"_ContactForm\" name=\"".$key."\">";
						echo "</td>";
					echo "</tr>";
				break;
			  }
			$i++;
		}
				echo "<tr>";
					echo "<td colspan=\"2\">";
						echo "&nbsp;";
					echo "</td>";
				echo "</tr>";				
				echo "<tr>";
					echo "<td colspan=\"2\">";
						echo "<div class=\"homepage_ContactForm\" style=\"display: none;\">";
							echo "Please do &<b>N</b>%<b>O</b>!<b>T</b>/ fill this line. Thank you!<input type=\"text\" name=\"homepage\" title=\"homepage\">";
						echo "</div>";
						echo "<input type=\"hidden\" name=\"send\" value=\"yes_send\">";
						echo "<br>*". $requiredData ."<br>";
						echo "<input type=\"submit\" value=\"". $sendBtn ."\" class=\"_ContactForm\">";
					echo "</td>";
				echo "</tr>";
	echo "</table>";
echo "</form>";
echo "<div style=\"height: 200px;\">". $pastText ."</div>";

if($_POST['send'] == 'yes_send' AND empty($_POST['homepage']))
	{	
			$namesTemp = new ArrayObject($names);
			$entriesEND = $namesTemp->getArrayCopy();
			unset($namesTemp);
			
				$oneIsEmpty = 0;
				foreach ($names as $key => $entry) {
					if(empty($_POST[$key]) && in_array($key, $required))
						 {
						  echo "<script language=\"JavaScript\">document.getElementById('".$key."_l').style.backgroundColor = '". $cRed ."';document.getElementById('".$key."_r').style.backgroundColor = '". $cRed ."';</script>";
						  $oneIsEmpty = "1";
						 }
						else
						 {
						  $entriesEND[$key] = $_POST[$key];
						 }
				}
	/*			foreach($namesSub as $key => $value) {
					array_push($names, $key);
				}
				foreach($namesSub as $key => $value) {
					array_push($entriesEND, $value);
				}
	*/			
			if($oneIsEmpty != '1')
			{
				
				 
					$info = "INSERT INTO contact (";					
						$info .= "date";
						foreach($names as $key => $value) {
							$info .= ",". $key;
						}				
					$info .= ") VALUES
						(
						NOW('')";															
						
						foreach($names as $key => $val) {
							if(!empty($val))
								$info .= ", ". $names[$key];
							else
								$info .= ", '". $entriesEND[$key] ."'";
						}																				
					$info .= ")";
					
					$info_eintragen = mysql_query($info);
					
					//infomail an admin schreiben	////////////////////////////////////////
					
						$empf = $admin_mail;

												
								$betreff = $eMailBetreff;
							
							$header  = 'MIME-Version: 1.0' . "\r\n";
							$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

						//	$header .= 'To: '. $empf .'' . "\r\n";
							$header .= 'From: '. $from .' <'. $from .'@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
							
							$nachricht .= "
										<html>
											<head>
												<title>". $betreff ."</title>
												<style type='text/css'>
													body {
														background-color: #ccc;
														color: #80ad2b;
														font-family: Calibri, Arial, sans-serif;
														font-size: 12pt;
													}
													
													div {
														float: left;
														padding-left: 10px;
													}
													
													div#left {
														clear: left;
														border-right: 1px dashed #80ad2b;
														width: 200px;
													}
												</style>
											</head>
											<body>";
								$nachricht .= "<div>". $mailText ."</div>";
								$j = 0;
								foreach($names as $key => $val) {
									if(!empty($val))
										$nachricht .= "
												<div id='left'>
													". $entries[$j] .":
												</div>
												<div>
													". $names[$key] ."
												</div>";
									else
										$nachricht .= "
												<div id='left'>
													". $entries[$j] .":
												</div>
												<div>
													". $entriesEND[$key] ."
												</div>";
									$j++;
								}	
								$nachricht .="</body>
										</html>";
							
							mail($empf, $betreff, $nachricht, $header);
					
					echo "<script language=\"JavaScript\">document.getElementById('msgSent_ContactForm').innerHTML = '". $gesendetNachricht ."';document.getElementById('msgSent_ContactForm').style.display = 'block';</script>";
			}
			else
			{
				  foreach ($names as $key => $entry) {
					echo "<script language=\"JavaScript\">document.getElementById('".$key."_d').value = '".$entriesEND[$key]."';</script>";
				  }
			}
	}
	elseif(!empty($_POST['homepage']))
		echo "<script language=\"JavaScript\">document.getElementById('msgSent_ContactForm').innerHTML = 'You are a bot.';document.getElementById('msgSent_ContactForm').style.backgroundColor = '". $cRed ."';</script>";

?>