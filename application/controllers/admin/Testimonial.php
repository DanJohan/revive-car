<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
		} 
		$this->load->model('TestimonialModel');

	}

	public function list() {
		$this->render('admin/testimonial/list',array());
	}

	public function ajax_testimonial_list(){
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$order = $this->input->post('order');
		$search = $this->input->post('search');
		$services = $this->TestimonialModel->getTestimonials($start,$limit,$order,$search);
			//echo $this->db->last_query();die;
		$found_rows = $this->TestimonialModel->getFoundRows();
		$this->renderJson(array('draw'=>intval($this->input->post('draw')),'recordsTotal'=>intval($found_rows), 'recordsFiltered' => intval($found_rows),'data'=>$services));
	}

	public function create() {
		$data = array();
		if($this->input->post('submit')){
			$file_name = '';
			if(isset($_FILES['author_image']) && !empty($_FILES['author_image']['name'])) {

					$url = FCPATH."uploads/site/";	
					$config['new_name']=true;
					$upload =$this->do_upload('author_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
				}
			}
			$register_data = array(
				'author_name' => $this->input->post('author_name'),
				'author_designation' => $this->input->post('author_designation'),
				'description' => $this->input->post('author_text'),
				'author_image' => $file_name,
				'created_at' => date('Y-m-d H:i:s')
			);

			$insert_id = $this->TestimonialModel->insert($register_data);
			if($insert_id){
				$this->session->set_flashdata('success_msg','Testimonial created successfully!');
				redirect('admin/testimonial/list');
			}else{
				$this->session->set_flashdata('success_msg','Somthing went wrong!');
				redirect('admin/testimonial/list');
			}
		}
		$this->render('admin/testimonial/create',$data);
	}

	public function edit($id =null) {
		if(!$id){
			$this->session->set_flashdata('error_msg','Not detail found');
			redirect('admin/testimonial/list');
		}

		$testimonial = $this->TestimonialModel->get(array('id'=>$id));

		if(empty($testimonial)){
			$this->session->set_flashdata('error_msg','Not detail found');
			redirect('admin/testimonial/list');
		}
		if($this->input->post('submit')) {

			$file_name = $testimonial['author_image'];
			if(isset($_FILES['author_image']) && !empty($_FILES['author_image']['name'])) {

					$url = FCPATH."uploads/site/";	
					$config['new_name']=true;
					$upload =$this->do_upload('author_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
						@unlink($url.$testimonial['author_image']);
					}
			}
			$edit_data = array(
				'author_name' => $this->input->post('author_name'),
				'author_designation' => $this->input->post('author_designation'),
				'description' => $this->input->post('author_text'),
				'author_image' => $file_name,
			);
			$this->TestimonialModel->update($edit_data,array('id'=>$id));
			$this->session->set_flashdata('success_msg','Testimonial updated successfully');
			redirect('admin/testimonial/edit/'.$id);
		}

		$this->render('admin/testimonial/edit',array(
			'testimonial' => $testimonial,
		));

	}

	public function delete($id = null) {
		if(!$id){
			$this->session->set_flashdata('error_msg','Something went wrong');
			redirect('admin/testimonial/list');
		}
		$testimonial = $this->TestimonialModel->get(array('id'=>$id));

		if(empty($testimonial)){
			$this->session->set_flashdata('error_msg','Not detail found');
			redirect('admin/testimonial/list');
		}

		$is_delete = $this->TestimonialModel->delete(array('id'=>$id));
		if($is_delete) {
			@unlink(FCPATH.'uploads/site/'.$testimonial['author_image']);
			$this->session->set_flashdata('success_msg', 'Testimonial deleted successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong');
			
		}
		redirect('admin/testimonial/list');
	}


}// end of class
