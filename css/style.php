<?php
include '../includes/config.php';
header("Content-type: text/css");
?>
html {
	width: 100%;
	height: 100%;
	padding: 0px 0px 0px 0px;
}

h1 {
	font-size: 14pt;
}

h2 {
	font-size: 13pt;
	display: inline;
}

h3 {
	font-size: 12pt;
}

div {
	
}

img {
	border: 0px solid transparent;
}

input.required, select.required {
	border: 1px solid red;
}

body {
	font-family: "Trebuchet MS", sans-serif;
	background-color: #4d4d4d;
	font-size: 11pt;
	color: #666;
	background: radial-gradient(#eee, #666);
}

div#loading {
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 80%;
	z-index: 1000;
	background-color: rgba(75, 75, 75, 0.3);
	text-align: center;
	padding-top: 20%;
}

div.box {
	border-width:2px;
	padding: 5px; 
	border-style: solid;
	border-radius: 15px;
	box-shadow: 0px 0px 10px white;
	background-color: white;
	width: 200px;
	height: 200px;
	display: inline-block;
	overflow: hidden;
}

div.placeholder {
	background-color: white;
}

div.boxBtn {
	position: absolute;
/*	background-color: rgba(204, 204, 204, 0.80); */
	background-color: white;
	border-radius: 15px;
	margin: -5px 0px 0px -5px;
	width: inherit;
	height: inherit;
	cursor: pointer;
	z-index: 100;
/*	font-weight: bolder; */
	padding: 5px; 
	text-align: center;
	font-weight: bold;
}

div.PlaceholderBtn {
	background: -webkit-radial-gradient(circle, transparent, #fff 70%, #fff 2%);
}

div.boxBtn div {
/*	padding-top: 50%; */
	height: inherit;
}

div.boxBtn div div {
	position: absolute;
	padding: 0px;
	margin-top: -15px;
	height: 30px
}

div.boxBtn img {
	max-width: inherit;
	max-height: inherit;
}

div.dragBox {
	cursor: move;
	position: absolute;
	float: left;
	width: 10px;
	height: 10px;
	background-image: url('<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/move.gif');
	background-repeat: no-repeat;
	background-position: center center;
}


a {
	color: black;
	text-decoration: none;
}

a:hover {
	color: grey;
}

#all {
	width: 600px;
	height: 300px;
}

div#main {
	width: 100%;
	height: 100%;
	min-height: 600px;
	text-align: center;
}

div#pixelitos {
	position: fixed;
	right: 5px;
	bottom: 5px;
	width: 100px;
	height: 110px;
	z-index: 200;
	cursor: pointer;
	background-image: url('<?php echo $SERVERPATH; ?>/images/logo_negativ.png');
	background-repeat: no-repeat;
	background-position: right bottom;
}

div#main div {
	
}

div#navi {
	width: 70px;
	height: 100px;
	position: absolute;
	left: 630px;
	top: 221px;
	z-index: 2;
}

div#welcome {
	width: 500px;
	height: 300px;
	position: absolute;
	left: 50px;
	top: 57px;
}

div#orderBox {
	width: 300px;
	height: 100px;
	border-color: rgb(207, 156, 24);
	position: absolute;
	left: 609px;
	top: 350px;
	z-index: 2;
}

div#changeView {
	position: absolute;
	left: 720px;
	top: 312px;
	text-align: center;
}

div#loginBox, div#loginBoxIntern {
	left: 32%;
	top: 10%;
	position: absolute;
	z-index: 401;
}

div#loginBox input[type=text], div#loginBox input[type=password] {
	text-align: center;
}

div#loginBoxIntern {
	z-index: 402;
	width: 540px;
	height: 80%;
	padding-bottom: 40px;
}

div#giftBox {
	width: 500px;
	height: 600px;
	font-size: 12pt;
}

div.listBoxDiv {
	height: 100%;
	overflow-y: scroll;
}

div.editableBox, div.listBox {
	border: 1px solid grey;
	padding: 10px;
	margin: 10px 0px 10px 0px;
	text-align: left;
	min-height: 100px;
}

div.listBox {
	width: 500px;
	border-radius: 15px;
}

div.editBox {
	border-width:2px;
	padding: 5px; 
	border-style: solid;
	border-radius: 15px;
	box-shadow: 0px 0px 10px white;
	background-color: white;
	width: 850px;
	height: 550px;
	display: inline-block;
	overflow: hidden;
}

div#content_box {
	box-shadow: 0px 2px 3px #ff9900;
	margin-bottom: 20px;
	text-align: center;
}

div#content {
	min-height: 300px;
	width: 730px;
	padding: 10px;
}

div.article {
	width: inherit;
	height: inherit;
}

div.verschenkt, div.verschenktID {
	background-image: url('<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/verschenkt.png');
	background-repeat: no-repeat;
	background-position: center center;
	position: absolute;
	background-color: rgba(204, 204, 204, 0.67);
	border-radius: 15px;
	margin: -5px 0px 0px -5px;
	width: inherit;
	height: inherit;
	padding: 5px; 
}


div.verschenktID {
	background-image: url('<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/verschenktID.png');	
}

div.verschenktList, div.verschenktIDList {
	background-image: url('<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/verschenkt.png');
	background-repeat: no-repeat;
	background-position: 50%;
}

div.verschenktIDList {
	background-image: url('<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/verschenktID.png');
}

div.entryImg img {
	width: 90px;
	max-height: 100px;
}

div.entryImgDetail img {
	max-height: 500px;
	max-width: 400px;
}

.btnForm {
	display: inline;
}

.btnSchenken {
	background-image: url("<?php if(!empty($SERVERPATH)) echo $SERVERPATH; ?>/images/btn.jpg");
	background-repeat: no-repeat;
	border: 0 none;
	cursor: pointer;
	font: 11pt Arial, sans-serif;
	display: inline-block;
	height: 32px;
	padding-top: 5px;
	text-align: center;
	width: 113px;
	color: #666;
	letter-spacing: 1pt;
}

div#articleDetail {
	overflow-y: auto;
	height: 100%;
}

table#users {
}

table#users td {
	padding: 2px 4px 2px 4px;
	border: 1px solid black;
}

div.thisImg img {
	max-width: 90px;
	padding: 10px 0px 10px 0px;
}


