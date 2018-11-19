<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
		} 
		$this->load->model('GalleryModel');

	}

	public function list(){
		$data['gallery_images'] = $this->GalleryModel->get_all();
		//dd($data);
		$this->render('admin/gallery/list',$data);
	}

	public function create() {
		$data = array();
		if($this->input->post('submit')){
			$file_name = '';
			if(isset($_FILES['gallery_image']) && !empty($_FILES['gallery_image']['name'])) {

					$url = FCPATH."uploads/site/";	
					$config['new_name']=true;
					$upload =$this->do_upload('gallery_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
				}
			}else{
				$this->session->set_flashdata('error_msg','Please select a file');
				redirect('admin/gallery/create');
			}
			$register_data = array(
				'title' => $this->input->post('title'),
				'image' => $file_name,
				'created_at' => date('Y:m:d H:i:s')
			);
			$insert_id = $this->GalleryModel->insert($register_data);
			if($insert_id) {
				$this->session->set_flashdata('success_msg','Image uploaded successfully!');
				redirect('admin/gallery/list');
			}else{
				$this->session->set_flashdata('error_msg','Somthing went wrong!');
				redirect('admin/gallery/list');
			}
		}
		$this->render('admin/gallery/create', $data);
	}

	public function delete($id = null,$image) {
		if(!$id) {
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('admin/gallery/list');
		}
		$is_delete = $this->GalleryModel->delete(array('id'=>$id));
		if($is_delete) {
			@unlink(FCPATH.'uploads/site/'.$image);
			$this->session->set_flashdata('success_msg','Image deleted successfully!');		
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong!');
		}
		redirect('admin/gallery/list');
	}
}// end of class
