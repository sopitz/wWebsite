<?php

require_once('language/content.php');
require_once('includes/order.php');
require_once('box.php');
require_once('login.php');
require_once('gifts.php');
require_once('placeholder.php');
require_once('includes/loading.php');
echo "<link rel=\"stylesheet\" href=\"css/style.php\" media=\"screen\" type=\"text/css\">";

if(isset($LOGIN)) {

	if(!empty($_POST['give'])) {
		$loading = new Loading();
		echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/give/". $_POST['give'] ."\";</script>";
	}

	$order = new Order();

	$entryIds = array();
	$articles = array();


	$query = $order->get_entries();
	$count = mysql_num_rows($query);
	
	if($count == 0)
		$html .= "<br>". Content::$thereAreNoEntries ."<br>";
	
	$html .= $order->foundEntries() ."<br><br>";
	if(!empty($query)) {
		$html .= "<div class=\"listBoxDiv\">";
		while($entry = mysql_fetch_object($query)) {

			$articles[$entry->id] = new Gifts($entry->id);
			$html .= "<div class=\"listBox";
			if($entry->active != 'yes' && $entry->active != $_SESSION['userID'])
				$html .= " verschenktList";
			elseif($entry->active == $_SESSION['userID'])
				$html .= " verschenktIDList ";
			$html .= "\" id=\"listBox_". $entry->id ."\">";
			$html .= $articles[$entry->id]->toString();
			$html .= "</div>";
			array_push($entryIds, $entry->id);		
		}
		$html .= "</div>";
	}
	
	$box = new Box('loginBoxIntern');
	$box->specialfill($html);
	
/*
	foreach($entryIds as $id) {
		echo "<script>
				var boxHeight = $('#listBox_". $id ."').outerHeight(); 
				$('#verschenkt_". $id ."').css({height: boxHeight, margin: \"-10px\", padding: \"0px 10px 0px 10px\"}); 
		</script>";
	}
*/
	echo "<script>$('.verschenkt').hide();$('.verschenktID').hide();</script>";

	echo "<script>"; // define onclick function for boxBtn -> animate box
	echo "$(\".boxBtn\").bind(\"click\", function() {\n";
	echo "var opened = false; \n";
	echo "var href = $(this).attr(\"href\");\n";
	echo "if(href.substr(-5, 5) == \"Close\") { \n";
	echo "var href = href.substr(0, href.length -5);\n";
	echo "var opened = true; \n";
	echo "} \n";
	echo "var topPosition = $(this).attr(\"top\"); \n";
	echo "if(topPosition > 140) { \n";
	echo "var topOffset = 140; \n";
	echo "} else { \n";
	echo "var topOffset = \"0\"; \n";
	echo "} \n";
	echo "if(opened) {\n";
	echo "var oldContent = $(this).attr(\"content\");\n";
	echo "var oldSizes = $(this).attr(\"sizes\");\n";
	echo "var oldSizesArray = oldSizes.split(\",\");\n";
	echo "$(\"#\"+href+\"Btn\").animate({width: parseInt(oldSizesArray[0])+10+\"px\", height: parseInt(oldSizesArray[1])+10+\"px\"}, \"slow\").attr(\"href\", href).attr(\"sizes\", \"\").html(oldContent).css(\"z-index\", \"2\");\n";
	echo "if(href.substr(10, 3) == \"img\") { \n";
	echo "$(\"#\"+href+\"Btn\").css(\"background\", \"-webkit-radial-gradient(circle, transparent, #ccc 70%, #ccc 2%)\");\n";
	echo "} \n";
	echo "$(\"#verschenkt_\"+ href.substr(10)).animate({width: parseInt(oldSizesArray[0])+10+\"px\", height: parseInt(oldSizesArray[1])+10+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
	echo "$(\"#\"+ href).animate({width: oldSizesArray[0]+\"px\", height: oldSizesArray[1]+\"px\", left: \"+=140px\", top: \"+=\"+topOffset+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
	echo "} else {\n";
	echo "\n\t\t\t"; // break tab
	echo "var curContent = $(this).html();\n";
	echo "var curWidth = $(\"#\"+href).width();\n";
	echo "var curHeight = $(\"#\"+href).height();\n";
	echo "$(\"#\"+href+\"Btn\").css(\"z-index\", \"399\").css(\"width\", \"30px\").css(\"height\", \"30px\").attr(\"href\", href+\"Close\").attr(\"sizes\", curWidth+\",\"+curHeight).attr(\"content\", curContent).html(\"X\").css(\"background-color\", \"rgba(204, 204, 204, 0.80)\");\n";
	echo "$(\"#verschenkt_\"+ href.substr(10)).css(\"z-index\", \"398\").animate({width: \"310px\", height: \"310px\"}, \"slow\");\n";
	echo "$(\"#\"+ href).css(\"z-index\", \"398\").animate({width: \"300px\", height: \"300px\", left: \"-=140px\", top: \"-=\"+topOffset+\"px\"}, \"slow\");\n";
	echo "}\n";
	echo "\n\t\t\t"; // break tab
	echo "\n\t\t"; // break tab
	echo "});";

	//		echo "var artHeight = $(this).height() + 10;\n";
	//		echo "$('.boxBtn').css(\"width\", artWidth).css(\"height\", artHeight);\n";
	echo "</script>";

}
else {
	$login = new Login();
	$loginBox = new Box('loginBox');
	$loginBox->specialfill($login->toString($_GET['wrong_log']) ."<br><br>". Content::$welcome);
	$loginBox->size(500,500);

}
if(!empty($_POST['give']))
	$loading->hide();
?>
<script>
	$('#orderBox').animate({left: "10px"}, "slow");
	$('#navi').animate({left: "10px"}, "slow");
	$('#changeView').animate({left: "100px"}, "slow");
</script>
