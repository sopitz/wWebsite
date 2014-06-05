<?php
include 'includes/config.php';
header("Content-type: text/css");
?>
html {
	width: 100%;
	height: 100%;
	padding: 0px 0px 0px 0px;
}

body {
	font-family: Arial, sans-serif;
	margin: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
	font-size: 13pt;
	width: 100%;
	height: 100%;
	color: #666;
}

a:link, a:hover, a:active, a:visited {
	text-decoration: none;
	color: #80ad2b;
	font-weight: bold;
}

a[href^="http://"]:not([href*="<? echo $SERVERNAME; ?>"])::after { 
	content:url(<? echo $SERVERNAME; ?>/images/exLink.png); 
}

h1 {
	font-size: 13pt;
	margin: 0px;
}

div#navi ul {
	width: 100%;
	padding: 0px;
	margin: 0px;
}

div#navi li a {
	color: #666;
	font-size: 15pt;
	font-weight: normal;
}

div#navi li a:hover {
	color: #80ad2b;
}

div#main {
	width: 100%;
	height: 100%;
}

div#left {
	position: absolute;
	left: 0px;
	top: 0px;
	height: 72.7%;
	width: 112px;
	background-color: #fff;
}

div#lang {
	position: absolute;
	left: 0px;
	top: 0px;
	z-index: 5;
	padding: 20px 30px;
}

div#navi {
	transform:rotate(-90deg);
	-ms-transform:rotate(-90deg);
	-moz-transform:rotate(-90deg);
	-webkit-transform:rotate(-90deg);
	-o-transform:rotate(-90deg);
	width: 456px;
	height: 20px;
	text-align: right;
	position: absolute;
	top: 200px;
	margin: 20px 0px 0px -140px;
	color: #666;
	padding: 0px 8px 3px 5px;
	z-index: 2;
}


div#content_box {
	width: 650px;
	height: 800px;
	overflow: hidden;
}

hr#header {
	position: absolute;
	top: 105px;
	width: 60%;
	height: 1px;
	background-color: #80ad2b; 
	color: #80ad2b;
	border: 0px solid #80ad2b;
	z-index: 4;
	left: 200px;
	background: -webkit-gradient(linear, left top, right top, from(#80ad2b), to(#ffffff));
	background: -webkit-linear-gradient(left, #80ad2b, #fff);
	background: -moz-linear-gradient(left, #80ad2b, #fff);
	background: -ms-linear-gradient(left, #80ad2b, #fff);
	background: -o-linear-gradient(left, #80ad2b, #fff);
}

.left {
	min-width: 200px;
}

.right {

}

div#footer {
	width: 100%;
	height: 27%;
	min-height: 50px;
	z-index: 2;
	background-color: #ccc;	
	box-shadow: 2px 0px 5px #666;
}

li {
	list-style: none;
	display: inline-block;
	margin: 0px 5px 0px 5px;
}

img {
	border: 0px solid transparent;
}

img#pixelitos_logo {
	position: absolute;
	right: 0px;
	margin: -186px 0px 0px 0px;
	z-index: 3;
}

img#logo_img {
	position: absolute;
	right: 580px;
	margin: -143px 0px 0px 0px;
	z-index: 3;
	display: none;
}

div#tmg {
	background-image: url(<? echo $SERVERPATH; ?>/images/TMG.png);
	background-position: top left;
	background-repeat: no-repeat;
	width: 230px;
	height: 160px;
}

.hidden {
	visibility: hidden;
}