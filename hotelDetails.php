<?php
require_once('box.php');
require_once('class.accomodation.php');
require_once('language/content.php');

if(isset($LOGIN)) {
	if(isset($_GET['id'])) {

		$html = "";

		$get_entries = mysql_query("SELECT * FROM accomodations WHERE id LIKE '". $_GET['id'] ."' ORDER BY id DESC LIMIT 1");

		while(!empty($get_entries) && $entry = mysql_fetch_object($get_entries)) {

			$html .="<div id=\"articleDetail\">";
			
			$article = new Accomodation($entry->id);
			$html .= $article->toString('', '400', true);
			
			$html .="</div>";
		} // while
		if(mysql_num_rows($get_entries) == 0)
			$html .= Content::$articleDoesntExist;

		$giftBox = new Box('giftBox');
		$giftBox->specialfill($html);
	} // isset id
	else
		echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/home\";</script>";
}
?>
<script>$('#navi').animate({left: "10px"}, "slow");</script>
