<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderModel extends MY_Model {

	protected $table = 'placed_orders';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getById($order_id) {
		$this->db->select('id,order_no,sub_total,pick_up_date,pick_up_time,discount_amount,net_pay_amount');
		$this->db->from($this->table);
		$this->db->where('id',$order_id);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getOrdersByUser($user_id){
		$this->db->select('o.id, o.order_no,sc.name as service_type,scl.name as service_center,o.loaner_vehicle,o.pick_up_date, o.pick_up_time, o.sub_total, o.discount_amount, o.net_pay_amount,o.paid,pt.name as payment_type, o.status,o.created_at, oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price,cd.name as customer_name, cd.email as customer_email, cd.phone as customer_phone, cd.address as customer_address,cd.latitude, cd.longitude');
		$this->db->from($this->table." AS o");
		$this->db->join('order_items AS oi', 'o.id = oi.order_id');
		$this->db->join('customer_details AS cd', 'o.id = cd.order_id');
		$this->db->join('services_category AS sc', 'o.service_type = sc.id');
		$this->db->join('service_centers AS scl', 'o.service_center = scl.id');
		$this->db->join('payment_types AS pt', 'o.payment_type_id=pt.id');
		$this->db->where('user_id',$user_id);
		$result = $this->db->get()->result_array();
		return $result;
	}

}
