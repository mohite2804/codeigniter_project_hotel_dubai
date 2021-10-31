<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		Parent::__construct();
			$this->load->library('database_library');
			$this->load->model('Home_Model');
	}
	
	public function index(){
		$this->load->view('admin/login/index');
	}
	
	public function submitLogin(){

		if(!empty($this->input->post('submit'))){
			

			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if (!$this->form_validation->run() == FALSE){

				if($this->database_library->postAdminLogin($this->input->post('email'),$this->input->post('password'))){
					redirect(base_url().'Admin/dashboard');
				}else{			
					redirect(base_url().'admin');
				}

			}else{

			}
		}

		
		$this->load->view('admin/login/index');
	
		
			

			
	}


	
	
	
}

