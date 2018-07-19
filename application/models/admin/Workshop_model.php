<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Workshop_model extends CI_Model {

	protected $table = ' tbl_workshop_manager';

	public function __construct()
	{
	    parent::__construct();
	}

	public function insertManager($data=array()) {

		$this->db->insert('tbl_workshop_manager', $data);
			return true;
	}

	public function viewManager(){
			$query = $this->db->get('tbl_workshop_manager');
			return $result = $query->result_array();
			//print_r($query);die;
		}

		public function viewManagerById($id){
			$query = $this->db->get_where('tbl_workshop_manager', array('id' => $id));
			return $result = $query->row_array();
		}
}
