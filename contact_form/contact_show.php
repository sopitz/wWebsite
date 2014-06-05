<?php
$contact_id = $_GET['contact_id'];
$getData = mysql_query("SELECT * FROM contact WHERE id LIKE '". $contact_id ."' ORDER BY id DESC LIMIT 1");
$d = mysql_fetch_array($getData, MYSQL_NUM);
											
	for($i=1;$i<count($d);$i++) {
		echo "
		<div class='left_ContactForm'>
			". ucfirst(mysql_field_name($getData, $i)) .":
		</div>
		<div class='right_ContactForm'>
			". $d[$i] ."
		</div>";
	}
?>