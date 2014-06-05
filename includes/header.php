<?php
require_once('box.php');
require_once('language/content.php');
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Michaela und Raphael heiraten</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="author" content="pixelitos webdesign Raphael Lais" />
	<meta name="title" content="Michaela und Raphael heiraten" />
	<meta name="publisher" content="pixelitos webdesign Raphael Lais" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" media="screen" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $SERVERPATH; ?>/css/style.php" media="screen" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $SERVERPATH; ?>/css/editor.php" media="screen" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $SERVERPATH; ?>/css/stylesheet.css" media="screen" type="text/css"/>
	<script type="text/javascript" src="<?php echo $SERVERPATH; ?>/js/jquery.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--	<script type="text/javascript" src="<?php echo $SERVERPATH; ?>/js/drag.js"></script>	-->
	<script language="JavaScript">
		$(document).ready(function() {
		/*	$("a[href^=http]").each(function(){
			  if(this.href.indexOf(location.hostname) == -1) {
				 $(this).attr({
					target: "_blank",
					title: <?php echo Content::$opensInNewTab; ?>
				 });
			  }
			});
		*/	
			$('.priceRange').focus(function() {
				if(!$('#minPrice').val() && !$('#maxPrice').val()) 
					$('#sort').css("display", "block");
				else
					$('#sort').css("display", "none");
			});
		
			$('.priceRange').keyup(function() {
				if( ($('#minPrice').val() <= $('#maxPrice').val()) && !(isNaN($('#minPrice').val())) && !(isNaN($('#maxPrice').val())) ) {
					$('#alertSearch').css("display", "none");
					$('#submitSearch').css("display", "inline");
				}
		/*		else {
					if($('#minPrice').val() > $('#maxPrice').val())
						$('#alertSearch').css("display", "block").html("Der Minimalwert ist größer als der Maximalwert.");
					else
						if(isNaN($('#minPrice').val()) && isNaN($('#maxPrice').val()))
							$('#alertSearch').css("display", "block").html("Es sind nur Ziffern erlaubt.");
					$('#submitSearch').css("display", "none");
				}
		*/		$('#alertDiff').html("min "+ $('#minPrice').val() +" max "+ $('#maxPrice').val());
			});
		
			
		});
	
	</script>
</head>
<body>
<?php
if(isset($LOGIN)) {
	echo "<div style=\"width: 220px;height: 110px;position: fixed;left: 0px;bottom: 0px;\">";
		echo "<a href=\"". $SERVERPATH ."/de/honeymoon\"><img src=\"". $SERVERPATH ."/images/plane.gif\" style=\"border: 0px solid transparent;\"/></a>";
	echo "</div>";
}
echo "<div id=\"pixelitos\" onclick=\"window.open('http://pixelitos.de');\"></div>";
echo "<div id=\"main\">";
		
		
		$naviContent = "<a id=\"home\" href=\"". $SERVERPATH ."/de/home\">". Content::$linkToHome ."</a>";
		if(isset($LOGIN) AND !empty($_SESSION['group']) AND $_SESSION['group'] == 'admin')
			$naviContent .= "<br><a id=\"intern\" href=\"". $SERVERPATH ."/index.php?p=login\">". Content::$linkToIntern ."</a>";
		if(isset($LOGIN) AND !empty($_SESSION['group']) AND $_SESSION['group'] != 'admin')
			$naviContent .= "<br><a id=\"myGifts\" href=\"". $SERVERNAME ."/myGifts\">". Content::$linkToMyGifts ."</a>";
		if(isset($LOGIN))
			$naviContent .= "<br><a id=\"infos\" href=\"". $SERVERNAME ."/infos\">". Content::$linkToInfos ."</a>";
		if(isset($LOGIN)) 
			$naviContent .= "<br><a id=\"logout\" href=\"". $SERVERPATH ."/index.php?logout=yes\">". Content::$linkToLogout ."</a>";
		if(!isset($LOGIN))
			$naviContent .= "<br><br><a id=\"register\" style=\"font-size: 13px;\" href=\"". $SERVERPATH ."/de/register\">". Content::$linkToRegister ."</a>";
//		if(!isset($LOGIN))
//			$naviContent .= "<br><br><a id=\"contact\" style=\"font-size: 13px;\" href=\"". $SERVERPATH ."/de/contact\">". Content::$linkToContact ."</a>";
		
		$navi = new Box('navi');
		$navi->specialfill($naviContent);
		$navi->bColor('#80ad2b');
		$navi->dragable();
		
		echo "<script>$('#". $PAGE ."').css({color: \"#80ad2b\"});</script>";
		?>