<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RideModel extends MY_Model {

	protected $table = 'rides';

	public function __construct()
	{
	    parent::__construct();
	}

	// user ws_crm
	public function getCustomerDriverDetail($id=null) {
		$this->db->select('r.id,r.verfication_code,d.id as driver_id ,d.d_device_type,d.d_device_id,d.d_name,cd.name as customer_name, cd.address as customer_address,cd.phone as customer_phone,u.device_type,u.id as user_id,u.device_id,c.registration_no');
		$this->db->from($this->table.' AS r');
		$this->db->join('driver AS d','r.driver_id = d.id');
		$this->db->join('placed_orders AS o','r.order_id = o.id');
		$this->db->join('customer_details AS cd','r.order_id = cd.order_id');
		$this->db->join('users AS u','o.user_id = u.id');
		$this->db->join('cars AS c','o.car_id = c.id');
		$this->db->where('r.id',$id);
		$result = $this->db->get()->row_array();
		//echo $this->db->last_query();die;
		return $result;
	}

	// used in api
	public function getDriverRides($driver_id){
		$this->db->select('r.id,r.ride_type,r.ride_date,r.ride_time,r.order_id,cd.name as customer_name, cd.address as customer_address,cd.phone as customer_phone,cd.latitude,cd.longitude,c.registration_no, ');
		$this->db->from($this->table.' AS r');
		$this->db->join('placed_orders AS o','r.order_id = o.id');
		$this->db->join('customer_details AS cd','r.order_id = cd.order_id');
		$this->db->join('cars AS c','o.car_id = c.id');
		$this->db->where('r.driver_id',$driver_id);
		$result = $this->db->get()->result_array();
		//echo $this->db->last_query();die;
		return $result;
	}

}
