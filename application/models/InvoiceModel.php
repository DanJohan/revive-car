<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoiceModel extends MY_Model {

	protected $table = 'invoices';

	public function __construct()
	{
	    parent::__construct();
	}
}

?>