<?php 
//error_reporting(E_ALL ^ E_NOTICE);
//require_once('includes/config.php');

class Contact {

	private $keys; // uebergabeWerte
	private $presetKeys; //vordefinierteWerte
	private $subKeys;
	private $values; // anzeigeWerte
	private $subValues;
	private $switchType;
	
	private $entries;
	private $required;
	private $names;
	
	/**
	 * @desc  Auswahl von verschiedenen Möglichkeiten:
		 - leerlassen -> Normalfall
		- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"yesNo"  -> radio buttons Yes/No
		- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"yesNo_show"  -> radio buttons Yes/No + Bei Yes wird eine weitere Zeile mit Eingabefeld angezeigt
		- (Stelle des Eintrag in Anzeigewerte beginnend mit 0)=>"text"   -> Textfeld
	*
	*	
	 */
//	function __construct($keys, $values, $switchType = array(), $presetKeys = array(), $subKeys = array(), $subValues = array()) {
	function __construct($keys, $values) {
		
		$this->keys = $keys;
	//	$this->presetKeys = $presetKeys;
	//	$this->subKeys = $subKeys;
		$this->values = $values;
	//	$this->subValues = $subValues;
	//	$this->switchType = $switchType;
		
		$this->prepare_arrays();
	
			
	}
	
