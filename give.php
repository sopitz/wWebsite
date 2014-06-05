<?php
require_once('box.php');
require_once('gifts.php');
require_once('language/content.php');

if(isset($LOGIN)) {
	if(isset($_GET['id'])) {

		if(empty($_GET['gift'])) {
			$html = "";

			$get_entries = mysql_query("SELECT * FROM hochzeitstisch WHERE id LIKE '". $_GET['id'] ."' ORDER BY id DESC LIMIT 1");

			while(!empty($get_entries) && $entry = mysql_fetch_object($get_entries)) {

				$html .="<div id=\"articleDetail\">";
					if($entry->active == $_SESSION['userID'])
						$html .= Content::$thankYou ."<br>";
					
					if($entry->active == $_SESSION['userID'])
						$html .= "<br>". Content::$thankYouAlert ."<br><a href=\"". $SERVERNAME ."/myGifts\">". Content::$to ." ". Content::$linkToMyGifts ."</a><br><br>";
	
					$article = new Gifts($entry->id);
					if($_GET['view'] == 'detail')
						$html .= $article->toString('', '400');
					else
						$html .= $article->toString('', '400', true);
	
					
				$html .="</div>";
			} // while
			if(mysql_num_rows($get_entries) == 0)
				$html .= Content::$articleDoesntExist;
		}
		elseif($_GET['gift'] == 'yes') {
			$still_active = mysql_fetch_object(mysql_query("SELECT * FROM hochzeitstisch WHERE id LIKE '". $_GET['id'] ."' ORDER BY id DESC LIMIT 1"));
			if($still_active->active == 'yes') {
				$insGift = mysql_query("INSERT INTO gifts (itemID, userID) VALUES ('". $_GET['id'] ."', '". $_SESSION['userID'] ."')");
				$updHochzeitsTisch = mysql_query("UPDATE hochzeitstisch SET active='". $_SESSION['userID'] ."' WHERE id LIKE '". $_GET['id'] ."'");
				echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/give/". $_GET['id'] ."\";</script>";
			}
			else
				$html .="<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/gift/notactive\";</script>";
		} // gift==yes
		elseif($_GET['gift'] == 'notactive') {
			$html .= Content::$alreadyGiven;
		}
		$giftBox = new Box('giftBox');
		$giftBox->specialfill($html);
	} // isset id
	else
		echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/home\";</script>";
}
?>
<script>$('#navi').animate({left: "10px"}, "slow");</script>
<script>$('.verschenkt').css({width: "500px"});</script>
<script>$('.verschenktID').hide();</script>
