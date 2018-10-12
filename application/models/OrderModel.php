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

}
