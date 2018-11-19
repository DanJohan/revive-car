<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TestimonialModel extends MY_Model {

	protected $table = 'testimonials';

	public function __construct()
	{
	    parent::__construct();
	}



	private function getTestimonialColumn(){
		return array('t.id', 't.author_name', 't.author_designation','t.description', 't.created_at');
	}

	public function getTestimonials($start,$limit,$orders,$search){
		$this->db->select('SQL_CALC_FOUND_ROWS t.id,t.author_name ,t.author_designation,t.description ,t.created_at',false);
		$this->db->from($this->table.' AS t');

		if(!empty($search['value'])){
			$this->db->or_like(
				array(
					't.id'=>$search['value'],
					't.author_name' =>$search['value'],
					't.author_designation' => $search['value'],
					't.description'=> $search['value'],
					't.created_at' => $search['value'],
				)
			);
		}
	
		$columns = $this->getTestimonialColumn();
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