	function prepare_arrays() {
		
	/*			
		// copy entries from values
		$entriesTmp = new ArrayObject($values);
		$this->entries = $entriesTmp->getArrayCopy();
		unset($entriesTmp);
		
		// create required and fill it with values from values marked with an *
		$this->required = array();
		foreach($this->values as $key => $value) {
			if(strpos($value, "*") !== false)
				array_push($this->required, $this->keys[$key]);
		}
		// fill presetKeys with empty values when not empty in keys
		foreach($this->keys as $key => $value) {
			if(empty($this->presetKeys[$key]))
				array_push($this->presetKeys, "");
		}
		// fill subValues with empty values where not empty in subValues
		foreach($this->values as $key => $value) {
			if(empty($this->subValues[$key]))
				$this->subValues[$key] =  "";
		}
	*/	// create names from keys as keys and presetKeys as values
		$this->names = array_combine($this->keys, $this->presetKeys);
	}
	
	
	function toString() {
		
		$html = "";
		
		$html .= "<div id='msgSent_ContactForm' style=\"display: none;\"></div>";
		$html .= "<form method=\"post\">";
			$html .= "<table class=\"table_norm\" id=\"table_ContactForm\">";
		
		
				$i = 0;
				$j = 0;
				foreach($this->names as $key => $value)
				{
					switch($this->switchType[$i]) {
						case "text":
							$html .= "<tr>";
								$html .= "<td id=\"".$key."_l\" class=\"left\">";
									$html .= $this->entries[$i];
								$html .= "</td>";
								$html .= "<td id=\"".$key."_r\" class=\"right\">";
									$html .= "<textarea id=\"".$key."_d\" name=\"".$key."\" class=\"_ContactForm\"></textarea>";
								$html .= "</td>";
							$html .= "</tr>";
						break;
						case "yesNo":
							$html .= "<tr>";
								$html .= "<td id=\"".$key."_l\" class=\"left\">";
									$html .= $this->entries[$i];
								$html .= "</td>";
								$html .= "<td id=\"".$key."_r\" class=\"right\">";
									$html .= $yes ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"yes\" class=\"_ContactForm\">";
									$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									$html .= $no ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"no\" class=\"_ContactForm\">";
								$html .= "</td>";
							$html .= "</tr>";
						break;
						case "yesNo_show":
							$html .= "<tr>";
								$html .= "<td id=\"".$key."_l\" class=\"left\">";
									$html .= $this->entries[$i];
								$html .= "</td>";
								$html .= "<td id=\"".$key."_r\" class=\"right\">";
									$html .= $yes ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"yes\" class=\"_ContactForm\" onclick=\"document.getElementById('". $key ."Sub_l').style.visibility = 'visible';document.getElementById('". $key ."Sub_r').style.visibility = 'visible';\">";
									$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									$html .= $no ."<input type=\"radio\" id=\"".$key."_d\" name=\"".$key."\" value=\"no\" class=\"_ContactForm\" onclick=\"document.getElementById('". $key ."Sub_l').style.visibility = 'hidden';document.getElementById('". $key ."Sub_r').style.visibility = 'hidden';\">";
								$html .= "</td>";
							$html .= "</tr>";
							$html .= "<tr>";
								$html .= "<td id=\"".$key."Sub_l\" class=\"hidden\">";
									$html .= $this->entries[$i];
								$html .= "</td>";
								$html .= "<td id=\"".$key."Sub_r\" class=\"hidden\">";
									$html .= "<input id=\"".$key."Sub_d\" type=\"text\" class=\"_ContactForm\" name=\"".$namesSub[$j]."\">";
								$html .= "</td>";
							$html .= "</tr>";
							$j++;
						break;
						default:
							$html .= "<tr>";
								$html .= "<td id=\"".$key."_l\" class=\"left\">";
									$html .= $this->entries[$i];
								$html .= "</td>";
								$html .= "<td id=\"".$key."_r\" class=\"right\">";
									$html .= "<input id=\"".$key."_d\" type=\"text\" class=\"_ContactForm\" name=\"".$key."\">";
								$html .= "</td>";
							$html .= "</tr>";
						break;
					  }
					$i++;
				}
						$html .= "<tr>";
							$html .= "<td colspan=\"2\">";
								$html .= "&nbsp;";
							$html .= "</td>";
						$html .= "</tr>";				
						$html .= "<tr>";
							$html .= "<td colspan=\"2\">";
								$html .= "<div class=\"homepage_ContactForm\" style=\"display: none;\">";
									$html .= "Please do &<b>N</b>%<b>O</b>!<b>T</b>/ fill this line. Thank you!<input type=\"text\" name=\"homepage\" title=\"homepage\">";
								$html .= "</div>";
								$html .= "<input type=\"hidden\" name=\"send\" value=\"yes_send\">";
								$html .= "<br>*". $requiredData ."<br>";
								$html .= "<input type=\"submit\" value=\"". Content::$sendBtn ."\" class=\"_ContactForm\">";
							$html .= "</td>";
						$html .= "</tr>";
			$html .= "</table>";
		$html .= "</form>";
		$html .= "<div style=\"height: 200px;\">". $pastText ."</div>";
		
		return $html;
	}	
/*	
	function updateDb($ordner, $fileLink, $ortNew, $zipNew) { // TODO edit updateDB and send mail via postmark
						$pic = $fileLink;
								
						if(empty($this->ort) && !empty($ortNew)) {
							$ort = format_text($ortNew);
							$zip = $zipNew;
							$queryCat = mysql_query("SELECT * FROM accomodation_locations WHERE name LIKE '". $ortNew ."' ORDER BY id ASC");
							if(mysql_num_rows($queryCat) == 0) 								
								$insertCat = mysql_query("INSERT INTO accomodation_locations (name, zip) VALUES ('". $ort ."', '". $zip ."')");
						}
						else {
							$ort = format_text($this->ort);
							$zip = format_text($this->zip);
						}	
						$title = format_text($this->title);
						$street = format_text($this->street);						
						$url = $this->url;
						$priceFrom = str_replace(",", ".", $this->priceFrom);
						$priceTo = str_replace(",", ".", $this->priceTo);
						$text = format_text($this->text);
						$breakfast = format_text($this->breakfast);
							
						if($this->id != 'new') { // edit
							$edit_entry = mysql_query("UPDATE accomodations SET ort='". $ort ."', zip='". $zip ."', title='". $title ."', text='". $text ."', pic='". $pic ."', street='". $street ."', priceFrom='". $priceFrom ."', url='". $url ."', priceTo='". $priceTo ."', breakfast='". $breakfast ."' WHERE id LIKE '". $this->id ."'");	
							echo "<script language=\"JavaScript\">location.href=\"". Vars::$SERVERPATH ."/?p=login&a=edit_accomodations&aid=". $_GET['aid'] ."\";</script>";
						}
						else {	// new						
							$add_entry = mysql_query("INSERT INTO accomodations (ort, zip, street, title, text, pic, url, priceFrom, priceTo, breakfast, active) VALUES ('". $ort ."', '". $zip ."', '". $street ."', '". $title ."', '". $text ."', '". $pic ."', '". $url ."', '". $priceFrom ."', '". $priceTo ."', '". $breakfast ."', 'yes')");
							echo "<script language=\"JavaScript\">location.href=\"". Vars::$SERVERPATH ."/?p=login&a=edit_accomodations&aid=new\";</script>";
						}
	}
*/	
}

?>