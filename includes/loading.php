<?php
include_once('config.php');

echo "<link rel=\"stylesheet\" href=\"". $SERVERPATH ."/css/style.php\" media=\"screen\" type=\"text/css\"/>";

class Loading {
	
	public function __construct() {
		echo "<div id=\"loading\"><img src=\"". SERVER ."/images/loading.gif\" /></div>";
	}
	
	public function hide() {
		echo "<script>$('#loading').css({display: \"none\"});</script>";
	}
}
?>