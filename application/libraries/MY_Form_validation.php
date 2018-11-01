<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	private $ci;

	 function __construct($config = array())
	 {
	    parent::__construct($config);
	    $this->ci = & get_instance();

	 }

	public function error_array()
	{
	    if (count($this->_error_array) === 0)
	      return FALSE;
	    else
	      return $this->_error_array;
	 }

	public function is_unique_update($str, $field){
		//echo $str,'-',$field;
	    	 $explode=explode('@', $field);
	      $field_name=$explode['0'];
	      $field_id_key=$explode['1'];
	      $field_id_value=$explode['2'];
	      sscanf($field_name, '%[^.].%[^.]', $table, $field_name);

	     if(isset($this->ci->db)){

               if($this->ci->db->limit(1)->get_where($table, array($field_name => $str,$field_id_key=>$field_id_value))->num_rows() === 0){
               	echo $this->ci->db->last_query();
                   $this->ci->form_validation->set_message('is_unique_update', 'The {field} field must contain a unique value.');
                  return false;
      		}
	          return true;
	     }
	
     }// end of is_unique_update method


}
