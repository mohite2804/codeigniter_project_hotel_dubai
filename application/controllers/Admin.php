<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		//echo "<pre> "; print_r($_SESSION); exit;
		$this->load->model('Main_Model');
		$this->load->library('database_library');
		$this ->checkLogin();
		//$this->output->enable_profiler(TRUE);
		
		
	}
	
//-------------------------------------- admin management start -------------------------------------------------	
	public function checkLogin(){
		if(!$this->database_library->checkLogin())
			redirect(base_url().'admin');
	}
	public function logout(){
		$this->session->unset_userdata('admin_session');
		redirect(base_url().'admin');
	}


	public function roomTypes(){
		$data['result'] = $this->Main_Model->getRoomTypes();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/room_types/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	function addRoomType(){
		if(!empty($this->input->post('submit'))){
			$this->form_validation->set_rules('name', 'Name', 'required');
		
		
			if (!$this->form_validation->run() == FALSE){
				$name = $this->input->post('name');
				
				if(!empty($_FILES['image'])){
					$upload_path = FRONT_CSS_JS."images/";
					$image_title = "room_type";
					$image_file = "image";
					$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);		
					
				}
				
				$sql = "INSERT INTO `room_types` (name) VALUES('$name')" ;
				$room_type_id = $this->Main_Model->addUserAlbum($sql);


			
				if(!empty($newimagenames)){
					$values = "";	$user_id = 1; 
					foreach( $newimagenames as $row ){
						$values .= "($room_type_id,'rooms', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
					}
	
					$sql = "INSERT INTO `slider_images` (room_type_id,title, image,created_at) VALUES $values";
					$sql = substr($sql,0,-1);	
				
					$this->Main_Model->addUserAlbum($sql);
				}

				
			}
		}
		
		$data['main_contain'] = 'admin/room_types/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editRoomType(){
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES['image'])){
				$upload_path = FRONT_CSS_JS."images/";
				$image_title = "room_type";
				$image_file = "image";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);		
				
			}

			$room_type_id = $this->input->post('room_type_id');
			if(!empty($newimagenames)){
				$values = "";	$user_id = 1; 
				foreach( $newimagenames as $row ){
					$values .= "($room_type_id,'rooms', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `slider_images` (room_type_id,title, image,created_at) VALUES $values";
				$sql = substr($sql,0,-1);	
			
				$this->Main_Model->addUserAlbum($sql);
			}
		
			
				
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getRoomTypesById($id);
		$data['images'] = $this->Main_Model->getRoomTypesImagesById($id);
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'admin/room_types/update';
		$this->load->view('admin/includes/template',$data);
	}
	
	
	function deleteRoomType($id){		
		$affected = $this->Main_Model->deleteRoomType($id);
		if($affected){
			$this->session->set_flashdata('suc_msg', "<span style='color:green' >Room Type Deleted Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg', "<span style='color:red' >Room Type  Not Deleted Succefully.</span>");
		}
		redirect(base_url().'admin/roomTypes');
		
	}

	function deleteRoomTypeImage(){	
		$id = $this->input->post('id');	
		$affected = $this->Main_Model->deleteRoomTypeImage($id);
		if($affected){
			$this->session->set_flashdata('suc_msg', "<span style='color:green' >Image Deleted Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg', "<span style='color:red' >Image  Not Deleted Succefully.</span>");
		}
	//	redirect(base_url().'admin/roomTypes');
		
	}

	function deleteGallery(){
		$id = $this->input->post('id');
		$data = $this->Main_Model->deleteGallery($id);
		//echo $this->db->last_query(); exit;
		if($data){
			//echo $this->db->last_query();
			echo "Image deleted successfully";
		}else{
			echo "Image not deleted successfully";
		}
		
	}

	function gallery(){
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES['user_album_images']['name'])){
				$upload_path = FRONT_CSS_JS."images/";
				$image_title = "home_page";
				$image_file = "user_album_images";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);				
				

			}

			
			
			if(!empty($newimagenames)){
				$values = "";	$user_id = 1; 
				foreach( $newimagenames as $row ){
					$values .= "('home_gallery', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `slider_images` (title, image,created_at) VALUES $values";
				$sql = substr($sql,0,-1);	
			
				$this->Main_Model->addUserAlbum($sql);
			}
				
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getHomePageAlbum();
		//echo "<pre>"; print_r($data['result']);exit;
		$data['main_contain'] = 'admin/home_page/update';
		$this->load->view('admin/includes/template',$data);
	}
	//---------------------------------------------------------
	
	
	public function admin_email_check($email){
       if($this->Main_Model->user_email_check($email)){
			$this->form_validation->set_message('user_email_check', 'This Email already exists.');
			return FALSE;
		}else{
			return TRUE;
        }
    }
	
	public function profile(){
		
		if( empty($this->input->post('submit'))){
			$new_name = $this->input->post('hidden_image');
			if(!empty($_FILES['user_image'])){
				$new_name = $this->database_library->uploadImage('user_image','uploads/users/');
			}
			$this->form_validation->set_rules('user_fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_admin_email_check');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_mobile_no_1', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_mobile_no_2', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_pincode', 'Pincode', 'required');
			$this->form_validation->set_rules('user_address', 'Address', 'required');
			
			if (!$this->form_validation->run() == FALSE){
				if($new_name){
					$this->database_library->resizeImage(100,100,"uploads/users/$new_name",'uploads/users/thumb/');
					$_POST['user_image'] = $new_name;
					unset($_POST['hidden_image']);
					$this->Main_Model->submitProfile();
				}
			}else{
				  echo validation_errors();
			}
		}
		$id = $this->session->userdata('admin_session')['logged_in'];
		$data['result'] = $this->Main_Model->getProfileData($id);
		$data['main_contain'] = 'admin/users/profile';
		$this->load->view('admin/includes/template',$data);
	}
	
	public function dashboard(){
		//echo "dashboard";
		//echo "<pre>"; print_r($_SESSION); exit;
		$data['main_contain'] = 'admin/dashboard/index';
		$this->load->view('admin/includes/template',$data);
	}
	
