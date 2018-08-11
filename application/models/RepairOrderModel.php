<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class RepairOrderModel extends MY_Model {

		protected $table = 'repair_orders';

		public function __construct()
		{
		    parent::__construct();
		}
	}
