<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Widget {

	private $ci;
	private $renderInPlace = false ;
	private $blockName =null;
	private $blocks = array();

	public function __construct() {
		$this->ci = & get_instance();

	}

	public function beginBlock($name,$renderInPlace = false){
		$this->blockName = $name;
		$this->renderInPlace = $renderInPlace;
		ob_start();
		ob_implicit_flush(true);
	}

	public function endBlock(){
		$block = ob_get_clean();
		if($this->renderInPlace){
			echo $block;
			if($this->existsBlock()){
				echo $this->blocks[$this->blockName];
			}
		}else{
			$this->blocks[$this->blockName]= $block;
		}
	}

	public function existsBlock(){
		return isset($this->blocks[$this->blockName]);
	}

}
