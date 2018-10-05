<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarFuelModel extends MY_Model {

	protected $table = 'car_fuel_types';

	public function __construct()
	{
	    parent::__construct();
	}

}
