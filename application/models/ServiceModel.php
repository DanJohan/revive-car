<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceModel extends MY_Model {

	protected $table = 'services';

	public function __construct()
	{
	    parent::__construct();
	}

}