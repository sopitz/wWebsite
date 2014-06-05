<?php
include 'includes/config.php';
header("Content-type: text/css");
?>
table#table_contact {
}

table#table_contact td {
	text-align: left;
}


.homepage_contact {
	display: none;
}

input[type="text"] {
	width: 200px;
	border: 1px solid #aaa;
}

input[type="text"]:hover, input[type="text"]:focus {
	border: 1px solid grey;
}

input[type="text"]:hover {
	
}

textarea {
	vertical-align: text-top;
	width: 350px;
	height: 150px;
}

textarea:hover, textarea:focus {
	border: 1px solid grey;
}

textarea:hover {
	
}

input[type="submit"] {
	background-image: url("<? echo $SERVERNAME; ?>/images/btn.jpg");
    border: 0 none;
    cursor: pointer;
	font-family: Arial, sans-serif;
	font-size: 17px;
    height: 32px;
    margin-top: 15px;
    text-align: center;
    width: 113px;
}
