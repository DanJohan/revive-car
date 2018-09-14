<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class RepairOrderModel extends MY_Model {

		protected $table = 'repair_orders';

		public function __construct()
		{
		    parent::__construct();
		}

		public function searchJobs($job_card_id) {
			$this->db->select('customer_request');
			$this->db->from($this->table);
			$this->db->where('job_card_id',$job_card_id);
			$query = $this->db->get();
			return $query->result_array();
		}
	}
