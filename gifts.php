<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once('main.php');
require_once('Method.php');
require_once('language/content.php');

class Gifts {

	private $id;
	private $cat;
	private $title;
	private $text;
	private $pic;
	private $shop;
	private $url;
	private $price;
	private $active;
	
	
	
	function __construct($id) {
		
		
		$getDet = mysql_fetch_object(mysql_query("SELECT * FROM hochzeitstisch WHERE id LIKE '". $id ."' ORDER BY id DESC LIMIT 1"));
		
		if(!empty($getDet)) {
			$this->id = $id;
			$this->cat = $getDet->cat;
			$this->title = $getDet->title;
			$this->text = $getDet->text;
			$this->pic = $getDet->pic;
			$this->shop = $getDet->shop;
			$this->url = $getDet->url;
			$this->price = $getDet->price;
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
					$titleDiv .= " <a href=\"?p=login&a=edit_entries&aid=". $this->id ."\" style=\"font-size: 9pt;\">". Content::$edit ."</a>";

					
					if($this->active != 'yes')
						$titleDiv .= " <span style=\"color: red;\">". Content::$notActive ."</span>";
					$titleDiv .= "</h2>";
				$titleDiv .= "</div>";
						
			break;
			
			default:
				if($this->active != 'yes' && $this->active != $_SESSION['userID'])
					$html .= "<div class=\"verschenkt\" id=\"verschenkt_". $this->id ."\"></div>";
				elseif($this->active == $_SESSION['userID'])
					$html .= "<div class=\"verschenktID\" id=\"verschenkt_". $this->id ."\"></div>";
					
				$titleDiv = "<div>"; // title
					$titleDiv .= "<h2><a href=\"". SERVER ."/de/give/". $this->id ."\">". formatUmlautsEback($this->title) ."</a></h2><br><br>";
					if($this->active == 'yes') {
						if($detail == true) {
							$titleDiv .= Content::$giveDetail ." <a href=\"". SERVER ."/de/gift/". $_GET['id'] ."\" class=\"btnSchenken\">". Content::$here ."</a>";
						}
						else {
							$titleDiv .= "<form class=\"btnForm\" method=\"post\" action=\"". $_SERVER['PHP_SELF'] ."\">";
								$titleDiv .= "<input type=\"hidden\" value=\"". $this->id ."\" name=\"give\" />";
								$titleDiv .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"". Content::$giveBtn ."\" class=\"btnSchenken\" />";
							$titleDiv .= "</form>";
						}
					}
					$titleDiv .= "</h2>";
				$titleDiv .= "</div>";
			break;
		}	
		$html .= "<div class=\"article\" id=\"article_". $this->id ."\">";
			$html .= $titleDiv;
			$html .= "<div>"; // price & url
				if($this->price != '0.00')
					$html .= str_replace(".", ",", $this->price) ." &euro;";
				
				$url = parse_url($this->url);
				if(!empty($url['host']))
					$html .= " &rarr; <a target=\"_blank\" href=\"". $this->url ."\">". $url['host'] ."</a>";
			$html .= "</div>";
			$html .= "<div class=\"thisImg\">"; // pic
				if(empty($this->pic))
					$html .= "";
				else {
					$html .= "<a href=\"". SERVER ."/de/give/". $this->id ."\">";
						if(substr($this->pic, 0, 4) == 'http')
						$html .= "<img src=\"". $this->pic ."\" alt=\"pic\" style=\"max-width: ". $picSize ."px;\" />";
					else
						$html .= "<img src=\"". SERVER ."/geschenk_fotos/thumbs/". $this->pic ."\" alt=\"". $this->pic ."\" style=\"max-width: ". $picSize ."px;\" />";
					$html .= "</a>";
				}
			$html .= "</div>";
			$html .= "<div>"; // text
				$text = formatUmlautsEback($this->text); 
				if(strlen($text) > 100 AND !$detail) {
					$text = str_replace("<br>", " ", substr($text, 0, 100)) ."...";
					$text .= " <a href=\"". SERVER ."/de/give/". $this->id ."\">". Content::$readMore ."</a>";
				}
//				$html .= wordwrap($text, 30, "<br>");
				$html .= $text;
				
			$html .= "</div>";
			$html .= "<div>";  // shop
				if(!empty($this->shop))
					$html .= Content::$foundAt ." <a target=\"_blank\" href=\"". $this->url ."\">". $this->shop ."</a>";
			$html .= "</div>";						
		$html .= "</div>";
		
		return $html;
	}	
	
