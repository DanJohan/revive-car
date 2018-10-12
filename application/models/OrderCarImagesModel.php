<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderCarImagesModel extends MY_Model {

	protected $table = 'order_car_images';

	public function __construct()
	{
	    parent::__construct();
	}
	
	public function getImagesById($ids= array()){
		$this->db->select('id,image');
		$this->db->from($this->table);
		$this->db->where_in('id',$ids);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function updateOrderImages($ids,$order_id){
		$this->db->where_in('id',$ids);
		$this->db->update($this->table,array('order_id'=>$order_id));
	}

}
