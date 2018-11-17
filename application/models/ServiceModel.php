<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceModel extends MY_Model {

	protected $table = 'services';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getServicesByCategory($model_id,$cat_id) {
		$this->db->select('s.id,cs.name,cs.image,s.price');
		$this->db->from($this->table.' AS s');
		$this->db->join('car_services AS cs','s.service_id= cs.id');
		$this->db->join('car_models AS cm', 's.model_id=cm.id');
		$this->db->join('services_category AS sc', 's.category_id=sc.id');
		$this->db->where('s.model_id',$model_id);
		$this->db->where('s.category_id', $cat_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

	private function getSeviceColumn(){
		return array("s.id", 'cs.name', 'sc.name', 'cb.brand_name', 'cm.model_name', 's.price', 's.created_at');
	}

	public function getServices($start,$limit,$orders,$search) {
		$this->db->select('SQL_CALC_FOUND_ROWS s.id,sc.name as category_name,cs.name,cs.image,s.price,cm.model_name,cb.brand_name,s.created_at',false);
		$this->db->from($this->table.' AS s');
		$this->db->join('car_services AS cs','s.service_id= cs.id');
		$this->db->join('car_models AS cm', 's.model_id=cm.id');
		$this->db->join('car_brands AS cb', 'cm.brand_id=cb.id');
		$this->db->join('services_category AS sc', 's.category_id=sc.id');
		if(!empty($search['value'])){
			$this->db->or_like(
				array(
					's.id'=>$search['value'],
					'sc.name' =>$search['value'],
					'cs.name' => $search['value'],
					'cm.model_name'=>$search['value'],
					'cb.brand_name' => $search['value'],
					's.price' => $search['value'],
					's.created_at' => $search['value'],
				)
			);
		}
	
		$columns = $this->getSeviceColumn();
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

	public function getServiceById($id){
		$this->db->select('s.id,cs.name,cs.image,s.price,cm.model_name,cb.brand_name,s.created_at');
		$this->db->from($this->table.' AS s');
		$this->db->join('car_services AS cs','s.service_id= cs.id');
		$this->db->join('car_models AS cm', 's.model_id=cm.id');
		$this->db->join('car_brands AS cb', 'cm.brand_id=cb.id');
		$this->db->join('car_service_category AS csc', 'cs.category_id=csc.id');
		$this->db->where('s.id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}

	public function checkServiceExists($model_id,$service_id,$category_id) {
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where(array('model_id'=>$model_id,'service_id'=>$service_id,'category_id'=>$category_id));
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? true :false;
	}

	public function updatePiceByServices($service_cat_id,$car_models_id = array(),$price)
	{
		$this->db->where('category_id',$service_cat_id);
		if(!empty($car_models_id)){
			$this->db->where_in('model_id',$car_models_id);
		}
		$this->db->update($this->table,array('price'=>$price));
	}

}
