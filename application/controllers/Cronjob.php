<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends CI_Controller{
	public function __construct(){
		Parent::__construct();
		$this->load->library('session');
		$this->load->model('Main_Model');
		$this->load->library('database_library');
		$this->load->library('Someclass');

		error_reporting(0);
	}

	function index(){			
		
		try {
			
			$this->Main_Model->cronRunOrNot();
			$this->Main_Model->updateRoomBooking();
			$this->Main_Model->updateRoomRateDaily();
		} catch (\Exception $e) {
			echo "<pre>"; print_r($e); exit;
		}
		
		
	}


	
}
