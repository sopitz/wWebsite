<?php 

require_once('language/content.php');
require_once('box.php');
require_once('login.php');
require_once('includes/loading.php');
echo "<link rel=\"stylesheet\" href=\"css/style.php\" media=\"screen\" type=\"text/css\">";

if(isset($LOGIN)) {
	$html = "";
	
	
	$html .= Content::$infoText2 ."<br>";
	$html .= Content::$infoTextAddress ."<br><br>";
	$html .= "<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d572.3639663004815!2d7.729527373032567!3d47.55509100681379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDfCsDMzJzE4LjMiTiA3wrA0Myc0Ni4xIkU!5e1!3m2!1sde!2s!4v1396188259352\" width=\"525\" height=\"350\" frameborder=\"0\" style=\"border:0;\"></iframe>";
	$html .= "<br><br>". Content::$infoText3;
	$html .= "<br><br>";
	$html .= "<h2><a href=\"". $SERVERNAME ."/hotels\">". Content::$infoText1 ." ". Content::$here ."</a></h2>";
	$html .= "<br>". Content::$infoText4 ." <a target=\"_blank\" href=\"https://www.google.com/maps/place/Flughafen+Basel+Mulhouse+Freiburg/@47.5841246,7.5820584,13z/data=!4m2!3m1!1s0x0:0xbf89976c80072a54\">". Content::$infoText5 ."</a> ". Content::$infoText6;
	
	$infoBox = new Box('infoBox');
	$infoBox->specialfill($html);
	$infoBox->size('550','550');
}
else
	echo "<script>location.href=\"". $SERVERPATH ."\";</script>";
?>
<script>
	$('#navi').animate({left: "10px"}, "slow");
</script>