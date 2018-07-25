<?php
	class AuthModel extends CI_Model{

		public function login($data){
		//echo 'mdl';	print_r($data);
			$query = $this->db->get_where('workshop_manager', array('m_email' => $data['m_email']));

			if ($query->num_rows()== 0){

				return false;
			}
			else{
				//Compare the password attempt with the password we have stored.
				$result = $query->row_array();
				//echo strlen($result['m_password']);
				//dd($result);
			    $validPassword = password_verify($data['m_password'], $result['m_password']);
				//print_r($result);die;
			    if($validPassword){
					
			        return $result;
					
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