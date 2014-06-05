<?php
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);

require_once(ROOT_DIR .'/css/methodStyle.php');
require_once(ROOT_DIR .'/js/jquery.html');
//require_once(ROOT_DIR .'/js/method.html');
require_once(ROOT_DIR .'/language/content.php');

class Method {
	
	private $html;
	
	function __construct() {
		$this->html = "";
	}
	
	/**
	* @param class, function, id, file
	* @desc create deleteButton with value 'id' --> onclick: 'class'->'function'('on'||'off', $id)
	*/
	function deleteButton($class, $function, $id, $file='') {
		if(empty($file))
			$file = $class;
			
		$this->html .= "<form method=\"post\">";
			$this->html .= "<input type=\"checkbox\" name=\"del\" class=\"deleteCheckbox\" id=\"deleteButton_". $id ."\"  />";
	//		$this->html .= "<div id=\"deleteButton_". $id ."\" class=\"delLayer\"></div>";
			$this->html .= "<input type=\"hidden\" name=\"key_". $id ."\" value=\"". $id ."\" />";
			$this->html .= "<input type=\"submit\" value=\"". Content::$deleteBtn ."\" id=\"deleteSubmit_". $id ."\" disabled=\"disabled\" />";
		$this->html .= "</form>";
		
		$this->html .= "<script>
				$('#deleteButton_". $id ."').change(function() {
					
					if($('#deleteSubmit_". $id ."').attr(\"disabled\"))
						$('#deleteSubmit_". $id ."').removeAttr(\"disabled\");
					else
						$('#deleteSubmit_". $id ."').attr(\"disabled\", \"disabled\");
				});	
				</script>";
		
		if(!empty($_POST['key_'. $id .''])) {
			require_once(ROOT_DIR .'/'. $file .'.php');
			$class = ucfirst($class);
			//$delObj = new $class();
			//$delObj->$function($_POST['del'], $id);
			$class::$function($_POST['del'], $id);
		}	
		return $this->html;
	}
	/**
	* @param class, function, id, file
	* @desc create editButton with value 'id' --> onclick: 'class'->'function'('on'||'off', $id)
	*/
	function editButton($class, $function, $id, $file='') {
		if(empty($file))
			$file = $class;
			
		$this->html .= "<form method=\"post\">";
			$this->html .= "<input type=\"checkbox\" name=\"edit\" class=\"editCheckbox\" id=\"editBtn_". $id ."\"  />";
	//		$this->html .= "<div id=\"editBtn_". $id ."\" class=\"editLayer\"></div>";
			$this->html .= "<input type=\"hidden\" name=\"key_". $id ."\" value=\"". $id ."\" />";
			$this->html .= "<input type=\"submit\" value=\"". Content::$reactivateBtn ."\" id=\"editSubmit_". $id ."\" disabled=\"disabled\" />";
		$this->html .= "</form>";
		
		$this->html .= "<script>
				$('#editBtn_". $id ."').change(function() {
					
					if($('#editSubmit_". $id ."').attr(\"disabled\"))
						$('#editSubmit_". $id ."').removeAttr(\"disabled\");
					else
						$('#editSubmit_". $id ."').attr(\"disabled\", \"disabled\");
				});	
				</script>";
		
		if(!empty($_POST['key_'. $id .''])) {
			require_once(ROOT_DIR .'/'. $file .'.php');
			$class = ucfirst($class);
			//$editObj = new $class();
			//$editObj->$function($_POST['edit'], $id);
			$class::$function($_POST['edit'], $id);
		}	
		return $this->html;
	}
	/**
	* @param class, function, id, file
	* @desc create formButton with value 'id' --> onclick: 'class'->'function'('on'||'off', $id)
	*/
	function formButton($class, $function, $id, $value, $file='') {
		if(empty($file))
			$file = $class;
			
		$this->html .= "<form method=\"post\">";
			$this->html .= "<input type=\"checkbox\" name=\"edit\" class=\"editCheckbox\" id=\"editBtn_". $id ."\"  />";
	//		$this->html .= "<div id=\"editBtn_". $id ."\" class=\"editLayer\"></div>";
			$this->html .= "<input type=\"hidden\" name=\"key_". $id ."\" value=\"". $id ."\" />";
			$this->html .= "<input type=\"submit\" value=\"". $value ."\" id=\"editSubmit_". $id ."\" disabled=\"disabled\" />";
		$this->html .= "</form>";
		
		$this->html .= "<script>
				$('#editBtn_". $id ."').change(function() {
					
					if($('#editSubmit_". $id ."').attr(\"disabled\"))
						$('#editSubmit_". $id ."').removeAttr(\"disabled\");
					else
						$('#editSubmit_". $id ."').attr(\"disabled\", \"disabled\");
				});	
				</script>";
		
		if(!empty($_POST['key_'. $id .''])) {
			require_once(ROOT_DIR .'/'. $file .'.php');
			$class = ucfirst($class);
			//$editObj = new $class();
			//$editObj->$function($_POST['edit'], $id);
			$class::$function($_POST['edit'], $id);
		}	
		return $this->html;
	}
}

?>