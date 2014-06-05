<?php 
 if(!empty($_GET['logout']))
 {
 session_start();
 session_destroy();
 }

session_start();
 
include_once 'includes/config.php';
 
if(isset($_SESSION['usrname']))
{	
  if(isset($_GET['setloginCookie']) && $_GET['setloginCookie'] == 'yes')
  {
    $_1653 = md5($_SESSION['usrname']);
	setcookie("hzwebsite", "".$_1653."");	
	unset($_1653);
	if(isset($_SESSION['group']) && $_SESSION['group'] == 'admin')
		$redirect = SERVER ."/?p=login";
	elseif(!empty($_GET['firstLog']))
		$redirect = SERVER ."/?p=login&firstLog=yes";
	else
		$redirect = SERVER ."/";
		
    echo "<script language=\"JavaScript\">location.href=\"".$redirect."\";</script>";
  }
}

unset($LOGIN);
if(isset($_SESSION['usrname']) AND md5($_SESSION['usrname']) == isset($_COOKIE['hzwebsite']))
	$LOGIN = 1;

	
error_reporting(null);

require_once('includes/order.php');
require_once('includes/loading.php');
?>
<!DOCTYPE html>
<html lang="de">
<?php
if(!empty($_POST['give'])) {
	$loading = new Loading();
	echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/give/". $_POST['give'] ."\";</script>";
}
echo '<link rel="icon" href="'. SERVER .'/heart.gif" type="image/gif">';

include_once 'includes/header.php'
?>
<?php

	if(substr(isset($_GET['p']), 0, 4) == 'http' OR substr(isset($_GET['p']), 0, 3) == 'ftp')
	 {
	  include 'home.php';
	  echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."\";</script>";
	 }
	else
	 {
		if(empty($_GET['p']))
		{
		if(!file_exists('home.php'))
		  {
		  include 'missed.php';
		  }
		  else
		  {
			echo "<div id=\"art_container\">";
				echo "<img src=\"". SERVER ."/images/wait.gif\" />";
			echo "</div>";
		  }
		}
		elseif(!empty($_GET['p']) && $_GET['p'] != 'home' && $_GET['p'] != 'list' && $_GET['p'] != 'hotels')
		{	
		$PAGE = $_GET['p'];
		$page = $PAGE .".php";
		if(!file_exists($page))
		  {
		  include 'missed.php';
		  }
		  else
		  {
		  include $page;
		  }
		}
		elseif($_GET['p'] == 'home' OR $_GET['p'] == 'list' OR $_GET['p'] == 'hotels') {
			echo "<div id=\"art_container\">";
				echo "<img src=\"". SERVER ."/images/wait.gif\" />";
			echo "</div>";
		}			
	  }
	  
?>
<?php
include_once 'includes/footer.php';
?>
<script src="<?php echo SERVER; ?>/parser_rules/advanced.js"></script>
<script src="<?php echo SERVER; ?>/dist/wysihtml5-0.3.0.js"></script>
<script>
  var editor = new wysihtml5.Editor("textarea", {
    toolbar:      "toolbar",
    stylesheets:  "<?php echo SERVER; ?>/css/stylesheet.php",
    parserRules:  wysihtml5ParserRules
  });
</script>
</html>
<?php	// show order and changeView boxes
if($PAGE == 'home' OR $PAGE == 'list') {
$wrongLog = "";
if(isset($_GET['wrong_log']))
	$wrongLog = $_GET['wrong_log'];
	
echo "<script>
		$(document).ready(function() {			
				$('#art_container').load( '". SERVER ."/". $PAGE .".php?wrong_log=". $wrongLog ."' );
		});
	</script>"; 
	if(isset($LOGIN)) {
		$order = new Order();
		$orderBox = new Box('orderBox');
		$orderBox->specialfill($order->toString());
		$orderBox->dragable();
		
		
		
		$viewLink = "<a href=\"". $SERVERNAME ."/";
		if($PAGE == 'home') $viewLink .= "list\">". Content::$listView ."</a>";
		elseif($PAGE == 'list') $viewLink .= "home\">". Content::$boxView ."</a>";
		
		$listBox = new Box('changeView');
		$listBox->specialfill($viewLink);
		$listBox->size(90, 20);
	}
}
elseif($PAGE == 'hotels') {
$wrongLog = "";
if(isset($_GET['wrong_log']))
	$wrongLog = $_GET['wrong_log'];
	
echo "<script>
		$(document).ready(function() {			
				$('#art_container').load( '". SERVER ."/". $PAGE .".php' );
		});
	</script>"; 
	if(isset($LOGIN)) {
		require_once('includes/orderHotels.php');
		$order = new OrderHotels();
		$orderBox = new Box('orderBox');
		$orderBox->specialfill($order->toString());
		echo "<script>$('#orderBox').css({left: \"10px\"});</script>";
	}
}
elseif($_GET['a'] == 'edit_entries' AND empty($_GET['aid'])) { // edit_entries overview
	$order = new Order(SERVER .'/?p=login&a=edit_entries', 'sortFormIntern');
	$orderBox = new Box('orderBox');
	$orderBox->specialfill($order->toString());
	
	
	echo "<script>$('#orderBox').css({left: \"10px\"});</script>";
}
elseif($PAGE == 'myGifts') {
	$viewLink = "<a href=\"". $SERVERNAME ."/myGifts/list\">". Content::$listView ."</a>";
	$listBox = new Box('changeView');
	$listBox->specialfill($viewLink);
	$listBox->size(90, 20);
	
}
?>
<script>
// Attach a submit handler to the form
$( "#sortForm" ).submit(function( event ) {

 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var $form = $( this ),
	active = $form.find( "input[type='checkbox']" ).prop("checked"),
    cat = $form.find( "select[name='cat']" ).val(),
    ort = $form.find( "select[name='ort']" ).val(),
    orderByPriceTo = $form.find( "select[name='orderByPriceTo']" ).val(),
    minPrice = $form.find( "input[name='minPrice']" ).val(),
    maxPrice = $form.find( "input[name='maxPrice']" ).val(),
  //  url = "http://localhost/hzWebsite/" + $form.attr( "action" );
    url = "<?php echo SERVER ."/". $PAGE .".php"; ?>";
 
  // Send the data using post
  $.post( url, { active: active, cat: cat, ort: ort, orderByPriceTo: orderByPriceTo, minPrice: minPrice, maxPrice: maxPrice } ).done(function( data ) {
	$('#art_container').empty().append( data );
  });
  
  
});
</script>