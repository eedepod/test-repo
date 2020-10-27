<?php
require_once('/util.php');

class Shift {
	
	private $userId;
	private $from;
	private $to;
	
	
	function __construct($userId, $from, $to){
		$this->userId = $userId;
		$this->from = $from;
		$this->to = $to;
	}
	
	
}