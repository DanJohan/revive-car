<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
		} 
		$this->load->model('BlogModel');

	}

	public function list(){
		$data = array();
		$this->render('admin/blog/list',$data);
	}

	public function ajax_blog_list() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$order = $this->input->post('order');
		$search = $this->input->post('search');
		$services = $this->BlogModel->getBlogs($start,$limit,$order,$search);
			//echo $this->db->last_query();die;
		$found_rows = $this->BlogModel->getFoundRows();
		$this->renderJson(array('draw'=>intval($this->input->post('draw')),'recordsTotal'=>intval($found_rows), 'recordsFiltered' => intval($found_rows),'data'=>$services));
	}

	public function create(){
		$data = array();
		if($this->input->post('submit')) {
			$slug = slugit($this->input->post('title'));
			$is_exists = $this->BlogModel->checkSlugExists($slug);
			$inc_num = 1;
			while($is_exists){
				$slug = $slug.'-'.$inc_num;
				$is_exists = $this->BlogModel->checkSlugExists($slug);
				$inc_num ++;
			}
			$file_name = '';
			if(isset($_FILES['blog_image']) && !empty($_FILES['blog_image']['name'])) {

					$url = FCPATH."uploads/site/";	
					$config['new_name']=true;
					$upload =$this->do_upload('blog_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
				}
			}

			$register_data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'description' => $this->input->post('description'),
				'image' => $file_name,
				'created_at' => date('Y-m-d H:i:s')
			);

			$insert_id = $this->BlogModel->insert($register_data);
			if($insert_id){
				$this->session->set_flashdata('success_msg','Blog created successfully!');
				redirect('admin/blog/list');
			}else{
				$this->session->set_flashdata('success_msg','Blog created successfully!');
				redirect('admin/blog/list');
			}


		}
		$this->render('admin/blog/create',$data);
	}

	public function show($id = null) {
		if(!$id){
			show_error('No detail found!',404);
		}
		$blog=$this->BlogModel->get(array('id'=>$id));
		//dd($job_card);
		if(empty($blog)){
			log_message('debug',"No detail found for ".$id);
			show_error('No detail found!',404);
		}

		$this->render('admin/blog/show',array(
			'blog' => $blog,
		));
	}

	public function edit($id = null) {
		if(!$id){
			show_error('No detail found!',404);
		}
		$blog=$this->BlogModel->get(array('id'=>$id));
		//dd($job_card);
		if(empty($blog)){
			log_message('debug',"No detail found for ".$id);
			show_error('No detail found!',404);
		}

		if($this->input->post('submit')) {

			$slug = slugit($this->input->post('title'));
			$is_exists = $this->BlogModel->checkSlugExistsExcept($slug,$id);
			$inc_num = 1;
			while($is_exists){
				$slug = $slug.'-'.$inc_num;
				$is_exists = $this->BlogModel->checkSlugExistsExcept($slug,$id);
				$inc_num ++;
			}

			$file_name = $blog['image'];
			if(isset($_FILES['blog_image']) && !empty($_FILES['blog_image']['name'])) {

					$url = FCPATH."uploads/site/";	
					$config['new_name']=true;
					$upload =$this->do_upload('blog_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
						@unlink($url.$blog['image']);
					}
			}
			$edit_data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'description' => $this->input->post('description'),
				'image' => $file_name,
			);
			$this->BlogModel->update($edit_data,array('id'=>$id));
			$this->session->set_flashdata('success_msg','Blog updated successfully');
			redirect('admin/blog/edit/'.$id);
		}

		$this->render('admin/blog/edit',array(
			'blog' => $blog,
		));
	}

	public function delete($id = null) {
		if(!$id) {
			show_error('No detail found!',404);
		}
		$is_delete = $this->BlogModel->delete(array('id'=>$id));
		if($is_delete) {
			$this->session->set_flashdata('success_msg','Blog deleted successfully!');		
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong!');
		}
		redirect('admin/blog/list');
	}
}
