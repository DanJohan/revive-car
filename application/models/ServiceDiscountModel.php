<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceDiscountModel extends MY_Model {

	protected $table = 'services_discount';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getVerifiedCoupan($coupan_code,$service_ids){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('coupan_code',$coupan_code);
		$this->db->where_in('service_id',$service_ids);
		$result = $this->db->get()->row_array();
		return $result;
	}

}
