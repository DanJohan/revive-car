<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EnquiryImagesModel extends MY_Model {

	protected $table = 'enquiry_images';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getImagesById($ids= array()){
		$this->db->select('id,image');
		$this->db->from($this->table);
		$this->db->where_in('id',$ids);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function updateEnquiryImages($ids,$enquiry_id){
		$this->db->where_in('id',$ids);
		$this->db->update($this->table,array('enquiry_id'=>$enquiry_id));
	}
}
