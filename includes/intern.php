<?php
error_reporting(E_ALL ^ E_NOTICE);

//require_once('config.php');
require_once('../hzWebsite/main.php');
require_once('../hzWebsite/class.accomodation.php');
require_once('../hzWebsite/gifts.php');
require_once('../hzWebsite/login.php');
require_once('orderHotels.php');
require_once('box.php');
require_once('language/content.php');

unset($LOGIN);
if(isset($_SESSION['usrname']) AND md5($_SESSION['usrname']) == isset($_COOKIE['hzwebsite']))
	$LOGIN = 1;

class Intern {


	function __construct() {
		
	}
	
	function toString() {
		
			
		if($_SESSION['group'] == 'admin') {
			$html = "";		
			
			switch($_GET['a'])
			{
				case "edit_accomodations":
					$html .= $this->edit_accomodations();	
				break;
				
				case "edit_entries":
					$html .= $this->edit_entries();
				break;
				
				case "users":					
					$html .= $this->edit_users();					
				break;				
				
				default:
				
					$html .= "<h2>". Content::$welcomeIntern ."</h2><br><br>";
					$html .= "<div>";
						$html .= "<a href=\"". SERVER ."/?p=login&a=users\">". Content::$editUsers ."</a><br>";
						$html .= "<a href=\"". SERVER ."/?p=login&a=edit_entries\">". Content::$editHochzeitstisch ."</a><br>";
						$html .= "<a href=\"". SERVER ."/?p=login&a=edit_accomodations\">". Content::$editAccomodations ."</a><br>";
					$html .= "</div>";
		
				break;
			} // switch a
		} //if Session group == admin
		else {
			echo "<script>location.href=\"". SERVER ."\";</script>";
			exit;
		}
		return $html;
		
	}
	
	function edit_users() {
		$html = "";
		
		$html .= "<div class=\"listBoxDiv\">";
			require_once(ROOT_DIR .'/intern/class.user.php');
			$user = new User();		
			$html .= $user;
		$html .= "</div>";
		echo "<script>$('#loginBoxIntern').css(\"width\", \"750px\");</script>";
		echo "<script>$('#loginBoxIntern').css(\"margin-left\", \"-200px\");</script>";
		
		
		return $html;
	}
	
	function edit_entries() {
		$html = "";
		
		if(isset($_GET['delID'])) {
			$article = new Gifts($_GET['delID']);
			$article->delete();
			$html .= "<script language=\"JavaScript\">location.href=\"?p=login&a=edit_entries\";</script>";
		}
					
		if(empty($_GET['aid'])) {
			
			$html .= "<a href=\"?p=login&a=edit_entries&aid=new\">". Content::$newEntry ."</a><br><br>";
			// "id cat title text pic shop url price active"
			$order = new Order();
						
							
			$entryIds = array();
			$articles = array();
						
						
			$query = $order->get_entries();
			$count = mysql_num_rows($query);
						
			if(!empty($query)) {
				$html .= "<div class=\"listBoxDiv\">";
				while($entry = mysql_fetch_object($query)) {
								
					$articles[$entry->id] = new Gifts($entry->id);			
					$html .= "<div class=\"editableBox\">";
						$html .= $articles[$entry->id]->toString('editable');
					$html .= "</div>";								
				}
				$html .= "</div>";
			}
			if($count == 0)
				$html .= "<br>". Content::$thereAreNoEntries ."<br>";
		}
		else {
			echo "<a href=\"". SERVER ."/?p=login&a=edit_entries\">". Content::$linkToEntries ."</a><br>";
						
			$article = new Gifts($_GET['aid']);	

			echo $article->edit($_GET['aid']);
			echo "<script src=\"". SERVER ."/js/jquery.js\"></script>";
						
						
			echo "<script>$('#loginBoxIntern').hide();</script>";
			echo "<script>$('#navi').css({left: \"10px\"});</script>";
		}
		
		return $html;
	}
	
	function edit_accomodations() {
		
		$html = "";	
		
		if(isset($_GET['delID'])) {
			$article = new Accomodation($_GET['delID']);
			$article->delete();
			$html .= "<script language=\"JavaScript\">location.href=\"?p=login&a=edit_accomodations\";</script>";
		}
						
		if(empty($_GET['aid'])) {
			
			$html .= "<a href=\"?p=login&a=edit_accomodations&aid=new\">". Content::$newEntry ."</a><br><br>";
			$order = new OrderHotels();
					
					
			$entryIds = array();
			$articles = array();
					
					
			$query = $order->get_entries();
			$count = mysql_num_rows($query);
					
			if(!empty($query)) {
				$html .= "<div class=\"listBoxDiv\">";
				while($entry = mysql_fetch_object($query)) {
			
					$articles[$entry->id] = new Accomodation($entry->id);
					$html .= "<div class=\"editableBox\">";
					$html .= $articles[$entry->id]->toString('editable');
					$html .= "</div>";
				}
				$html .= "</div>";
			}
			if($count == 0)
				$html .= "<br>". Content::$thereAreNoEntries ."<br>";
					
						
		}
		else {
			echo "<a href=\"". SERVER ."/?p=login&a=edit_accomodations\">". Content::$linkToEntries ."</a><br>";
				
			$article = new Accomodation($_GET['aid']);
				
			echo $article->edit($_GET['aid']);
			echo "<script src=\"". SERVER ."/js/jquery.js\"></script>";
					
					
			echo "<script>$('#loginBoxIntern').hide();</script>";
			echo "<script>$('#navi').css({left: \"10px\"});</script>";
		}
			
		return $html;
	
	}

}
?> 