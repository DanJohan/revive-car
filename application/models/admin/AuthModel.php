<?php
	class AuthModel extends CI_Model{

		public function login($data){
			//$query = $this->db->get_where('users', array('email' => $data['email']));
			$query = $this->db->get_where('admin', array('email' => $data['email']));
			if ($query->num_rows() == 0){
				return false;
			}
			else{
				//Compare the password attempt with the password we have stored.
				$result = $query->row_array();
			    $validPassword = password_verify($data['password'], $result['password']);
			    if($validPassword){
			        return $result = $query->row_array();
			    }
				
			}
		}

		public function change_pwd($data, $id){
			$this->db->where('id', $id);
			//$this->db->update('users', $data);
			$this->db->update('admin', $data);
			return true;
		}

	}

?>