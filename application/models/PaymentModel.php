<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class PaymentModel extends MY_Model {

	protected $table='payments';

	public function __construct() {
		parent::__construct();
	}

	public function getById($id) {
		$this->db->select('p.id,p.merchant_transaction_id AS transaction_id,pt.name,p.invoice_id,p.amount,p.status,p.created_at');
		$this->db->from($this->table.' AS p');
		$this->db->join('payment_types AS pt','p.payment_type_id=pt.id');
		$this->db->where('p.id',$id);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : null;
	}

}