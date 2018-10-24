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

	public function getServices() {
		$this->db->select('s.id,sc.name as category_name,cs.name,cs.image,s.price,cm.model_name,cb.brand_name,s.created_at');
		$this->db->from($this->table.' AS s');
		$this->db->join('car_services AS cs','s.service_id= cs.id');
		$this->db->join('car_models AS cm', 's.model_id=cm.id');
		$this->db->join('car_brands AS cb', 'cm.brand_id=cb.id');
		$this->db->join('services_category AS sc', 's.category_id=sc.id');
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

}
