<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		Parent::__construct();
		$this->load->library('session');
		$this->load->model('Home_Model');
		$this->load->library('database_library');
		//$this ->is_logged_in();
		
	}

	public function logout(){
		$this->session->unset_userdata('user_session');
		redirect(base_url());
	}
	

	public function index(){
		
		$data['room_types'] =  $this->db->where('is_active','1')->get('room_types')->result();
		$slider_images = $this->Home_Model->getRoomImagesWithRoomType($data['room_types']);
		$data['room_type_with_images'] = $slider_images;

		$data['slider_images'] =  $this->db->where('title','home')->get('slider_images')->result();

		$data['home_explore_our_hotel'] =  $this->db->where('title','home_explore_our_hotel')->get('slider_images')->result();

		$home_gallery =  $this->db->where('title','home_gallery')->order_by("id", "desc")->get('slider_images')->result_array();
		$home_gallery = array_chunk($home_gallery, 6, true);
		$data['home_gallery'] = $home_gallery;
		
		$data['result'] =  $this->db->where('title','home')->get('pages')->row();
		$data['result2'] =  $this->db->where('title','home_2')->get('pages')->row();

		$data['main_contain'] = 'front/home_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function aboutUs(){

		$data['slider_images'] =  $this->db->where('title','about_us')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title','about_us')->get('pages')->row();
		
		$data['main_contain'] = 'front/aboutus_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function gallery(){

		$data['slider_images'] =  $this->db->where('title','gallery')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title','home_gallery')->order_by("id", "desc")->get('slider_images')->result();
	
		$data['main_contain'] = 'front/gallery_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function rooms(){
		
		$slider_images = $this->Home_Model->getRoomTypesWithRooms();
		
		$data['slider_images'] = $slider_images;

		$data['room_types'] =  $this->db->where('is_active','1')->get('room_types')->result();

		

		$data['result'] =  $this->db->where('title','rooms')->get('pages')->row();
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'front/rooms_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function privacyPolicy(){
		$data['slider_images'] =  $this->db->where('title','privacy_policy')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title','privacy_policy')->get('pages')->row();

		$data['main_contain'] = 'front/privacy_policy_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function termsAndConditions(){
		
		$data['slider_images'] =  $this->db->where('title','terms_and_conditions')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title','terms_and_conditions')->get('pages')->row();

		$data['main_contain'] = 'front/terms_conditions_page/index';		
		$this->load->view('front/includes/template',$data);
	}
	public function contact(){
		$data['slider_images'] =  $this->db->where('title','contact_us')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title','contact_us')->get('pages')->row();
		$data['result2'] =  $this->db->where('title','contact_us_2')->get('pages')->row();

		$data['main_contain'] = 'front/contact_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function dashboard(){

				
		

		$data['result']  = $this->Home_Model->getDashboard();
		$data['main_contain'] = 'front/dashboard_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	function feedback(){
		
		if(!empty($this->input->post('submit'))){
		
			$this->form_validation->set_rules('feedback_subject', 'Room Type', 'required');
			$this->form_validation->set_rules('feedback_comment', 'Start Date', 'required');

			if (!$this->form_validation->run() == FALSE){
				$rediret_url = $this->input->post('feedback_current_url');		
				$insert = array(
					'feedback_sub' =>  $this->input->post('feedback_subject'),
					'feedback_msg' => $this->input->post('feedback_comment')		
				);
			
				
				$last_id = $this->Home_Model->feedback($insert);
				if($last_id){						
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >Feedback Send Succefully.</span>");
				}else{
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >Please try again.</span>");
				}	
				
				redirect($rediret_url);
			
			}

		}
			
	}

	public function product($id){
		if($id){

			$where = array(	'r.room_type_id' => $id);
			$data['result'] =  $this->Home_Model->getRoomWiseServices($where);	

			if($data['result']){
				foreach($data['result'] as $row){					
					$data['selected_data']['room_type']  = $row->room_type_id;
					$data['selected_data']['room_start_date']  = date('d/m/Y');
					$data['selected_data']['room_end_date']  = date('d/m/Y');
					$data['selected_data']['room_no_of_adult']  = 1;
					$data['selected_data']['room_no_of_children']  = 1;		
				}
			}
					

			

		}
		$data['room_types'] =  $this->db->where('is_active','1')->get('room_types')->result();	

		//echo "<pre>"; print_r($data); exit;

		$data['main_contain'] = 'front/products_page/index';		
		$this->load->view('front/includes/template',$data);
	}

	public function products(){
		$data['result']  = $this->Home_Model->getProducts();
		$data['selected_data']['room_type']  = '';
		$data['selected_data']['room_start_date']  = '';
		$data['selected_data']['room_end_date']  = '';
		$data['selected_data']['room_no_of_adult']  = '';
		$data['selected_data']['room_no_of_children']  = '';

		if(!empty($this->input->post('submit'))){		
			$this->form_validation->set_rules('room_type', 'Room Type', 'required');
			$this->form_validation->set_rules('room_start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('room_end_date', 'End Date', 'required');
			$this->form_validation->set_rules('room_no_of_adult', 'Number of Adult', 'required');
			$this->form_validation->set_rules('room_no_of_children', 'Number of Children', 'required');

			if (!$this->form_validation->run() == FALSE){				
				$room_type = $this->input->post('room_type');
				$room_start_date = $this->input->post('room_start_date');
				$room_end_date = $this->input->post('room_end_date');
				$room_no_of_adult = $this->input->post('room_no_of_adult');
				$room_no_of_children = $this->input->post('room_no_of_children');

				$data['selected_data']['room_type']  = $room_type;
				$data['selected_data']['room_start_date']  = $room_start_date;
				$data['selected_data']['room_end_date']  = $room_end_date;
				$data['selected_data']['room_no_of_adult']  = $room_no_of_adult;
				$data['selected_data']['room_no_of_children']  = $room_no_of_children;				
				$where = array(
					'r.room_type_id' => $room_type,
					'r.no_of_adults >=' => $room_no_of_adult,
					'r.no_of_children >=' => $room_no_of_children

				);		
				
				$data['room_wise_services'] =  $this->Home_Model->getRoomWiseServices($where);				
				$data['result']  = $this->Home_Model->getProducts($where);
			
			}		

		}
		
	
		$data['room_types'] =  $this->db->where('is_active','1')->get('room_types')->result();	

		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'front/products_page/index';		
		$this->load->view('front/includes/template',$data);
	}


	public function login(){

		if(!empty($this->input->post('submit'))){
			
		
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			if (!$this->form_validation->run() == FALSE){
				//echo "inn"; exit;
			$is_login = $this->Home_Model->postFrontLogin($this->input->post('user_email'),$this->input->post('user_password'));
				if($is_login){
					//echo "<pre>"; print_r($_SESSION); exit;
					redirect(base_url().'dashboard','refresh');
				}else{			
					redirect(base_url().'login');
				}
			}
		}

		$data['main_contain'] = 'front/login_page/index';		
		$this->load->view('front/includes/template',$data);
	}


	

	public function forgotPassword(){
		$data['main_contain'] = 'front/forgot_password_page/index';		
		$this->load->view('front/includes/template',$data);
	}
	

	public function register(){


		if(!empty($this->input->post('submit'))){
			
			$this->form_validation->set_rules('user_fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_confirm_password', 'Password', 'required');
			$this->form_validation->set_rules('user_checkbox', 'Term and Condition', 'required');
			
		
			if (!$this->form_validation->run() == FALSE){
				
					$inser_data['user_fullname'] = $this->input->post('user_fullname');
					$inser_data['user_email'] = $this->input->post('user_email');
					$inser_data['user_password'] = md5($this->input->post('user_password'));
				
					$inser_data['user_role_id'] = 2;
					//echo "<pre>"; print_r($inser_data); exit;
					$last_id = $this->Home_Model->FrontsubmitRegister($inser_data);
					if($last_id){
						$this->session->set_flashdata('suc_msg', "<span style='color:green' >Congratulations, your account has been successfully created.</span>");
					}else{
						$this->session->set_flashdata('suc_msg', "<span style='color:red' >Sorry please try again after some time.</span>");
					}
					
				
			}else{
			
			}
		}
		$data['main_contain'] = 'front/register_page/index';		
		$this->load->view('front/includes/template',$data);
	}
	
}
