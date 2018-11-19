<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BlogModel extends MY_Model {

	protected $table = 'blogs';

	public function __construct()
	{
	    parent::__construct();
	}

	public function checkSlugExists($slug){
		$this->db->where('slug',$slug);
		$query = $this->db->get($this->table);
		return ($query->num_rows() > 0) ? true : false;
	}
	public function checkSlugExistsExcept($slug, $id){
		$this->db->where(array('id !='=>$id,'slug'=>$slug));
		$query = $this->db->get($this->table);
		return ($query->num_rows() > 0) ? true : false;
	}

	private function getBlogColumn(){
		return array("b.id", 'b.title', 'b.description', 'u.created_at');
	}

	public function getBlogs($start,$limit,$orders,$search){
		$this->db->select('SQL_CALC_FOUND_ROWS b.id,b.title ,b.description, b.created_at',false);
		$this->db->from($this->table.' AS b');

		if(!empty($search['value'])){
			$this->db->or_like(
				array(
					'b.id'=>$search['value'],
					'b.title' =>$search['value'],
					'b.description' => $search['value'],
					'b.created_at' => $search['value'],
				)
			);
		}
	
		$columns = $this->getBlogColumn();
		//dd($columns);
		foreach ($columns as $c_index => $column) {
			if($orders[0]['column'] == $c_index) {
				$this->db->order_by($column,$orders[0]['dir']);
			}
		}

		$this->db->limit($limit,$start);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

}
