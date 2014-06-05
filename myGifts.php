<?php
require_once('includes/order.php');
require_once('box.php');
require_once('gifts.php');
require_once('placeholder.php');
require_once('language/content.php');

if(isset($LOGIN)) {

	echo Content::$myGiftsText .":<br><br>";

	$order = new Order('','','myGifts');
					
	$entryIds = array();
	$articles = array();

	$query = $order->get_entries();
	if(empty($_GET['list'])) {
		if(!empty($query)) {
			for($i=1;$i<=35;$i++) {
				$entry = mysql_fetch_object($query);
				
				array_push($entryIds, $i);
				
				
				if(!empty($entry)) {
					$articles[$i] = new Gifts($entry->id);
					$artBox = new Box('articleBox'. $i);
					$artBox->fill($articles[$i]->toString(''));
					if(substr($entry->pic, 0, 4) == 'http')
						$thumb = "<img src=\"". $entry->pic ."\" alt=\"pic\" style=\"height: 100%;\" />";
					elseif(empty($entry->pic))
						$thumb = formatUmlautsEback($entry->title);
					else
						$thumb = "<img src=\"". $SERVERPATH ."/geschenk_fotos/thumbs/". $entry->pic ."\" alt=\"". $entry->pic ."\" style=\"height: 100%;\" />";
					$artBox->fillBtn($thumb);
				}
				
				$artBox->bColor();
			}
		}
	}
	else {
		$count = mysql_num_rows($query);
		
		if(!empty($query)) {
			$html .= "<div class=\"listBoxDiv\">";
			while($entry = mysql_fetch_object($query)) {
		
				$articles[$entry->id] = new Gifts($entry->id);
				$html .= "<div class=\"listBox\" id=\"listBox_". $entry->id ."\">";
				$html .= $articles[$entry->id]->toString();
				$html .= "</div>";
				array_push($entryIds, $entry->id);
			}
			$html .= "</div>";
		}
		if($count == 0)
			$html .= "<br>". Content::$thereAreNoEntries ."<br>";
		
		$box = new Box('loginBoxIntern');
		$box->specialfill($html);
		
		
		echo "<script>$('#navi').animate({left: \"10px\"}, \"slow\");</script>";
	}


	if(!empty($_POST['give'])) {
		//$articles[$_POST['give']]->give();
		echo "<script language=\"JavaScript\">location.href=\"". $SERVERNAME ."/give/". $_POST['give'] ."\";</script>";
	}
	 // TODO vershcenkt divs werden zu gross
	echo "<script>"; // resize verschenkt divs to fit
		foreach($entryIds as $value) {
			echo "var artWidth = $(\"#articleBox". $value ."\").width() + 10;\n";
			echo "var artHeight = $(\"#articleBox". $value ."\").height() + 10;\n";
			echo "$('#verschenkt_". $value ."').css(\"width\", artWidth).css(\"height\", artHeight);\n";
		}		
	echo "</script>";
	
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
					echo "$(\"#verschenkt_\"+ href.substr(10)).animate({width: parseInt(oldSizesArray[0])+10+\"px\", height: parseInt(oldSizesArray[1])+10+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
					echo "$(\"#\"+ href).animate({width: oldSizesArray[0]+\"px\", height: oldSizesArray[1]+\"px\", left: \"+=140px\", top: \"+=\"+topOffset+\"px\"}, \"slow\").css(\"z-index\", \"1\");\n";
				echo "} else {\n";
					echo "\n\t\t\t"; // break tab
					echo "var curContent = $(this).html();\n";
					echo "var curWidth = $(\"#\"+href).width();\n";
					echo "var curHeight = $(\"#\"+href).height();\n"; 
					echo "$(\"#\"+href+\"Btn\").css(\"z-index\", \"399\").css(\"width\", \"30px\").css(\"height\", \"30px\").attr(\"href\", href+\"Close\").attr(\"sizes\", curWidth+\",\"+curHeight).attr(\"content\", curContent).html(\"X\");\n";
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
else 
	echo "<script>location.href=\"". $SERVERPATH ."\";</script>";
?>
<script>
var list = document.getElementsByClassName("verschenktID");
for (var i = 0; i < list.length; i++) {
    list[i].style.display = 'none';
}
</script>