//-------------------------------------- user management start -------------------------------------------------
	
	public function usersManagement(){
		$data['result'] = $this->Main_Model->getUsers();
		//echo "<pre>"; print_r($result); exit;
		$data['main_contain'] = 'admin/users/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	public function user_email_check($email){
	   $user_id = $this->input->post('user_id');
       if($this->Main_Model->user_email_check($email,$user_id)){
		   //echo $this->db->last_query();exit;
			$this->form_validation->set_message('user_email_check', 'This Email already exists.');
			return FALSE;
		}else{
			return TRUE;
        }
    }
	
	
	function addUser(){
		if(!empty($this->input->post('submit'))){
			$new_name = "";
			if(!empty($_FILES['user_image']['name'])){
				$new_name = $this->database_library->uploadImage('user_image','uploads/users/');
			}
			$this->form_validation->set_rules('user_fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_user_email_check');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_mobile_no_1', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_mobile_no_2', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_pincode', 'Pincode', 'required');
			$this->form_validation->set_rules('user_address', 'Address', 'required');
			
			if (!$this->form_validation->run() == FALSE){
				if($new_name){
					$this->database_library->resizeImage(100,100,"uploads/users/$new_name",'uploads/users/thumb/');
					$_POST['user_image'] = $new_name;
				}
					unset($_POST['hidden_image']);
					unset($_POST['submit']);
					$last_id = $this->Main_Model->addUser();
					if($last_id){
						//$this->database_library->calculateLatLong($address);
						//$this->Main_Model->addLatLong($last_id,$latitude,$longitude);
						$this->session->set_flashdata('suc_msg', "<span style='color:green' >User Added Succefully.</span>");
					}else{
						$this->session->set_flashdata('suc_msg', "<span style='color:red' >User Not Added Succefully.</span>");
					}
					
				
			}else{
				 // echo validation_errors();
			}
		}
		$data['main_contain'] = 'admin/users/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editUser(){
		if(!empty($this->input->post('submit'))){
			$id = $this->input->post('user_id');
			$new_name = $this->input->post('hidden_image');
			if(!empty($_FILES['user_image'])){
				$new_name = $this->database_library->uploadImage('user_image','uploads/users/');
			}
			$this->form_validation->set_rules('user_fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_user_email_check');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_mobile_no_1', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_mobile_no_2', 'Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_pincode', 'Pincode', 'required');
			$this->form_validation->set_rules('user_address', 'Address', 'required');
			
			if (!$this->form_validation->run() == FALSE){
				if($new_name){
					$this->database_library->resizeImage(100,100,"uploads/users/$new_name",'uploads/users/thumb/');
					$_POST['user_image'] = $new_name;
				}
				unset($_POST['submit']);
				unset($_POST['hidden_image']);
				$affected_id = $this->Main_Model->editUser($id);
				if($affected_id){
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >User Updated Succefully.</span>");
				}else{
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >User Not Updated Succefully.</span>");
				}
				
			}else{
				  echo validation_errors();
			}
		}else{
				$id = $this->uri->segment('3');
		}
	
		
		$data['result'] = $this->Main_Model->getProfileData($id);
		$data['main_contain'] = 'admin/users/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function userDelete($user_id){
		 $data = $this->Main_Model->userDelete($user_id);
		 if($data)
			$this->session->set_flashdata('suc_msg', "<span style='color:green' >User Deleted Succefully.</span>");
		else
			$this->session->set_flashdata('suc_msg', "<span style='color:red' >User Deleted Unsuccefully.</span>");
	}
	
	function siteManagement(){
		if(!empty($this->input->post('submit'))){
			$new_name = $this->input->post('hidden_image');
			if(!empty($_FILES['image'])){
				$new_name = $this->database_library->uploadImage('image','uploads/site/');
			}
			$this->form_validation->set_rules('name', 'Site Name', 'required');
			$this->form_validation->set_rules('email', 'Site Email', 'required|valid_email');
			
			$this->form_validation->set_rules('mobile_no_1', 'Site Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('mobile_no_2', 'Site Mobile Number', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('footer', 'Site Footer', 'required');
			
			
			if (!$this->form_validation->run() == FALSE){
				if($new_name){
					$this->database_library->resizeImage(100,100,"uploads/site/$new_name",'uploads/site/thumb/');
					$_POST['image'] = $new_name;
				}
				unset($_POST['submit']);
				unset($_POST['hidden_image']);
				$affected_id = $this->Main_Model->editSiteInformation();
				if($affected_id){
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >Site Information Updated Succefully.</span>");
				}else{
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >Site Information Not Updated Succefully.</span>");
				}
				
			}else{
				  echo validation_errors();
			}
		}
		
		$data['result'] = $this->Main_Model->getSiteInfo();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/site/add';
		$this->load->view('admin/includes/template',$data);
	}
// ------------------------------------ start user album management ---------------------------------------------------
	public function usersAlbumManagement(){
		$data['result'] = $this->Main_Model->getUserAlbum();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/user_album/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	function addUserAlbum(){
		if(!empty($this->input->post('submit'))){
			$this->form_validation->set_rules('selected_users', 'Select User', 'required');
			
			$categories = $this->input->post('selected_category');
			//echo "<pre>"; print_r($categories); exit;
			if (!$this->form_validation->run() == FALSE){
				if(!empty($_FILES['user_album_images'])){
					$upload_path = "./uploads/user_album/";
					$image_title = "user_album_";
					$image_file = "user_album_images";
					$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);
				}
				if(!empty($newimagenames)){
					$values = "";	$user_id = $this->input->post('selected_users');
					foreach( $newimagenames as $row ){
						if(!empty($categories)){
							foreach($categories as $cat_id){
								$values .= "('".$user_id."', '".$row."', '".$cat_id."','".date('Y-m-d H:i:s')."'),"; 
							}
						}
					}

					$sql = "INSERT INTO `user_albums` (user_id, image,category_id,created_at) VALUES $values";
					$sql = substr($sql,0,-1);
					//echo $sql;exit;
					$this->Main_Model->addUserAlbum($sql);
				}
			}
		}
		$data['categories'] = $this->Main_Model->getCategories();
		$data['customers'] = $this->Main_Model->getCustomers();
		$data['main_contain'] = 'admin/user_album/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editUserAlbum(){
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES['user_album_images'])){
				$upload_path = "./uploads/user_album/";
				$image_title = "user_album_";
				$image_file = "user_album_images";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);
			}
			
			if(!empty($newimagenames)){
				$values = "";	$user_id = $this->input->post('user_id'); $cat_id = $this->input->post('category_id'); 
				foreach( $newimagenames as $row ){
					$values .= "('".$user_id."', '".$row."', '".$cat_id."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `user_albums` (user_id, image,category_id,created_at) VALUES $values";
				$sql = substr($sql,0,-1);
				//echo $sql;exit;
				$this->Main_Model->addUserAlbum($sql);
			}
				
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getAlbumDataByUserId($id);
		//echo "<pre>"; print_r($data['result']);exit;
		$data['main_contain'] = 'admin/user_album/update';
		$this->load->view('admin/includes/template',$data);
	}
	
	
	function deleteUserAlbum(){
		$id = $this->input->post('id');
		$data = $this->Main_Model->deleteUserAlbum($id);
		echo "Image deleted successfully";
	}
