<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class TransactionModel extends MY_Model {

	protected $table='transactions';

	public function __construct() {
		parent::__construct();
	}

}