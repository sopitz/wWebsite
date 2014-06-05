<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once('main.php');
require_once('includes/config.php');
require_once('Method.php');
require_once('language/content.php');

class Accomodation {

	private $id;
	private $title;
	private $ort;
	private $zip;
	private $street;
	private $text;
	private $pic;
	private $url;
	private $priceFrom;
	private $priceTo;
	private $breakfast;
	private $active;
	
	
	
	
	function __construct($id) {
		
		
		$getDet = mysql_fetch_object(mysql_query("SELECT * FROM accomodations WHERE id LIKE '". $id ."' ORDER BY id DESC LIMIT 1"));
		
		if(!empty($getDet)) {
			$this->id = $id;
			$this->title = $getDet->title;
			$this->ort = $getDet->ort;
			$this->zip = $getDet->zip;
			$this->street = $getDet->street;
			$this->text = $getDet->text;
			$this->pic = $getDet->pic;
			$this->url = $getDet->url;
			if(substr($getDet->priceFrom, -2, 2) == '00')
				$priceFromCut = substr($getDet->priceFrom, 0, -3);
			else
				$priceFromCut = $getDet->priceFrom;
			$this->priceFrom = $priceFromCut;
			
			if(substr($getDet->priceTo, -2, 2) == '00')
				$priceToCut = substr($getDet->priceTo, 0, -3);
			else
				$priceToCut = $getDet->priceTo;
			$this->priceTo = $priceToCut;
			
			$this->breakfast = $getDet->breakfast;
			$this->active = $getDet->active;
		}
		else 
			$this->id = "";
		
	}
	
	
	function toString($action = '', $picSize = '90', $detail = false) {
		
		$html = "";
		
		if(empty($this->id)) { // if articel doesnt exist
			$html .= Content::$articleDoesntExist;
			return $html;
		}
		
		switch($action) {
			case "editable":
				$titleDiv = "<div>"; // title
					$titleDiv .= "<h2>". formatUmlautsEback($this->title); 
						$titleDiv .= " <a href=\"?p=login&a=edit_accomodations&aid=". $this->id ."\" style=\"font-size: 9pt;\">". Content::$edit ."</a>";
					$titleDiv .= "</h2>";
				$titleDiv .= "</div>";
						
			break;
			
			default:					
				$titleDiv = "<div>"; // title
					$titleDiv .= "<h2><a href=\"". SERVER ."/de/hotelDetails/". $this->id ."\">". formatUmlautsEback($this->title) ."</a></h2><br><br>";
				$titleDiv .= "</div>";
			break;
		}	
		$html .= "<div class=\"article\" id=\"article_". $this->id ."\">";
			$html .= $titleDiv;
			$html .= "<div class=\"price\">"; // price & url
				if($this->priceTo != 0 AND $this->priceFrom != 0) {
					$html .= str_replace(".", ",", $this->priceFrom) ."&euro;";
					$html .= " - ";
					$html .= str_replace(".", ",", $this->priceTo) ."&euro;";
				}					
				$url = parse_url($this->url);
				if(!empty($url['host']))
					$html .= " &rarr; <a target=\"_blank\" href=\"". $this->url ."\">". $url['host'] ."</a>";
			$html .= "</div>";
			$html .= "<div class=\"thisImg\">"; // pic
				if(empty($this->pic))
					$html .= "";
				else {
					$html .= "<a href=\"". SERVER ."/de/hotelDetails/". $this->id ."\">";
						if(substr($this->pic, 0, 4) == 'http')
						$html .= "<img src=\"". $this->pic ."\" alt=\"pic\" style=\"max-width: ". $picSize ."px;\" />";
					else
						$html .= "<img src=\"". SERVER ."/accomodation_fotos/thumbs/". $this->pic ."\" alt=\"". $this->pic ."\" style=\"max-width: ". $picSize ."px;\" />";
					$html .= "</a>";
				}
			$html .= "</div>";
			$html .= "<div>"; // text
				$text = formatUmlautsEback($this->text); 
				if(strlen($text) > 100 AND !$detail) {
					$text = str_replace("<br>", " ", substr($text, 0, 100)) ."...";
					$text .= " <a href=\"". SERVER ."/de/hotelDetails/". $this->id ."\">". Content::$readMore ."</a>";
				}
				//$html .= wordwrap($text, 70, "<br>");
				$html .= $text;
				
				
			$html .= "</div>";
			$html .= "<div>";  // ort
				$html .= Content::$ort .": <a target=\"_blank\" href=\"http://www.google.com/maps/preview?q=". $this->zip . formatUmlautsEback($this->ort) ."\">". formatUmlautsEback($this->ort) ."</a>";
			$html .= "</div>";	
			$html .= "<div>";  // street
				$html .= Content::$street .": <a target=\"_blank\" href=\"http://www.google.com/maps/preview?q=". $this->zip . formatUmlautsEback($this->ort) . formatUmlautsEback($this->street) ."\">". formatUmlautsEback($this->street) ."</a>";
			$html .= "</div>";	
			$html .= "<div>";  // breakfast
				$html .= Content::$breakfast .": ". formatUmlautsEback($this->breakfast) ."</a>";
			$html .= "</div>";						
		$html .= "</div>";
		
		return $html;
	}	
	
