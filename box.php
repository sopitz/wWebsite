<?php
//require_once('index.php');
require_once('includes/config.php');

class Box {
	
	private $bColor;
	private $width;
	private $height;
	private $content;
	private $id;
	private $top;
	private $left;
	private static $positions = array();
	
	
	/**
	* @param $id, boxBtn=true
	* @desc if boxBtn == true: radial gradient layer
	*/
	function __construct($id, $boxBtn = true) {
		
		$this->id = $id;
		echo "<div class=\"box";
		if(!$boxBtn)
			echo " placeholder";
		echo "\" id=\"". $this->id ."\">";
		echo "<div class=\"boxBtn";
		if(!$boxBtn)
			echo " PlaceholderBtn";
		echo "\" id=\"". $this->id ."Btn\" href=\"". $this->id ."\"></div>";
		echo "</div>";
	}
		
	function fill($content) {
		$this->position();
		echo "<script>";
			echo "var currentContent = $('#". $this->id ."').html();";
			echo "$('#". $this->id ."').html(currentContent + '". $content ."');"; 
		echo "</script>";
	}
		
	function fillBtn($content) {
		echo "<script>";
		//	echo "$('#". $this->id ."Btn').html('<div><div>". $content ."</div></div>');"; 
			echo "$('#". $this->id ."Btn').html('". $content."');"; 
		echo "</script>";
	}
	
	function specialfill($content) {
		echo "<script>";
			echo "$('#". $this->id ."').html('". $content ."');"; 
		echo "</script>";
	}
	
	function bColor($bColor = 'random') {
		
		switch($bColor) {
			case "green": $this->bColor = "rgb(128, 173, 43)"; break;
			case "orange": $this->bColor = "rgb(207, 156, 24)"; break;
			case "random": 
				$colors = array("green", "orange", "grey", "white");
				shuffle($colors);
				switch($colors[0]) {
					case "green": $this->bColor = "rgb(128, 173, 43)"; break;
					case "orange": $this->bColor = "rgb(207, 156, 24)"; break;
					case "white": $this->bColor = "white"; break;
					default: $this->bColor = "grey"; break;
				}
			break;
			default: $this->bColor = $bColor;
		}
		echo "<script>";
			echo "$('#". $this->id ."').css(\"border-color\", \"". $this->bColor ."\");"; 
		echo "</script>";
	}
	
	function size($width, $height) {
		
		$this->width = $width ."px";
		$this->height = $height ."px";		
		
		echo "<script>";
			echo "$('#". $this->id ."').css(\"width\", \"". $this->width ."\").css(\"height\", \"". $this->height ."\");"; 
		echo "</script>";
	}
	
	function css($key, $value) {
		
		echo "<script>";
			echo "$('#". $this->id ."').css(\"". $key ."\", \"". $value ."\");"; 
		echo "</script>";
	}
	
	function dragable() {
		echo "<script>";
			echo "var content = $('#". $this->id ."').html();\n"; 
			echo "$('#". $this->id ."').html('<div id=\"drag". $this->id ."\" class=\"dragBox\"></div>' + content);\n"; 
			//echo "$(document).ready(function() { $('#drag". $this->id ."').draggit('#". $this->id ."'); });"; 
			echo "$(function() { $('#". $this->id ."').draggable({ cursor: \"move\", cursorAt: { top: 1, left: 1 } }); });"; 
		echo "</script>";
	}
	
	function position() {
		
		$posArray = array("246:754","161:532","272:449","268:835","377:508","311:936","395:930","473:814","483:680","495:533","153:403","142:853","237:929","615:789","148:704","31:826","45:953","125:1079","240:1039","320:1081","393:1023","509:933","598:869","694:788","684:696","618:615","615:508","485:429","412:362","307:314","221:297","111:315","44:398","29:518","108:621");
		$sizeArray = array("50:50","68:87","153:59","68:62","81:85","98:59","59:68","92:95","95:119","114:75","79:69","156:70","84:50","50:50","95:70","89:92","110:73","65:93","130:57","69:57","78:92","100:67","91:80","95:50","73:91","50:120","70:60","72:100","110:53","101:80","60:62","59:88","97:82","81:85","55:74");
	
		$posSizeArray = array_combine($posArray, $sizeArray);
		

		$break = false;
		$c = 0;
		while(!$break) {		// TODO what happens when there are more items than posArray entries????
			if($c > count($posArray)) {
				shuffle($posArray); 					// shuffle -
				$position = explode(":", $posArray[0]);	// 			mode
			}
			else {
				$position = explode(":", $posArray[$c]);// none-shuffle-mode
			}
			$this->top = $position[0];
			$this->left = $position[1];
			$newCoord = $this->top .":". $this->left;
			$c++;
	
			if(!in_array($newCoord, Box::$positions) || $c > count($posArray)) {
				array_push(Box::$positions, $newCoord);	
				if($c > count($posArray))
					$size = "rand";
				else	
					$size = str_replace(":", ",", $posSizeArray[$newCoord]);
				$break = true;
			}			
		}
		
		echo "<script>";
			echo "$('#". $this->id ."').css(\"top\", \"". $this->top ."px\").css(\"left\", \"". $this->left ."px\").css(\"position\", \"absolute\");"; 
			echo "$('#". $this->id ."Btn').attr(\"top\", \"". $this->top ."\");"; 
		echo "</script>";
		
		$this->setSize($size);
	}
	
	function setSize($sizes) {
		
		if($sizes == 'rand') {
			
			$widths = range(50, 100);
			$heights = range(50, 100);
		
			shuffle($widths);
			shuffle($heights);
				
			$this->width = $widths[0];
			$this->height = $heights[0];	
		}
		else {
			$setSize = explode(",", $sizes);
			$this->width = $setSize[0];
			$this->height = $setSize[1];
		}		
		echo "<script>";
			echo "$('#". $this->id ."').css(\"width\", \"". $this->width ."px\").css(\"height\", \"". $this->height ."px\");"; 
		echo "</script>";
	}
	
	function position_old() {
		$topPositions = range(0, 600, 30);
		$leftPositions = range(200, 800, 30);
	
		$break = false;
		while(!$break) {		
			shuffle($topPositions);
			shuffle($leftPositions);
			
			$this->top = $topPositions[0];
			$this->left = $leftPositions[0];
			
			$newCoord = $this->top .".". $this->left;
			
			if(!in_array($newCoord, Box::$positions)) {
				array_push(Box::$positions, $newCoord);				
				$break = true;
			}			
		}
		echo "<script>";
			echo "$('#". $this->id ."').css(\"top\", \"". $this->top ."px\").css(\"left\", \"". $this->left ."px\").css(\"position\", \"absolute\");"; 
		echo "</script>";
	}
}
?>