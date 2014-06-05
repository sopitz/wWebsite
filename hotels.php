<?php

require_once('language/content.php');
require_once('includes/orderHotels.php');
require_once('box.php');
require_once('login.php');
require_once('class.accomodation.php');
require_once('includes/loading.php');
echo "<link rel=\"stylesheet\" href=\"css/style.php\" media=\"screen\" type=\"text/css\">";

if(isset($LOGIN)) {

	$order = new OrderHotels();
	
	$entryIds = array();
	$articles = array();


	$query = $order->get_entries();
	$count = mysql_num_rows($query);
	//echo "K: ". $order->get_entriesString();
	$html .= "<h2>". Content::$hotels ."</h2>: ". $order->foundEntries() ."<br><br>";
	
	if($count == 0)
		$html .= "<br>". Content::$thereAreNoEntries ."<br>";
	
	if(!empty($query)) {
		$html .= "<div class=\"listBoxDiv\">";
		while($entry = mysql_fetch_object($query)) {

			$articles[$entry->id] = new Accomodation($entry->id);
			$html .= "<div class=\"listBox\" id=\"listBox_". $entry->id ."\">";
			$html .= $articles[$entry->id]->toString();
			$html .= "</div>";
			array_push($entryIds, $entry->id);		
		}
		$html .= "</div>";
	}
	
	$box = new Box('loginBoxIntern');
	$box->specialfill($html);
	
	// private Housing 
	$privateHousing = "<h2>". Content::$privateHousingTitle ."</h2><br>";
	$privateHousing .= Content::$privateHousingText ."<br>". Content::$privateHousingText2 ."<br><span style=\"line-height: 25pt;\"><a href=\"mailto:". Content::$email ."\">". Content::$email ."</a></span><br>". Content::$privateHousingFlug;
	$privateHousingBox = new Box('privateHousingBox');
	$privateHousingBox->specialfill($privateHousing);
	$privateHousingBox->css('position','absolute');
	$privateHousingBox->css('left','10px');
	$privateHousingBox->css('top','0px');
	$privateHousingBox->size('400','200');
	

	foreach($entryIds as $id) {
		echo "<script>
				var boxHeight = $('#listBox_". $id ."').outerHeight(); 
				$('#verschenkt_". $id ."').css({height: boxHeight, margin: \"-10px\", padding: \"0px 10px 0px 10px\"}); 
		</script>";
	}


}
else {
	echo "<script>location.href=\"". $SERVERPATH ."\";</script>";
}
?>
<script>
	$('#orderBox').animate({left: "10px"}, "slow");
	$('#navi').animate({left: "10px"}, "slow");
</script>
