<?php 
//require_once('./index.php');
require_once('config.php');
require_once('language/content.php');


class Order {

	private $get_entries;
	private $html;

	function __construct($target = 'home.php', $formId = 'sortForm', $switch = '') {


		$this->html .= "<form method=\"post\" action=\"". $target ."\" id=\"". $formId ."\">";
			$this->html .= Content::$hideNotActive ." <input type=\"checkbox\" name=\"active\" value=\"no\""; if(!empty($_POST['active']) AND $_POST['active'] != 'yes') $this->html .= " checked "; $this->html .= "/>";
			$this->html .= "<br>";
			$this->html .= Content::$category .": <select name=\"cat\">";
				$getCats = mysql_query("SELECT * FROM categories ORDER BY name ASC");
				while($cat = mysql_fetch_object($getCats)) {
					$this->html .= "<option value=\"". $cat->name ."\""; if((!empty($_POST['cat']) AND $_POST['cat'] == $cat->name) OR (empty($_POST['cat']) AND $cat->name == PRESETCAT)) $this->html .= " selected=\"selected\""; $this->html .= ">";
					$this->html .= formatUmlautsEback($cat->name);
					$this->html .= "</option>";
				}
			$this->html .= "</select>";
			$this->html .= "<br>";
			$this->html .= Content::$priceRange .": ". Content::$priceFrom ." <input class=\"priceRange\" maxlength=\"4\" id=\"minPrice\" size=\"3\" type=\"text\" name=\"minPrice\""; if(!empty($_POST['minPrice'])) $this->html .= " value=\"". $_POST['minPrice'] ."\""; $this->html .= "> &euro; ";
			$this->html .= Content::$priceTo ." <input class=\"priceRange\" id=\"maxPrice\" maxlength=\"5\" size=\"3\" type=\"text\" name=\"maxPrice\""; if(!empty($_POST['maxPrice'])) $this->html .= " value=\"". $_POST['maxPrice'] ."\""; $this->html .= "> &euro; ";
			//$this->html .= "<div id=\"alertDiff\" style=\"color: red;\"></div>";
			$this->html .= "<div id=\"alertSearch\" style=\"display: none;color: red;\"></div>";
			/*		$this->html .= "<div id=\"sort\""; if(!empty($_POST['minPrice']) OR !empty($_POST['maxPrice'])) $this->html .= " style=\"display: none;\""; $this->html .= ">";
			 $this->html .= "Sortierung: ";
			$this->html .= "Nach Preis <input type=\"radio\" name=\"order\" value=\"price\""; if(!empty($_POST['order']) AND $_POST['order'] == 'price') $this->html .= " checked "; $this->html .= "/>";
			$this->html .= "Nach Datum <input type=\"radio\" name=\"order\" width=\"4px\" value=\"id\""; if(empty($_POST['order']) OR $_POST['order'] == 'id') $this->html .= " checked "; $this->html .= "/>";
			$this->html .= "<select name=\"order2\">";
			$this->html .= "<option value=\"asc\""; if(!empty($_POST['order2']) AND $_POST['order2'] == 'asc') $this->html .= " selected=\"selected\""; $this->html .= ">aufsteigend</option>";
			$this->html .= "<option value=\"desc\""; if(empty($_POST['order2']) OR $_POST['order2'] == 'desc') $this->html .= " selected=\"selected\""; $this->html .= ">absteigend</option>";
			$this->html .= "</select>";
			$this->html .= "</div>";
			*/		$this->html .= "<input type=\"hidden\" name=\"newOrder\" value=\"yes\" />";
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

			$this->get_entries = "SELECT * FROM hochzeitstisch WHERE active IS NOT NULL";
			// active
			if(!empty($_POST['active']) AND $_POST['active'] != 'false')					// active != false
				$this->get_entries .= " AND active LIKE 'yes'";
			elseif($switch == 'myGifts')
			$this->get_entries .= " AND active LIKE '". $_SESSION['userID'] ."'";
			else 											// active == yes
				$this->get_entries .= "";
			// cat
			if($switch != 'myGifts') {
				if(!empty($_POST['cat'])) 						// !empty(cat)
					$this->get_entries .= " AND cat LIKE '". formatUmlauts($_POST['cat']) ."'";
				else											// empty(cat)
					$this->get_entries .= " AND cat LIKE '". PRESETCAT ."'";
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
				$this->get_entries .= " AND price BETWEEN ". str_replace(",", ".", $minPrice) ." AND ". str_replace(",", ".", $maxPrice) ."";
				//$this->get_entries .= " AND price >= ". $_POST['minPrice'] ." AND  price <= ". $_POST['maxPrice'] ."";
			}
			else											// empty(minPrice)
				$this->get_entries .= "";
			// 	ORDER price OR id
			if(!empty($_POST['minPrice']) OR !empty($_POST['maxPrice']))					// !empty(minPrice)
				$this->get_entries .= " ORDER BY price ASC"; // ASC
			elseif(!empty($_POST['order']) AND $_POST['order'] == 'price' AND !empty($_POST['order2']))					// ORDER BY price
			$this->get_entries .= " ORDER BY price ". strtoupper($_POST['order2']) .""; // DESC OR ASC
			elseif(!empty($_POST['order']) AND $_POST['order'] == 'id' AND !empty($_POST['order2']))			// ORDER BY id
			$this->get_entries .= " ORDER BY id ". strtoupper($_POST['order2']) .""; // DESC OR ASC
			else																	// ORDER BY id
				$this->get_entries .= " ORDER BY id DESC LIMIT ". $start .", ". $end .""; // DESC --> standard
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
