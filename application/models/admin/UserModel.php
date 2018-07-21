<?php
	class UserModel extends CI_Model{

		public function get_all_users(){
			$query = $this->db->get('users');
			return $result = $query->result_array();
		}

		public function get_user_by_id($id){
			$query = $this->db->get_where('users', array('id' => $id));
			return $result = $query->row_array();
		}
		public function edit($data, $id){
			$this->db->where('id', $id);
			$this->db->update('users', $data);
			return true;
		}
	}

?>