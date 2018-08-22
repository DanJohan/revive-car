<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sequence {

	private $ci;
	private $sequence_type;
	private $number_start;
	private $number_current;
	private $reset_counter; 

	public function __construct() {
		$this->ci = & get_instance();
		$this->ci->load->model('SequenceModel');
	}

	public function createSequence($type=null) {
		$this->sequence_type = $type;
		$criteria['conditions'] = array('sequence_type'=>$this->sequence_type);
		$criteria['returnType'] = 'single';
		$result=$this->ci->SequenceModel->search($criteria);
		$this->number_start= $result['number_start'];
		$this->number_current = $result['number_current'];
		$this->reset_counter = $result['reset_counter'];
	}

	public function getNextSequence(){
		$start = ($this->number_current < $this->number_start) ? $this->number_start-1 : $this->number_current;
		$start = $start+1;
		$sequence = $this->generateNumber($start,1,6);
		return array('number'=>$sequence[0],'sequence'=>date('Y').$this->reset_counter.$sequence[0]);
	}

	public function updateSequence() {
		$sequence = $this->getNextSequence();
		$update_data['number_current'] = $sequence['number'];
		if($sequence['number']== 999999 ){
			$update_data['reset_counter'] = ($this->reset_counter+1);
			$update_data['number_current'] = '000000';
		}
		$this->ci->SequenceModel->update($update_data,array('sequence_type'=>$this->sequence_type));
		return $sequence;
	}

	private function generateNumber($start,$count,$digits) {
		 $result = array();
		// $start = str_replace('0','', $start);
		for ($n = $start; $n < $start + $count; $n++) {
		      $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
		 }
		 return $result;
	}


}