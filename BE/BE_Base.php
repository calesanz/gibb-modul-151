<?php 
namespace BE;

abstract class BE_Base{
	
	/**
	 * Comparestring must be set on data Load
	 * */
	public $compareString;
	
	/**
	 * get current compare string
	 * @return string
	 */
	abstract function getCompareString();
	/**
	 * Check if Object is new 
	 * @return boolean
	 */
	abstract function isNew();
	
	/**
	 * check if value has changed
	 * @return boolean
	*/
	public function hasChanged(){
		return $this->compareString ==$this->getCompareString();
	}
}

