<?php
require_once('class.encryption.php');
require_once('key.php');

class Autoload {

	private $key2 = "SKldhjdbfcm";
	private $KEY;
	private $encryption;
	
	public function __construct() {
		$this->encryption = new encryption();
		$encryptedKey = new Key();
		$this->KEY = $this->encryption->decrypt($encryptedKey->getKey(),$this->key2);
	}
	
	public function getKey() {
		return $this->KEY;
	}
	
	public function encrypt($data) {
		return $this->encryption->encrypt($data,$this->KEY);
	}
	
	public function decrypt($data) {
		return $this->encryption->decrypt($data,$this->KEY);
	}
}
?>