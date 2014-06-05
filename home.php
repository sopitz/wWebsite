<?php
require_once('language/content.php');
if(include_once 'includes/order.php') echo ""; else echo "error order include";
if(require_once('box.php')) echo ""; else echo "error box required";
if(require_once('login.php')) echo ""; else echo "error login required";
if(require_once('gifts.php')) echo ""; else echo "error gifts required";
if(require_once('placeholder.php')) echo ""; else echo "error placeholer required";
if(require_once('includes/loading.php')) echo ""; else echo "error loading required";

if(isset($LOGIN)) {
	
	if(!empty($_POST['give'])) {
		$loading = new Loading();
		echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/give/". $_POST['give'] ."\";</script>";
	}
	
	$order = new Order();
					
	$entryIds = array();
	$articles = array();
	
	
	$query = $order->get_entries();
	
		if(!empty($query)) {
			for($i=1;$i<=35;$i++) {
				$entry = mysql_fetch_object($query);
					
					
					
				if(!empty($entry)) {
					array_push($entryIds, 'article'. $entry->id);
					$articles[$entr] = new Gifts($entry->id);
					$artBox = new Box('articleBox'. 'article'. $entry->id);
					$artBox->fill($articles[$entry_id]->toString(''));
					if(substr($entry->pic, 0, 4) == 'http')
						$thumb = "<img src=\"". $entry->pic ."\" alt=\"pic\" style=\"height: 100%;\" />";
					elseif(empty($entry->pic))
						$thumb = formatUmlautsEback($entry->title);
					else
						$thumb = "<img src=\"". $SERVERPATH ."/geschenk_fotos/thumbs/". $entry->pic ."\" alt=\"". $entry->pic ."\" style=\"height: 100%;\" />";
					$artBox->fillBtn($thumb);
				
				}
				else {
					array_push($entryIds, 'img'. $i);
					$articles[$i] = new Placeholder();
					$artBox = new Box('articleBox'. 'img'. $i, false);
					$artBox->fill($articles[$i]);
				}
					
				$artBox->bColor();
			}
		}
	
	
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
						echo "$(\"#\"+href+\"Btn\").css(\"background\", \"-webkit-radial-gradient(circle, transparent, #fff 70%, #fff 2%)\");\n";
					echo "} \n";
					echo "$(\"#verschenkt_\"+ href.substr(10)).animate({width: parseInt(oldSizesArray[0])+10+\"px\", height: parseInt(oldSizesArray[1])+10+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
					echo "$(\"#\"+ href).animate({width: oldSizesArray[0]+\"px\", height: oldSizesArray[1]+\"px\", left: \"+=140px\", top: \"+=\"+topOffset+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
				echo "} else {\n";
					echo "\n\t\t\t"; // break tab
					echo "var curContent = $(this).html();\n";
					echo "var curWidth = $(\"#\"+href).width();\n";
					echo "var curHeight = $(\"#\"+href).height();\n"; 
					echo "$(\"#\"+href+\"Btn\").css(\"z-index\", \"399\").css(\"width\", \"30px\").css(\"height\", \"30px\").attr(\"href\", href+\"Close\").attr(\"sizes\", curWidth+\",\"+curHeight).attr(\"content\", curContent).html(\"X\").css(\"background-color\", \"rgba(256, 256, 256, 1.00)\");\n";
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
	$loginBox->specialfill($login->toString($_GET['wrong_log']) ."<br><br>". Content::$welcome ." <a href=\"". $SERVERNAME ."/register\">". Content::$register ."</a><br><br>". Content::$welcome2 ."<br><br>". Content::$owner);
	$loginBox->size(500,500);
}
if(!empty($_POST['give']))
	$loading->hide();

?>