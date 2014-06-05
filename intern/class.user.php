<?php
require_once('Mailer.php');
require_once(ROOT_DIR .'/intern/css/userStyle.php');
require_once(ROOT_DIR .'/intern/js/jquery.html');
require_once(ROOT_DIR .'/encryption/autoload.php');
require_once(ROOT_DIR .'/Method.php');
require_once(ROOT_DIR .'/Method2.php');

class User {

	private $html;
	
	function __construct() {
		
		$this->html = "<h1>Userverwaltung</h2>";
		
		$this->html .= "<div class=\"subMenu\">";
			$this->html .= "<a href=\"?p=login&a=users\">User- Übersicht</a> | ";
			$this->html .= "<a href=\"?p=login&a=users&b=newUser\">Neuer User</a> | ";
			$this->html .= "<a href=\"?p=login&a=users&b=usergroups\">Usergruppen- Übersicht</a>";
		$this->html .= "</div>";
		
		if(isset($_GET['b'])) {
			$subFunction = $_GET['b'];
			$this->$subFunction();
		}
		else {
			$order = "desc";
			if($_GET['order'] == 'desc')
				$order = "asc";
				
			$this->html .= "<div style=\"float: left;\">";
				$this->html .= "<table id=\"users\">";
					$this->html .= "<tr>";
						$this->html .= "<td id=\"userID\">";
							$this->html .= "<a href=\"?p=login&a=users&setorder=userID&order=". $order ."\">userID</a>";
						$this->html .= "</td>";
						$this->html .= "<td id=\"eMail\">";
							//$this->html .= "<a href=\"?p=login&a=users&setorder=eMail\">eMail</a>";
							$this->html .= "eMail, <a href=\"?p=login&a=users&setorder=eMail&order=". $order ."\">registriert</a>";
						$this->html .= "</td>";
						$this->html .= "<td id=\"lastname\">";
							$this->html .= "Vorname <a href=\"?p=login&a=users&setorder=lastname&order=". $order ."\">Nachname</a>";
						$this->html .= "</td>";
						$this->html .= "<td>";
						//	$this->html .= "<a href=\"?p=login&a=users&setorder=firstLog&order=". $order ."\">";
								$this->html .= "bereits eingeloggt";
						//	$this->html .= "</a>";
						$this->html .= "</td>";
						$this->html .= "<td style=\"min-width: 90px;\">";
							$this->html .= "l&ouml;schen";
						$this->html .= "</td>";
						$this->html .= "<td style=\"min-width: 90px;\">";
							$qAll = mysql_query("SELECT sum(amount) FROM guestlist WHERE status LIKE '2'");
							$rAll = mysql_fetch_array($qAll);
							$this->html .= "<a href=\"?p=login&a=users&setorder=g.status&order=". $order ."\">Status</a>";
							$this->html .= " <span style=\"color: green;\">(". $rAll[0] .")</span>";							
						$this->html .= "</td>";						
					$this->html .= "</tr>";
					
				// userID	usergroup	eMail	firstname	lastname	password	firstLog
				
				$getSetorder = "id";				
				if(!empty($_GET['setorder']))
					$getSetorder = $_GET['setorder'];
				
				$getOrder = "DESC";				
				if(!empty($_GET['order']))
					$getOrder = strtoupper($_GET['order']);
				
		//		echo "SELECT l.*, g.status FROM login as l, guestlist as g WHERE l.userID=g.userID AND l.usergroup != 'global' ORDER BY ". $getSetorder ." ". $getOrder ."";
								
				$abfrage = mysql_query("SELECT l.*, r.registered, r.password as regPass, g.status, g.amount FROM login as l, registration as r, guestlist as g WHERE l.userID=g.userID AND l.userID=r.userID AND l.usergroup != 'global' ORDER BY ". $getSetorder ." ". $getOrder ."");
				while($row = mysql_fetch_object($abfrage)) {
					$this->html .= "<tr>";
						$this->html .= "<td>";
							$this->html .= $row->userID;
						$this->html .= "</td>";
						$this->html .= "<td>";
						
								$encryption = new Autoload();
								$decryptedMail = addslashes((string)$encryption->decrypt($row->eMail));
						//	if(!empty($this->eMail)) {
								$this->html .= addslashes($decryptedMail);
								
								if(empty($row->eMail)) {
									$this->html .= "Nein, ";
									$sendPW = base64_encode($row->regPass);
									$imgRes = "<img src=\"../intern/imgCreate.php?string=". urlencode($sendPW) ."\" />";
								//	$imgRes = "<img src=\"../intern/imgCreate.php?string=ouögz\" />";
									$this->html .= $imgRes;
								}
						//	}
						$this->html .= "</td>";
						$this->html .= "<td>";
							$this->html .= $row->firstname ." <b>". $row->lastname ."</b>";
						$this->html .= "</td>";
						$this->html .= "<td>";
							if((empty($row->firstLog) AND empty($row->eMail)) OR (!empty($row->firstLog) AND !empty($row->eMail))) {
			
								$this->html .= "Nein";
								
							}
							else
								$this->html .= "Ja";
						$this->html .= "</td>";
						$this->html .= "<td>";
							if($row->usergroup != 'admin') {
						//		if(require_once('Method2.php')) $this->html .= ""; else $this->html .= "inc";
								//if(require_once('t.php')) $this->html .= ""; else $this->html .= "inc";
								$delBtn = new Method2();
								$this->html .= $delBtn->deleteButton('user', 'deleteUser', $row->userID, 'intern/class.user');
							}
							else
								$this->html .= "&nbsp;";
						$this->html .= "</td>";
						$this->html .= "<td>"; // status:  0 = no answer | 1 = abgesagt | 2 = zugesagt
							if($row->usergroup != 'admin') {
								$amount = $row->amount;
								$displayAmount = "";
								if($amount != 0)
									$displayAmount = "(". $amount .")";
								$status = "";
								$newStatus = "zugesagt";
								if($row->status == 1) 
									$status = "<span style=\"color: red;\">abgesagt</span><br>";
								elseif($row->status == 2)
									$status = "<span style=\"color: green;\">zugesagt". $displayAmount ."</span><br>";
								
								if($row->status == 2) {
									$newStatus = "abgesagt";
									$newStatusInt = 1;
								}
								if($row->status == 1) {
									$newStatus = "zugesagt";
									$newStatusInt = 2;
								}
									
								$this->html .= $status;
								
								$formBtn = new Method2();
								//	$class, $function, $id, $status, $amount, $statInt, $file='') {
								$this->html .= $formBtn->statusButton('user', 'editStatus', $row->userID, 'hat '. $newStatus, $amount, $newStatusInt , 'intern/class.user');
							}
							else
								$this->html .= "&nbsp;";
						$this->html .= "</td>";
					$this->html .= "</tr>";
				}
				$this->html .= "</table>";
			$this->html .= "</div>";
		}
		echo "<script>
		$(document).ready(function(){
			$(\".statusFormDiv\").click(function() {
				$(this).children(\".statusForm\").slideDown(\"slow\"); 
				$(this).children(\".edit\").hide(); 
			});
		});
		</script>";
	}
	
	function __toString() {
		return $this->html;
	}
	
	function usergroups() {
		$this->html .= "<div style=\"width: 400px;border: 1px dashed grey;text-align: left;padding: 5px 0px 5px 0px;\">";
			$this->html .= "<form method=\"post\">";
				$this->html .= "<br><b><u>Neue Usergruppe:</u></b><br>";
				$this->html .= "<br>";
				$this->html .= "Name:&nbsp;&nbsp;";
				$this->html .= "<input type=\"text\" name=\"name\">";
				$this->html .= "<input type=\"hidden\" name=\"newUsergroup\" value=\"New\">";
				$this->html .= "<input type=\"submit\" class=\"btn\" value=\"hinzuf&uuml;gen\">";
			$this->html .= "</form>";
		$this->html .= "</div>";
		
		if(!empty($_POST['newUsergroup']) && $_POST['newUsergroup'] == 'New') {
			$this->insertUsergroup();
		}
		
		$this->html .= "<div>";
			$this->html .= "Usergruppen- Übersicht:";
			$this->html .= "<table>";
			
			$usergroups = User::getGroupNames();
			$usergroups = explode(",", $usergroups);
			foreach($usergroups as $name) {
				$this->html .= "<tr>";
				$id = User::getGroupIds($name);
					$this->html .= "<td>";
						if($id != 1) {  // not admin
						//	$delBtn = new Method();
						//	$this->html .= $delBtn->deleteButton('user', 'deleteUsergroup', $id, 'intern/class.user');
						}
						else
							$this->html .= "&nbsp;";
					$this->html .= "</td>";
					$this->html .= "<td>";
						$this->html .= $name ."<br>";
					$this->html .= "</td>";				
				$this->html .= "</tr>";				
			}
			
			$this->html .= "</table>";
		$this->html .= "</div>";
		
		return $this->html;
	}
	
	function newUser() {
		$this->html .= "<div style=\"float: left;border: 1px dashed grey;text-align: left;padding: 5px 0px 5px 0px;\">";
			$this->html .= "<form method=\"post\">";
				$this->html .= "<br><b><u>Neuer User:</u></b><br>";
				$this->html .= "<br>";
				$this->html .= "Vorname:&nbsp;&nbsp;";
				$this->html .= "<input type=\"text\" name=\"fname\">";
			//	$this->html .= "eMail-Adresse:&nbsp;&nbsp;";
			//	$this->html .= "<input type=\"text\" name=\"email\"><br>";
				$this->html .= "Nachname:";
				$this->html .= "<input type=\"text\" name=\"lname\">";
				$this->html .= "Usergroup:&nbsp;&nbsp;";
				$this->html .= "<select class=\"form1\" name=\"group\" size=\"1\">";
					$usergroups = User::getGroupNames();
					$usergroups = explode(",", $usergroups);
					krsort($usergroups);
					foreach($usergroups as $name) {
						$this->html .= "<option>". $name ."</option>";
					}
				$this->html .= "</select>";
				$this->html .= "<input type=\"hidden\" name=\"newUser\" value=\"New\">";
				$this->html .= "<input type=\"submit\" class=\"btn\" value=\"hinzuf&uuml;gen\">";
			$this->html .= "</form>";
		$this->html .= "</div>";
		
		if(!empty($_POST['newUser']) && $_POST['newUser'] == 'New') {
			$this->insertUser();
		}
		
		return $this->html;
		
		
	}
	
	function InsertUser() {
		
	//	$email = strtolower($_POST['email']);
	//	$emailMd5 = md5(strtolower($email));
		$group = $_POST['group'];
							
		$password = $this->createPassword();			
		$notSet = 0;
		while($notSet == 0) {
			$charsUserID = "0123456789";
			$tmpUserID = substr( str_shuffle( $charsUserID ), 0, 8 );
						
			$getUserIDs = mysql_num_rows(mysql_query("SELECT * FROM login WHERE userID LIKE '". $tmpUserID ."'"));
			if($getUserIDs < 1) {
				$notSet = 1;
				$newUserID = $tmpUserID;
			}
		}
		// userID	usergroup	eMail	firstname	lastname	password	firstLog
		$encryption = new Autoload();
			
		$indertIntoLogin = mysql_query("INSERT INTO login (userID, usergroup, firstname, lastname) VALUES ('". $newUserID ."', '". $group ."', '". $_POST['fname'] ."', '". $_POST['lname'] ."')");
			
		$insertIntoRegistration = mysql_query("INSERT INTO registration (userID, lastname, password, registered) VALUES ('". $newUserID ."', '". $_POST['lname'] ."', '". $password ."', 'no')");
			
		$insertIntoGuestlist = mysql_query("INSERT INTO guestlist (userID, date, status) VALUES ('". $newUserID ."', NOW(''), '0')");
							
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=users\";</script>";
	
	}
	
	function InsertUsergroup() {
		
		$eintrag = mysql_query("INSERT INTO usergroups (name) VALUES ('". $_POST['name'] ."')");
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=users&b=usergroups\";</script>";			
	}

	function deleteUser($delete, $userID) {
		if($delete == 'on')
			$delDbEntry = mysql_query("DELETE FROM login WHERE userID LIKE '". $userID ."'");
			$delRegistrationEntry = mysql_query("DELETE FROM registration WHERE userID LIKE '". $userID ."'");
			$delGuestlistEntry = mysql_query("DELETE FROM guestlist WHERE userID LIKE '". $userID ."'");
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=users\";</script>";	
	}
	
	function editStatus($userID, $newStatus, $newAmount) {
		$updGuestlist = mysql_query("UPDATE guestlist SET status='". $newStatus ."', amount='". $newAmount ."' WHERE userID LIKE '". $userID ."'");
		
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=users&setorder=". $_GET['setorder'] ."&order=". $_GET['order'] ."&ediit=yes\";</script>";	
	}
	
	function deleteUsergroup($delete, $id) {
		if($delete == 'on')
			$delDbEntry = mysql_query("DELETE FROM usergroups WHERE id LIKE '". $id ."'");
		echo "<script language=\"JavaScript\">location.href=\"?p=login&a=users&b=usergroups\";</script>";	
	}
	
	static function getGroupNames($ids = 0) {
		$html = "";
		
		$getGroups = mysql_query("SELECT * FROM usergroups ORDER BY id ASC");					
		while($group = mysql_fetch_object($getGroups)) {
			if($ids != 0) {
				if(strpos($ids, $group->id) !== false)
					$html .= $group->name .",";
			}
			else
				$html .= $group->name .",";
		}
		$html = substr($html, 0, -1);
		return $html;
	}
	
	static function getGroupIds($names = '') {
		$html = "";
		
		$getGroups = mysql_query("SELECT * FROM usergroups ORDER BY id ASC");					
		while($group = mysql_fetch_object($getGroups)) {
			if(!empty($names)) {
				if(strpos($names, $group->name) !== false)
					$html .= $group->id .",";
			}
			else
				$html .= $group->id .",";
		}
		$html = substr($html, 0, -1);
		return $html;
	}

	function createPassword($length = 7) {
		$charsPassword = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		$password = substr( str_shuffle( $charsPassword ), 0, $length - 1 );
		
		return $password;
	}
}
?>