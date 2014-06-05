<?php
$content_erg[$content_id] = mysql_fetch_object(mysql_query("SELECT * FROM content WHERE content_id LIKE '$content_id' ORDER BY id DESC LIMIT 1"));
$text = format_text($content_erg[$content_id]->content);
echo $text;
echo "<br><br>";
?>