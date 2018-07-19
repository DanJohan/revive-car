<?php
	class User_model extends CI_Model{

		public function get_all_users(){
			$query = $this->db->get('users');
			return $result = $query->result_array();
		}

		public function get_user_by_id($id){
			$query = $this->db->get_where('users', array('id' => $id));
			return $result = $query->row_array();
		}

	}

?>