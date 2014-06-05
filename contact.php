<?php

require_once('language/content.php');
require_once('box.php');
require_once('login.php');
require_once('includes/loading.php');
require_once('contact_form/class.contact.php');
//echo "<link rel=\"stylesheet\" href=\"css/style.php\" media=\"screen\" type=\"text/css\">";

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

//	$contact = new Contact($uebergabeWerte, $anzeigeWerte, $anzeigeSub);
	$contact = new Contact($uebergabeWerte, $anzeigeWerte);
	$contactBox = new Box('contactBox');
	$contactBox->specialfill($contact->toString());
	$contactBox->size('550','550'); 

?>
<script>
	$('#navi').animate({left: "10px"}, "slow");
</script>