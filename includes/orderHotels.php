<?php 
//require_once('./index.php');
require_once('config.php');
require_once('language/content.php');


class OrderHotels {

	private $get_entries;
	private $get_entriesString;
	private $html;

	function __construct($target = 'hotels.php', $formId = 'sortForm', $switch = '', $categoryDB = 'accomodation_locations', $entryDB = 'accomodations') {

		$this->html = "";
		$this->html .= "<form method=\"post\" action=\"". $target ."\" id=\"". $formId ."\">";
			$this->html .= Content::$ort .": <select name=\"ort\">";
				$this->html .= "<option value=\"". PRESETORT ."\""; if(empty($_POST['ort']) OR $_POST['ort'] == PRESETORT) $this->html .= " selected=\"selected\""; $this->html .= ">";
				$this->html .= formatUmlautsEback(PRESETORT);
				$this->html .= "</option>";
				
				$getCats = mysql_query("SELECT * FROM ". $categoryDB ." ORDER BY name ASC");
				while($ort = mysql_fetch_object($getCats)) {
					$this->html .= "<option value=\"". $ort->name ."\""; if((!empty($_POST['ort']) AND $_POST['ort'] == $ort->name) OR (empty($_POST['ort']) AND $ort->name == PRESETCAT)) $this->html .= " selected=\"selected\""; $this->html .= ">";
					$this->html .= formatUmlautsEback($ort->name);
					$this->html .= "</option>";
				}
			$this->html .= "</select>";
			$this->html .= "<br>";
		//	$this->html .= Content::$priceRange .": ". Content::$priceFrom ." <input class=\"priceRange\" maxlength=\"4\" id=\"minPrice\" size=\"3\" type=\"text\" name=\"minPrice\""; if(!empty($_POST['minPrice'])) $this->html .= " value=\"". $_POST['minPrice'] ."\""; $this->html .= "> &euro; ";
		//	$this->html .= Content::$priceTo ." <input class=\"priceRange\" id=\"maxPrice\" maxlength=\"5\" size=\"3\" type=\"text\" name=\"maxPrice\""; if(!empty($_POST['maxPrice'])) $this->html .= " value=\"". $_POST['maxPrice'] ."\""; $this->html .= "> &euro; ";
			//$this->html .= "<div id=\"alertDiff\" style=\"color: red;\"></div>";
			$this->html .= "<div id=\"alertSearch\" style=\"display: none;color: red;\"></div>";
			//		$this->html .= "<div id=\"sort\""; if(!empty($_POST['minPrice']) OR !empty($_POST['maxPrice'])) $this->html .= " style=\"display: none;\""; $this->html .= ">";
			$this->html .= Content::$orderMaxByPrice;
			$this->html .= " <select name=\"orderByPriceTo\">";
			$this->html .= "<option value=\"\""; if(empty($_POST['orderByPriceTo'])) $this->html .= " selected=\"selected\""; $this->html .= "></option>";
			$this->html .= "<option value=\"asc\""; if(!empty($_POST['orderByPriceTo']) AND $_POST['orderByPriceTo'] == 'asc') $this->html .= " selected=\"selected\""; $this->html .= ">aufsteigend</option>";
			$this->html .= "<option value=\"desc\""; if(!empty($_POST['orderByPriceTo']) AND $_POST['orderByPriceTo'] == 'desc') $this->html .= " selected=\"selected\""; $this->html .= ">absteigend</option>";
			$this->html .= "</select>";
			$this->html .= "</div>";
					$this->html .= "<input type=\"hidden\" name=\"newOrder\" value=\"yes\" />";
			$this->html .= "<input id=\"submitSearch\" type=\"submit\" value=\"". Content::$sendBtn ."\" />";
			//$this->html .= "<input id=\"submitSearch2\" type=\"submit\" value=\"absenden\" style=\"display: none;\" />";
				
		$this->html .= "</form>";




		if((!empty($_POST['newOrder']) AND $_POST['newOrder'] == 'yes') OR empty($_POST['newOrder'])) {
			if(!empty($_POST['start']))
				$start = $_POST['start'];
			else
				$start = 0;
			if(!empty($_POST['end']))
				$end = $_POST['end'];
			else
				$end = 35;

			$this->get_entries = "SELECT * FROM ". $entryDB ." WHERE title IS NOT NULL";
			// active
			if(!empty($_POST['active']) AND $_POST['active'] != 'false')					// active != false
				$this->get_entries .= " AND active LIKE 'yes'";
			elseif($switch == 'myGifts')
			$this->get_entries .= " AND active LIKE '". $_SESSION['userID'] ."'";
			else 											// active == yes
				$this->get_entries .= "";
			// ort
			if($switch != 'myGifts') {
				if(!empty($_POST['ort']) AND $_POST['ort'] != PRESETORT) 						// !empty(ort)
					$this->get_entries .= " AND `ort` LIKE '". $_POST['ort'] ."'";
				else											// empty(ort) --> display all entries
					$this->get_entries .= "";
			}
			else
				$this->get_entries .= "";
			
			// price range
			if(!empty($_POST['minPrice']) OR !empty($_POST['maxPrice']))	{					// !empty(minPrice)
				if(!empty($_POST['minPrice']))
					$minPrice = $_POST['minPrice'];
				else
					$minPrice = '0';
				if(!empty($_POST['maxPrice']))
					$maxPrice = $_POST['maxPrice'];
				else
					$maxPrice = '10000';
				//$this->get_entries .= " AND price BETWEEN ". str_replace(",", ".", $minPrice) ." AND ". str_replace(",", ".", $maxPrice) ."";
				$this->get_entries .= " AND priceFrom >= ". $_POST['minPrice'] ." AND  priceTo <= ". $_POST['maxPrice'] ."";
			}
			else											// empty(minPrice)
				$this->get_entries .= "";
			// 	ORDER priceTo
		/*	if(!empty($_POST['minPrice']))					// !empty(minPrice)
				$this->get_entries .= " ORDER BY priceFrom ASC"; // ASC
			if(!empty($_POST['maxPrice']))					// !empty(minPrice)
				$this->get_entries .= " ORDER BY priceTo ASC"; // ASC
		*/	if(!empty($_POST['orderByPriceTo']))					// ORDER BY priceTO
				$this->get_entries .= " ORDER BY priceTo ". strtoupper($_POST['orderByPriceTo']) .""; // DESC OR ASC
			else																	// ORDER BY id
				$this->get_entries .= " ORDER BY ort DESC"; // DESC --> standard
			$this->get_entriesString = $this->get_entries;
			$this->get_entries = mysql_query($this->get_entries);
		//	if(mysql_num_rows($this->get_entries) < 1)
		//		$this->html .= "<span style=\"color: red;\">". Content::$noQuery ."</span>";
		}
	}

	function toString() {
		return $this->html;
	}

	function get_entries() {

		return $this->get_entries;
	}
	
	function get_entriesString() {
		return $this->get_entriesString;
	}
	
	function count() {
		return mysql_num_rows($this->get_entries);
	}
	
	function foundEntries() {
		if($this->count() == 0)
			return "";
		elseif($this->count() == 1)
			return $this->count() ." ". Content::$foundEntry;
		else
			return $this->count() ." ". Content::$foundEntries;
	}
}
?>