	function updateDb($ordner, $fileLink, $ortNew, $zipNew) {
		/*	$filedata = $_FILES['file']; // TODO image upload
							
						if(!empty($filedata['type'])) {
						echo "file UPLOAD"; exit;
							switch($filedata['type'])
							{
								case "image/gif": $filetype = ".gif"; break;
								case "image/jpeg": $filetype = ".jpg"; break;
								case "image/png": $filetype = ".png"; break;
								default: $filetype = ""; break;
							}

							$filesize = $filedata['size'];
							if($filetype != '.gif' AND $filetype != '.jpg' AND $filetype != '.png')
							{
							echo Content::$permittedImgFormats;
							exit;
							}
							elseif($filesize > 943719)
							{
							echo Content::$fileSizeExceedsLimit;
							exit;
							}
							else
							{
							
								$filename = "pic_". $_GET['aid'] . $filetype;				
								$pfad = $PATH;
								$ordner = $ordner;
								
								list($imgx, $imgy, $type, $attr) = getimagesize($filedata['tmp_name']);
								// create pic
								$img = imagecreatefromjpeg(''. $filedata['tmp_name'] .'');
								$bx= 200;                 // neue Breite angeben
								$by= $imgy * $bx / $imgx;                 // neue Hoehe angeben
													
								$bildneu=imagecreatetruecolor($bx,$by);
								imagecopyresized($bildneu,$img,0,0,0,0,$bx,$by,$imgx,$imgy);					
													
								imagejpeg($bildneu,$pfad."/".$ordner."/".$filename);	
								// create pic ENDE
								
								// now create the thumbnail
								$img = imagecreatefromjpeg(''. $filedata['tmp_name'] .'');
								$bx= 70;                 // neue Breite angeben
								$by= $imgy * $bx / $imgx;                 // neue Hoehe berechnen
								
								$thumbneu=imagecreatetruecolor($bx,$by);
								imagecopyresized($thumbneu,$img,0,0,0,0,$bx,$by,$imgx,$imgy);
								
																		
								imagejpeg($thumbneu,$pfad."/".$ordner."/thumbs/".$filename);					
								// now create the thumbnail
							
									
								if (!file_exists($pfad.'/'.$ordner.'/'.$filename))
									echo Content::$uploadError;
								else
									echo Content::$uploadSuccess;
							}
						}
						else	//		"id title text pic shop url price active"
		*/					$pic = $fileLink;
								
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
							echo "<script language=\"JavaScript\">location.href=\"". SERVER ."/?p=login&a=edit_accomodations&aid=". $_GET['aid'] ."\";</script>";
						}
						else {	// new						
							$add_entry = mysql_query("INSERT INTO accomodations (ort, zip, street, title, text, pic, url, priceFrom, priceTo, breakfast, active) VALUES ('". $ort ."', '". $zip ."', '". $street ."', '". $title ."', '". $text ."', '". $pic ."', '". $url ."', '". $priceFrom ."', '". $priceTo ."', '". $breakfast ."', 'yes')");
							echo "<script language=\"JavaScript\">location.href=\"". SERVER ."/?p=login&a=edit_accomodations&aid=new\";</script>";
						}
	}
	
	function edit($id) {
		$html = "";
		$content_id = $id;
		$this->id = $id;

				$html .= "<div class=\"editBox\">";
					$html .= "<form method=\"post\">"; // enctype=\"multipart/form-data\">";
						$html .= "<div style=\"text-align: left;\">";
							$html .= "<div id=\"toolbar\" style=\"display: none;\">";
							$html .= "<a data-wysihtml5-command=\"bold\" title=\"CTRL+B\"><img src=\"". SERVER ."/images/bold.png\" alt=\"bold\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"italic\" title=\"CTRL+I\"><img src=\"". SERVER ."/images/italic.png\" alt=\"italic\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"createLink\"><img src=\"". SERVER ."/images/link.png\" alt=\"link\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"insertImage\" onclick=\"document.getElementById('setPic').style.display = 'block';\"><img src=\"". SERVER ."/images/img.png\" alt=\"img\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"formatBlock\" data-wysihtml5-command-value=\"h1\"><img src=\"". SERVER ."/images/h1.png\" alt=\"&Uuml;berschrift 1\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"formatBlock\" data-wysihtml5-command-value=\"h2\"><img src=\"". SERVER ."/images/h2.png\" alt=\"&Uuml;berschrift 2\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"insertUnorderedList\"><img src=\"". SERVER ."/images/list.png\" alt=\"list\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"insertOrderedList\"><img src=\"". SERVER ."/images/orderedList.png\" alt=\"orderedList\" /></a> ";
							$html .= "<a data-wysihtml5-command=\"foreColor\" data-wysihtml5-command-value=\"red\"></a> ";
							$html .= "<a data-wysihtml5-command=\"foreColor\" data-wysihtml5-command-value=\"yellow\"></a> ";
							$html .= "<a data-wysihtml5-command=\"foreColor\" data-wysihtml5-command-value=\"blue\"></a> ";
							$html .= "<a data-wysihtml5-command=\"foreColor\" data-wysihtml5-command-value=\"white\"></a> ";
						//	$html .= "<a data-wysihtml5-command=\"insertSpeech\">speech</a>";
							$html .= "<a data-wysihtml5-action=\"change_view\">html</a>";
								
							$html .= "<div data-wysihtml5-dialog=\"createLink\" style=\"display: none;\">";
								$html .= "<label>";
									$html .= Content::$link .":";
									$html .= "<input data-wysihtml5-dialog-field=\"href\" value=\"http://\">";
								$html .= "</label>";
								$html .= "<a data-wysihtml5-dialog-action=\"save\">". Content::$paste ."</a>&nbsp;<a data-wysihtml5-dialog-action=\"cancel\">". Content::$abort ."</a>";
							$html .= "</div>";
								
							$html .= "<div data-wysihtml5-dialog=\"insertImage\" style=\"display: none;\">";
								
								$html .= "<div id=\"setPic\">";
									$html .= "<div id=\"container\">";
									//	$html .= "<div id=\"filelist\">No runtime found.</div>";
										$html .= "<div id=\"filelist\"></div>";
										$html .= "<br />";
										$html .= "<a id=\"pickfiles\" href=\"javascript:;\">". Content::$pickImg ."</a> ";
										$html .= "<a id=\"uploadfiles\" href=\"javascript:;\">". Content::$uploadImg ."</a>";
									$html .= "</div>";
									
									$pl_ord = "geschenk_fotos";
								
								$html .= "<script type=\"text/javascript\" src=\"". SERVER ."/js/fotoUpload.js\"></script>";
									
								
									$html .= "<div id=\"uploaded_fotos\">";
										$html .= "<a href=\"". SERVER ."/includes/uploadedFotos.php\" target=\"uploadedFotos_iFrame\"><img src=\"". SERVER ."/images/reload.png\" alt=\"reload\" /></a><br><br>";
										$html .= "<iframe src='". SERVER ."/includes/uploadedFotos.php' width='500' height='300' style='border: 0px solid transparent;' name='uploadedFotos_iFrame'></iframe>";
									$html .= "</div>";
								$html .= "</div>";
								$html .= "<div>";
									$html .= "  <label>";
									$html .= "	". Content::$image .":";
									$html .= "	<input data-wysihtml5-dialog-field=\"src\" value=\"http://\" style=\"display: inline;\" id=\"insertImgUrl\">";
									$html .= "  </label>";
									$html .= "  <label>";
									$html .= "	". Content::$alignment .":";
									$html .= "	<select data-wysihtml5-dialog-field=\"className\">";
										$html .= "  <option value=\"\">". Content::$alignStandard ."</option>";
										$html .= "  <option value=\"wysiwyg-float-left\">". Content::$alignLeft ."</option>";
										$html .= "  <option value=\"wysiwyg-float-right\">". Content::$alginRight ."</option>";
									$html .= "	</select>";
									$html .= "  </label>";
									$html .= "  <a data-wysihtml5-dialog-action=\"save\">". Content::$paste ."</a>&nbsp;<a data-wysihtml5-dialog-action=\"cancel\">". Content::$abort ."</a>";
								$html .= "</div>";
							$html .= "</div>";
									//		"id title text pic shop url price active"
							$html .= "</div>";
							$html .= Content::$ort .": <select class=\"required\" name=\"ort\">";
								$getLocations = mysql_query("SELECT * FROM accomodation_locations ORDER BY name ASC");
								$html .= "<option></option>";
								while($ort = mysql_fetch_object($getLocations)) {
									$html .= "<option value=\"". $ort->zip .",". $ort->name ."\" "; if($ort->name == $this->ort) $html .= "selected=\"selected\" "; $html .= ">";
										$html .= formatUmlautsEback($ort->name);
									$html .= "</option>";
								}
							$html .= "</select>";
							$html .= Content::$newZip .", ". Content::$newOrt .": <input type=\"text\" style=\"width: 50px;\" name=\"zipNew\" /> ";
							$html .= "<input type=\"text\" style=\"width: 250px;\" name=\"ortNew\" /><br>";
							$html .= Content::$accomodationName .": <input class=\"required\" type=\"text\" style=\"width: 250px;\" name=\"title\" value=\"". formatUmlautsEback($this->title) ."\""; $html .= " /><br>";
							$html .= Content::$street .": <input type=\"text\" style=\"width: 250px;\" name=\"street\" value=\"". formatUmlautsEback($this->street) ."\""; $html .= " /><br>";
							//$html .= Content::$image .": ";
							//$html .= "<input type=\"file\" style=\"width: 250px;\" name=\"file\" />"; // TODO image upload
							$html .= Content::$imageLink ." <input type=\"text\" style=\"width: 250px;\" name=\"fileLink\" "; if(substr($this->pic, 0, 4) == 'http') $html .= "value=\"". $this->pic ."\""; $html .= " /><br>";
							$html .= Content::$linkToHotel .": <input type=\"text\" style=\"width: 250px;\" name=\"url\" value=\"". $this->url ."\""; $html .= " /><br>";
							$html .= Content::$price ." ". Content::$priceFrom .": <input type=\"text\" style=\"width: 50px;\" name=\"priceFrom\" value=\"". str_replace(".", ",", $this->priceFrom) ."\""; $html .= " />";
							$html .= Content::$priceTo .": <input type=\"text\" style=\"width: 50px;\" name=\"priceTo\" value=\"". str_replace(".", ",", $this->priceTo) ."\""; $html .= " />&euro;<br>";
							$html .= Content::$breakfast .": <input type=\"text\" style=\"width: 150px;\" name=\"breakfast\" value=\"". str_replace(".", ",", $this->breakfast) ."\""; $html .= " /><br>";
						$html .= "</div>";
						$html .= "<textarea id=\"textarea\" name=\"text\" class=\"textarea2\" style=\"font-size: 11px;\" width=\"200px\">". formatUmlautsEback($this->text) ."</textarea>";
						$html .= "<input type=\"hidden\" name=\"content_id\" value=\"". $this->id ."\">";
						$html .= "<input type=\"hidden\" name=\"ordner\" value=\"accomodation_fotos\">";
						$html .= "<input type=\"hidden\" name=\"new_entry".$this->id."\" value=\"new_entry".$this->id."\">";
						$html .= "<br>";
						if($this->id == 'new') $btnValue = Content::$insertBtn; else $btnValue = Content::$editBtn;
						$html .= "<input class=\"btn\" type=\"submit\" value=\"". $btnValue ."\">";
						$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$html .= "</form>";
					$html .= "<script type=\"text/javascript\" src=\"js/jquery.js\"></script>";
					$delBtn = new Method();
					$html .= $delBtn->deleteButton('gifts', 'deleteArticle', $this->id);
						
				$html .= "</div>";
				
				if($_POST['new_entry'.$this->id.''] == 'new_entry'.$this->id.'') {
					$ortZip = explode(',', $_POST['ort']);
					$this->ort = $ortZip[1];
					$this->zip = $ortZip[0];
					
					$this->street = $_POST['street'];
					
					$this->title = $_POST['title'];
					$this->text = $_POST['text'];
					$this->pic = $_POST['pic'];
					$this->url = $_POST['url'];
					$this->priceFrom = $_POST['priceFrom'];
					$this->priceTo = $_POST['priceTo'];
					$this->breakfast = $_POST['breakfast'];
					
					$this->updateDb($_POST['ordner'], $_POST['fileLink'], $_POST['ortNew'], $_POST['zipNew']);
				}
		return $html; 
	}
	
	function deleteArticle($delete, $id) {
		if($delete == 'on')
			$delFromAkt = mysql_query("DELETE FROM accomodations WHERE id LIKE '". $id ."'");
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=edit_accomodations&ort=". $this->ort ."&deleted\";</script>";	
	}
	
}

?>