//------------------------------- user album end--------------------------------------------------------

//------------------------------------------------------------------------------------------------------------------
function homePageManagement(){
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES['user_album_images']['name'])){
				$upload_path = "./uploads/home_page/";
				$image_title = "home_page";
				$image_file = "user_album_images";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);
			}
			
			if(!empty($newimagenames)){
				$values = "";	$user_id = 1; 
				foreach( $newimagenames as $row ){
					$values .= "('".$user_id."', '".$row."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `home_page_albums` (user_id, image,created_at) VALUES $values";
				$sql = substr($sql,0,-1);
				//echo $sql;exit;
				$this->Main_Model->addUserAlbum($sql);
			}
				
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getHomePageAlbum();
		//echo "<pre>"; print_r($data['result']);exit;
		$data['main_contain'] = 'admin/home_page/update';
		$this->load->view('admin/includes/template',$data);
}
//------------------------------------------------------------------------------------------------------------------
// ------------------------------------ start user album management ---------------------------------------------------
	public function adminAlbumManagement(){
		$data['result'] = $this->Main_Model->getAdminAlbum();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/admin_album/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	function addAdminAlbum(){
		if(!empty($this->input->post('submit'))){
			//$this->form_validation->set_rules('selected_users', 'Select User', 'required');
			
			$categories = $this->input->post('selected_category');
			//echo "<pre>"; print_r($categories); exit;
			//if (!$this->form_validation->run() == FALSE){
				if(!empty($_FILES['user_album_images']['name'])){
					$upload_path = "./uploads/admin_album/";
					$image_title = "admin_album";
					$image_file = "user_album_images";
					$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);
				//}
					if(!empty($newimagenames)){
						$values = "";	$user_id = 1;
						foreach( $newimagenames as $row ){
							if(!empty($categories)){
								foreach($categories as $cat_id){
									$values .= "('".$user_id."', '".$row."', '".$cat_id."','".date('Y-m-d H:i:s')."'),"; 
								}
							}
						}

						$sql = "INSERT INTO `user_albums` (user_id, image,category_id,created_at) VALUES $values";
						$sql = substr($sql,0,-1);
						//echo $sql;exit;
						$this->Main_Model->addUserAlbum($sql);
					}
				}
		}
		$data['categories'] = $this->Main_Model->getAdminCategories();
		//$data['customers'] = $this->Main_Model->getCustomers();
		$data['main_contain'] = 'admin/admin_album/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editAdminAlbum(){
		if(!empty($this->input->post('submit'))){
			if(!empty($_FILES['user_album_images']['name'])){
				$upload_path = "./uploads/admin_album/";
				$image_title = "admin_album";
				$image_file = "user_album_images";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);
			}
			
			if(!empty($newimagenames)){
				$values = "";	$user_id = 1; $cat_id = $this->input->post('category_id'); 
				foreach( $newimagenames as $row ){
					$values .= "('".$user_id."', '".$row."', '".$cat_id."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `user_albums` (user_id, image,category_id,created_at) VALUES $values";
				$sql = substr($sql,0,-1);
				//echo $sql;exit;
				$this->Main_Model->addUserAlbum($sql);
			}
				
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getAdminAlbumDataByUserId($id);
		//echo "<pre>"; print_r($data['result']);exit;
		$data['main_contain'] = 'admin/admin_album/update';
		$this->load->view('admin/includes/template',$data);
	}
	

	
	function deleteAdminAlbum(){
		$id = $this->input->post('id');
		$data = $this->Main_Model->deleteUserAlbum($id);
		echo "Image deleted successfully";
	}
//------------------------------- admin album end--------------------------------------------------------


	function messageManagement(){

		$data['result'] = $this->Main_Model->getMessage();
		//echo $this->db->last_query();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/send_message/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	function sendMessage(){
		if(!empty($this->input->post('submit'))){
			
				$this->load->library('class.push','push');
				$user_ids = $this->input->post('selected_users');
				$is_message = $this->input->post('selected_email_msg');
				$email_template = $this->input->post('selected_email_template');
				$message = $this->input->post('message');
				
				
				$device_tokans_email_ids = $this->Main_Model->getEmailIdAndDeviceTokenByUserids($user_ids);
				//echo "<pre>"; print_r($device_tokans_email_ids);exit;
				if(!empty($device_tokans_email_ids)){
					foreach ($device_tokans_email_ids as $row) {
							if(in_array('1',$is_message)){
								$params	= array("pushtype"=>$mobile_type, $idphone=>$device_tokan, $mst=>$message);
								$this->push->sendMessage($params);
							}
							
							if(in_array('0',$is_message)){
								$this->Main_Model->sendEmail($row->user_email,$message);
							}
						
					}

				}
		}
		if($this->uri->segment(3) != ""){
			$data['message_detials'] = $this->Main_Model->getMessage($this->uri->segment(3));
			//echo "<pre>"; print_r($message_detials);exit;
		}
		$data['email_templates'] = $this->Main_Model->getEmailTemplate();
		$data['customers'] = $this->Main_Model->getCustomers();
		$data['main_contain'] = 'admin/send_message/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	
	function videoManagement(){
		$data['main_contain'] = 'admin/video/index';
		$data['result'] = $this->Main_Model->getVideos();
		$this->load->view('admin/includes/template',$data);
	}
	
	function addVideo(){
		
		if(!empty($this->input->post('submit'))){
			
			$new_name = $this->input->post('hidden_image');
			if(!empty($_FILES['video_image']['name'])){
				$new_name = $this->database_library->uploadImage('video_image','uploads/videos/');
			}
			$this->form_validation->set_rules('video_name', 'Video Name', 'required');
			$this->form_validation->set_rules('video_link', 'Video Link', 'required');
			if (!$this->form_validation->run() == FALSE){
				if($_FILES['video_image']['name']){
					$this->database_library->resizeImage(100,100,"uploads/videos/$new_name",'uploads/videos/thumb/');
				}
					$_POST['video_image'] = $new_name;
					unset($_POST['hidden_image']);
					unset($_POST['submit']);
					//echo "<pre>"; print_r($_POST); exit;
					$this->Main_Model->addVideo();
				
			}
		}
		$data['main_contain'] = 'admin/video/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editVideo(){
		
		if(!empty($this->input->post('submit'))){
			$new_name = $this->input->post('hidden_image');
			if(!empty($_FILES['video_image']['name'])){
				$new_name = $this->database_library->uploadImage('video_image','uploads/videos/');
			}
			$this->form_validation->set_rules('video_name', 'Video Name', 'required');
			$this->form_validation->set_rules('video_link', 'Video Link', 'required');
			
			if (!$this->form_validation->run() == FALSE){
				if($_FILES['video_image']['name']){
					$this->database_library->resizeImage(100,100,"uploads/videos/$new_name",'uploads/videos/thumb/');
					$_POST['video_image'] = $new_name;
				}
					unset($_POST['hidden_image']);
					unset($_POST['submit']);
					//echo "<pre>"; print_r($_POST); exit;
					$this->Main_Model->updateVideo();
				
			}
		}
		$data['result'] = $this->Main_Model->editVideo($this->uri->segment(3));
		$data['main_contain'] = 'admin/video/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function deleteVideo(){
		$id = $this->uri->segment(3);
		//$id = $this->input->post('id');
		$data = $this->Main_Model->deleteVideo($id);
		echo "Image deleted successfully";
	}

//----------------------------------- start feedback management ----------------------------------------

	function feedbackManagement(){
		
		$data['count_not_readably_mail'] = $this->Main_Model->countNotReadablyMail();
		
		
		$data['inbox_mails'] = $this->Main_Model->getInboxMail();
		$data['count_all_mail'] = (!empty($data['inbox_mails'])) ? count($data['inbox_mails']) : "0";
		$data['sent_mails'] = $this->Main_Model->getSentMail();
		$data['draft_mails'] = $this->Main_Model->getDraftMail();
		echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'admin/feedback/mailbox';
		$this->load->view('admin/includes/template',$data);
	}
	
//----------------------------------- end feedback management ------------------------------------------
}

