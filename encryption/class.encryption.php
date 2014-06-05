<?php
/**
 * Class to handle data encryption
 *
 * @author		Barry de Kleijn
 * @copyright	MIT License
 *
 * @version		0.5.0
 */
class encryption {
	const 	VERSION	= '0.5.0';

	/**
	 * Class constructor
	 * 
	 * @access	public
	 * @version	1.0
	 * @since	0.5
	 * 
	 * @return	bool		Successful
	 */
	public function __construct() {
		if(!function_exists('mcrypt_module_open')) {
			echo '<strong>Warning:</strong> mcrypt module is not loaded';
			return false;
		}

		return true;
	}

	/**
     * Class destructor
     *
     * @access  public
     * @version 1.0
     * @since   0.5
     */
    public function __destruct() {
        
    }

	/**
	 * Encrypt data
	 * 
	 * @access	public
	 * @version	1.0
	 * @since	0.5
	 * 
	 * @param	string	$data		Data to encrypt
	 * @param	string	$key		Encryption key
	 * 
	 * @return	string	$encrypted	Encrypted data
	 */
	public function encrypt($data,$key)
    {
        $mc = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$key = substr($key,0,mcrypt_enc_get_key_size($mc));
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($mc), MCRYPT_DEV_URANDOM);
        mcrypt_generic_init($mc,$key,$iv);
        $encrypted = mcrypt_generic($mc,$data);
        mcrypt_generic_deinit($mc);
        return base64_encode($iv.$encrypted);
    }

	/**
	 * Decrypt data
	 * 
	 * @access	public
	 * @version	1.0
	 * @since	0.5
	 * 
	 * @param	string	$data		Data to decrypt
	 * @param	string	$key		Decryption key
	 * 
	 * @return	string	$decrypted	Decrypted data
	 */
    public function decrypt($data,$key)
    {
        $data = base64_decode($data);
        $decrypted = '';
        $mc = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$key = substr($key,0,mcrypt_enc_get_key_size($mc));
        $ivSize = mcrypt_enc_get_iv_size($mc);
        $iv = substr($data,0,$ivSize);
        $data = substr($data,$ivSize);
        if($iv) {
            mcrypt_generic_init($mc,$key,$iv);
            $decrypted = mdecrypt_generic($mc,$data);
        }
        return trim($decrypted);
    }

	/**
	 * get a new random key
	 * 
	 * @access	public
	 * @version 1.0
	 * @since	0.5
	 * 
	 * @return	string	$key	Random generated key
	 */
	public function generateKey() {
		$ks = mcrypt_get_key_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_CBC);
		$key = openssl_random_pseudo_bytes($ks,$strong);
		return $key;
	}

	/**
     * get current class version
     *
     * @access  public
     * @version 1.0
     * @since   0.5
     *
     * @return  string  Current version of this class
     */
    public function getVersion() {
        return self::VERSION;
    }
}
?>