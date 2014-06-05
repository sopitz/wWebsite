<?php

require_once('includes/config.php');


class placeholder {
	
	private static $picIds = array('.','..');
	private $html;
	
	function __construct() {
		
		$rDir = dir (getcwd() .'/placeholder');

		$possiblePicIds = array ();

		while( false !== ( $strEntry = $rDir->read () ) ) {
				$possiblePicIds[] = $strEntry;
		}
		$rDir->close ();

		$c = 1;
		
		while(!$break) {		
			$c++;
			shuffle($possiblePicIds);
			
			$newPic = $possiblePicIds[0];
	
			if(!in_array($newPic, Placeholder::$picIds)) {
				array_push(Placeholder::$picIds, $newPic);	
				if($newPic != '.' AND $newPic != '..')
					$break = true;
			}		
			if($c == count($possiblePicIds)) {
				Placeholder::$picIds = array('.','..');
				array_push(Placeholder::$picIds, $newPic);
				if($newPic != '.' AND $newPic != '..')
					$break = true;
			}
		}
		
		$this->html = "<img src=\"". SERVER ."/placeholder/". $newPic ."\" style=\"height: 115%;margin: -10px;\"/>";
	}
	
	function __toString() {
		return $this->html;
	}
}
?>