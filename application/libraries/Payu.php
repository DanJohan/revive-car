<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payu {
	private $ci;
	public function __construct(){
		$this->ci =& get_instance();
		$this->ci->config->load('payment');
	}

	public function getHash($params=array()){
		if(!empty($params)) {
			$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
			$hashVarsSeq = explode('|', $hashSequence);
			$hash_string = '';
			foreach($hashVarsSeq as $hash_var) {
			     $hash_string .= isset($params[$hash_var]) ? $params[$hash_var] : '';
			     $hash_string .= '|';
			}
			$hash_string .= $this->ci->config->item('payu_salt');
			$hash = strtolower(hash('sha512', $hash_string));
			return ($hash) ? $hash : false;
		}
		return false;
	}
}

?>