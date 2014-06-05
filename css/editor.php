<?php
include 'includes/config.php';
header("Content-type: text/css");
?>
  
  h2 {
    margin-bottom: 0;
  }
  
  small {
    display: block;
    margin-top: 40px;
    font-size: 9px;
  }
  
  small,
  small a {
    color: #666;
  }
  
    
  #toolbar [data-wysihtml5-action] {
    float: right;
  }
  
  #toolbar a img {
	border: 1px solid #666;
  }
  
  #toolbar,
  textarea {
    width: 850px;
    padding: 5px;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  
  textarea {
    height: 280px;
    font-family: Verdana;
    font-size: 11px;
  }
  
  textarea:focus {
    color: black;
  }
  
  .wysihtml5-command-active {
    
  }
  
  [data-wysihtml5-dialog] {
    margin: 5px 0 0;
    padding: 5px;
    border: 1px solid #666;
  }
  
  a[data-wysihtml5-command="foreColor"] {
	display: inline-block;
	width: 20px;
	height: 20px;
	border: 1px solid #666;
  }
  
  a[data-wysihtml5-command-value="red"] {
    color: red;
	background-color: red;
  }
  
  a[data-wysihtml5-command-value="blue"] {
    color: rgb(25, 55, 146);
	background-color: rgb(25, 55, 146);
  }
  
  a[data-wysihtml5-command-value="yellow"] {
    color: rgb(248, 233, 0);
	background-color: rgb(248, 233, 0);
  }
  
  a[data-wysihtml5-command-value="white"] {
    color: white;
	background-color: white;
  }