	function updateDb($ordner, $fileLink, $catNew) {
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
								
						if(empty($this->cat) && !empty($catNew)) {
							$cat = format_text($catNew);
							$queryCat = mysql_query("SELECT * FROM categories WHERE name LIKE '". $catNew ."' ORDER BY id ASC");
							if(mysql_num_rows($queryCat) == 0) 								
								$insertCat = mysql_query("INSERT INTO categories (name) VALUES ('". $cat ."')");
						}
						else
							$cat = format_text($this->cat);
						$title = format_text($this->title);
						$shop = format_text($this->shop);
						$url = $this->url;
						$price = str_replace(",", ".", $this->price);
						$text = format_text($this->text);
							
						if($this->id != 'new') { // edit
							$edit_entry = mysql_query("UPDATE hochzeitstisch SET cat='". $cat ."', title='". $title ."', text='". $text ."', pic='". $pic ."', shop='". $shop ."', url='". $url ."', price='". $price ."' WHERE id LIKE '". $this->id ."'");	
							echo "<script language=\"JavaScript\">location.href=\"". SERVER ."/?p=login&a=edit_entries&aid=". $_GET['aid'] ."\";</script>";
						}
						else {	// new						
							$add_entry = mysql_query("INSERT INTO hochzeitstisch (cat, title, text, pic, shop, url, price, active) VALUES ('". $cat ."', '". $title ."', '". $text ."', '". $pic ."', '". $shop ."', '". $url ."', '". $price ."', 'yes')");
							echo "<script language=\"JavaScript\">location.href=\"". SERVER ."/?p=login&a=edit_entries&aid=new\";</script>";
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
							$html .= Content::$category .": <select class=\"required\" name=\"cat\">";
								$getCats = mysql_query("SELECT * FROM categories ORDER BY name ASC");
								$html .= "<option></option>";
								while($cat = mysql_fetch_object($getCats)) {
									$html .= "<option value=\"". $cat->name ."\" "; if($cat->name == $this->cat) $html .= "selected=\"selected\" "; $html .= ">";
										$html .= formatUmlautsEback($cat->name);
									$html .= "</option>";
								}
							$html .= "</select>";
							$html .= Content::$newCategory .": <input type=\"text\" style=\"width: 250px;\" name=\"catNew\" /><br>";
							$html .= Content::$title .": <input class=\"required\" type=\"text\" style=\"width: 250px;\" name=\"title\" value=\"". formatUmlautsEback($this->title) ."\""; $html .= " /><br>";
							//$html .= Content::$image .": ";
							//$html .= "<input type=\"file\" style=\"width: 250px;\" name=\"file\" />"; // TODO image upload
							$html .= Content::$imageLink ." <input type=\"text\" style=\"width: 250px;\" name=\"fileLink\" "; if(substr($this->pic, 0, 4) == 'http') $html .= "value=\"". $this->pic ."\""; $html .= " /><br>";
							$html .= Content::$shop .": <input type=\"text\" style=\"width: 250px;\" name=\"shop\" value=\"". formatUmlautsEback($this->shop) ."\""; $html .= " /><br>";
							$html .= Content::$link .": <input type=\"text\" style=\"width: 250px;\" name=\"url\" value=\"". $this->url ."\""; $html .= " /><br>";
							$html .= Content::$price .": <input type=\"text\" style=\"width: 50px;\" name=\"price\" value=\"". str_replace(".", ",", $this->price) ."\""; $html .= " /><br>";
						$html .= "</div>";
						$html .= "<textarea id=\"textarea\" name=\"text\" class=\"textarea2\" style=\"font-size: 11px;\" width=\"200px\">". formatUmlautsEback($this->text) ."</textarea>";
						$html .= "<input type=\"hidden\" name=\"content_id\" value=\"". $this->id ."\">";
						$html .= "<input type=\"hidden\" name=\"ordner\" value=\"geschenk_fotos\">";
						
						$html .= "<input type=\"hidden\" name=\"new_entry".$this->id."\" value=\"new_entry".$this->id."\">";
						$html .= "<br>";
						if($this->id == 'new') $btnValue = Content::$insertBtn; else $btnValue = Content::$editBtn;
						$html .= "<input class=\"btn\" type=\"submit\" value=\"". $btnValue ."\">";
						$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$html .= "</form>";
					// reactivate form
					$html .= "<script type=\"text/javascript\" src=\"js/jquery.js\"></script>";
					if($this->active != 'yes') {
						$reactivateBtn = new Method();
						$html .= $reactivateBtn->editButton('gifts', 'reactivateArticle', $this->id);
					}
					
					$delBtn = new Method();
					$html .= $delBtn->deleteButton('gifts', 'deleteArticle', $this->id);
						
				$html .= "</div>";
				
				// TODO update db active=yes AND DELETE IN GIFTS WHERE ARTICLEid like this->id
				
				if($_POST['new_entry'.$this->id.''] == 'new_entry'.$this->id.'') {
					$this->cat = $_POST['cat'];
					$this->title = $_POST['title'];
					$this->text = $_POST['text'];
					$this->pic = $_POST['pic'];
					$this->shop = $_POST['shop'];
					$this->url = $_POST['url'];
					$this->price = $_POST['price'];
					
					$this->updateDb($_POST['ordner'], $_POST['fileLink'], $_POST['catNew']);
				}
		return $html; 
	}
	
	function deleteArticle($delete, $id) {
		if($delete == 'on')
			$delFromAkt = mysql_query("DELETE FROM hochzeitstisch WHERE id LIKE '". $id ."'");
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=edit_entries&cat=". $this->cat ."&deleted\";</script>";	
	}
	
	function reactivateArticle($reactivate, $id) {
		if($reactivate == 'on') {
			$updateHochzeitstisch = mysql_query("UPDATE hochzeitstisch SET active='yes' WHERE id LIKE '". $id ."'");
			$delFromGifts = mysql_query("DELETE FROM gifts WHERE itemID LIKE '". $id ."'");
			echo "<script language=\"JavaScript\">location.href=\"?p=login&a=edit_entries&aid=". $id ."&reactivated\";</script>";
		}	
	}
	
}

?>