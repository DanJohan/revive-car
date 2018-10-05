<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
  function __construct($config = array())
  {
    parent::__construct($config);
  }

  function error_array()
  {
    if (count($this->_error_array) === 0)
      return FALSE;
    else
      return $this->_error_array;
  }

  function get_errors(){
  	if (count($this->_error_array) === 0){
      return FALSE;
  	}else{
  		$errors = array();
  		$i = 0;
      	foreach ($this->_error_array as $key => $value) {
      		$errors[$i]['field']=$key;
      		$errors[$i]['error']=$value;
      		$i++;
      	}
      	return $errors;
  	}
  }
}
