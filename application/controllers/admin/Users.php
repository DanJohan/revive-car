<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users extends CI_Controller {

		public function __construct(){
			parent::__construct();
			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
			   redirect('admin/auth/login'); //redirect to login page
			} 
			$this->load->model('CarModel');
			$this->load->model('UserModel');
		}
 
		public function index(){
			$data['all_users'] =  $this->UserModel->get_all(array('name !='=>'','email !='=>''),array('id','desc'));
			$data['view'] = 'admin/users/user_list';
			$this->load->view('admin/layout', $data);
		}
	
		public function edit($id = null){
			if(!$id){
				redirect('admin/users');
			}

			if($this->input->post('submit')){
				$this->form_validation->set_rules('name', 'Username', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('phone', 'Number', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->UserModel->get(array('id'=>$id));
					redirect(base_url('admin/users/edit/'.$id));
				}
				else{
					$phone= $this->input->post('phone');
					$phone = "+91".$phone;
					$email = $this->input->post('email');
				    $userPhoneInfo =	$this->UserModel->checkPhoneExistsExcept($id,$phone);

				    $userEmailInfo =	$this->UserModel->checkEmailExistsExcept($id,$email);
				    if(!$userPhoneInfo && !$userEmailInfo) {
						$data = array(
							'name' => $this->input->post('name'),
							'email' => $this->input->post('email'),
							'phone' => ($this->input->post('phone'))?'+91'.$this->input->post('phone'):'',
						);
						//$data = $this->security->xss_clean($data);
						$result = $this->UserModel->update($data, array('id'=>$id));
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/users'));
					}else{
						$errors ='';
						if(!empty($userPhoneInfo)){
							$errors .= "<p>Phone number already exists</p>";
						}
						if(!empty($userEmailInfo)){
							$errors .= "<p>Email already exists</p>";
						}
						$this->session->set_flashdata('validation_error',$errors);
						redirect(base_url('admin/users/edit/'.$id));
					}
					
				}
			}
			else{
				$data['user'] = $this->UserModel->get(array('id'=>$id));
				$data['user']['phone'] = substr($data['user']['phone'],-10);
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('admin/layout', $data);
			}
		}
		public function show($id){
			$data=array();
			$criteria['field'] = 'id,phone,name,email,profile_image';
			$criteria['conditions'] = array('id'=>$id);
			$criteria['returnType'] = 'single';
			$data['user'] =  $this->UserModel->search($criteria);
			$data['cars'] = $this->CarModel->getCarWithUserByUserId($id);
			$data['view'] = 'admin/users/user_view';
			$this->load->view('admin/layout',$data);
		  }
			
		public function del($id = null){
			if(!id){
				redirect('admin/users');
			}
			$this->UserModel->delete(array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/users'));
		}

		/*public function carList(){
			$data['cars'] = $this->CarModel->getAllCarsWithUsers();
			$data['view'] = 'admin/car/car_list';
			$this->load->view('admin/layout', $data);
		}*/

	}


?>