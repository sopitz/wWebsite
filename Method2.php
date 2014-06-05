<?php
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);

require_once(ROOT_DIR .'/css/methodStyle.php');
require_once(ROOT_DIR .'/js/jquery.html');
require_once(ROOT_DIR .'/js/method.html');
require_once(ROOT_DIR .'/language/content.php');

class Method2 {
	
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
			$this->html .= "<input type=\"checkbox\" name=\"del\" class=\"deleteCheckbox\" ref=\"deleteButton_". $id ."\" />";
		//	$this->html .= "<div id=\"deleteButton_". $id ."\" class=\"delLayer\"></div>";
			$this->html .= "<input type=\"hidden\" name=\"key_". $id ."\" value=\"". $id ."\" />";
			$this->html .= "<input type=\"submit\" value=\"". Content::$deleteBtn ."\" />";
		$this->html .= "</form>";
		
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
	* @desc create formButton with value 'id' --> onclick: 'class'->'function'('on'||'off', $id)
	*/
	function statusButton($class, $function, $id, $status, $amount, $statInt, $file='') {
		if(empty($file))
			$file = $class;
		if($amount == 0)
			$amount = 1;
		
	$this->html .= "<div class=\"statusFormDiv\"><span style=\"cursor: pointer;\" class=\"edit\">". Content::$edit ."</span>";
		
		$this->html .= "<form method=\"post\" class=\"statusForm\" style=\"display: none;\">";
			
			$this->html .= "<select name=\"editStatus\">";
				$this->html .= "<option value=\"2\" >zugesagt</option>";
				$this->html .= "<option value=\"1\" >abgesagt</option>";
			$this->html .= "</select>";
			
			$this->html .= "Anzahl:<input type=\"text\" maxlength=\"2\" style=\"width: 20px\" size=\"2\" name=\"amount\" value=\"". $amount ."\" />";
			$this->html .= "<input type=\"hidden\" name=\"statuskey_". $id ."\" value=\"". $id ."\" />";
			$this->html .= "<input type=\"submit\" value=\"". Content::$insertBtn ."\" />";
		$this->html .= "</form>";
		
	$this->html .= "</div>";
		if(!empty($_POST['statuskey_'. $id .''])) {
			$amount = $_POST['amount'];
			if($_POST['editStatus'] == 1)
				$amount = 0;
			require_once(ROOT_DIR .'/'. $file .'.php');
			$class = ucfirst($class);
		//	$class::$function($_POST['edit'], $id, $stat, $_POST['amount']);
			$class::$function($id, $_POST['editStatus'], $amount);
		}
/*
		echo "<script>
		$('#statusFormDiv_". $id ."').click(function() {
		
			$('#statusForm_". $id ."').slideDown();
			$('#statusFormDiv_". $id ."').hide();
			});
		</script>";
	*/	
		return $this->html;
	}
}

?>