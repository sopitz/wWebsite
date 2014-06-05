<?php
include '../includes/config.php';

	if(isset($_GET['delImg'])) {
		$delFromContentFotos = mysql_query("DELETE FROM content_fotos WHERE id LIKE '". $_GET['delImg'] ."'");
		echo "<script language=\"JavaScript\">location.href=\"uploadedFotos.php?s=". isset($_GET['s']) ."\";</script>";
	}
	
	
	$count = 0;

	$getUploadedFotos = mysql_query("SELECT * FROM content_fotos ORDER BY id DESC");
	while($foto = mysql_fetch_object($getUploadedFotos)) {
		echo "<div style=\"float: left;border: 1px dashed #000;padding: 2px;margin: 2px;\">";
			echo "<img style=\"cursor: pointer;\" src=\"". $SERVERNAME ."/content_fotos/". $foto->content_id ."/". $foto->pic ."\" width='80' onclick=\"parent.document.getElementById('insertImgUrl').value = '". $SERVERNAME ."/content_fotos/". $foto->content_id ."/". $foto->pic ."';parent.document.getElementById('setPic').style.display = 'none';\" />";
			echo "<a target=\"_self\" style=\"position: absolute;margin-left: -12px;vertical-align: top;\" href=\"uploadedFotos.php?s=". isset($_GET['s']) ."&delImg=". $foto->id ."\"><img style=\"vertical-align: top;\" src=\"". $SERVERPATH ."/images/delete.png\" /></a>";
		echo "</div>";
		if($count % 4 == 1)
			echo "<div style=\"clear: left;\"></div>";
	}
?>