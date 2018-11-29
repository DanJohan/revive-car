<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DeliveryCarModel extends MY_Model {

	protected $table = 'delivery_cars';

	public function __construct()
	{
	    parent::__construct();
	}


	public function getById($id){
		$this->db->select('dc.id,dc.signature,dc.created_at,dci.id as image_id,dci.image as image');
		$this->db->from($this->table.' AS dc');
		$this->db->join('delivery_car_images AS dci','dc.id=dci.delivery_car_id','left');
		$this->db->where('dc.id',$id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

}
