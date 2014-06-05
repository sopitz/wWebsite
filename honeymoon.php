<?php
require_once('box.php');
if(isset($LOGIN)) {
	
	$html ="<div id=\"articleDetail\">";
		$html .="<div>"; 
			$html .= Content::$honeymoon1;
		$html .="</div>";
		$html .="<div>";  
			$html .= "&nbsp;";
		$html .="</div>";	
		$html .="<div>"; 
			$html .= Content::$honeymoon2;
		$html .="</div>";
		$html .="<div>";  
			$html .= "&nbsp;";
		$html .="</div>";	
		$html .="<div>"; 
			$html .= Content::$honeymoon3;
		$html .="</div>";
		$html .="<div>";  
			$html .= "&nbsp;";
		$html .="</div>";	
		$html .="<div>"; 
			$html .= Content::$honeymoon4;
			$html .= "<span style=\"color: red;\">". Content::$honeymoon5 ."</span>";
		$html .="</div>";	
		$html .="<div>";  
			$html .= "&nbsp;";
		$html .="</div>";	
		$html .="<div>";  
			$html .= "<span style=\"color:red;font-weight: bold;\">". Content::$honeymoon6 ."</span>";
		$html .="</div>";	
		$html .="<div>";  
			$html .= "&nbsp;";
		$html .="</div>";	
		$html .="<div>";  
			$html .= Content::$honeymoon7;
		$html .="</div>";						
	$html .="</div>";	

$giftBox = new Box('giftBox');
$giftBox->specialfill($html);

}
?>
<script>$('#navi').animate({left: "10px"}, "slow");</script>