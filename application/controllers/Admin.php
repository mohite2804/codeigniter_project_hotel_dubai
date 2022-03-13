<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		error_reporting(0);
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

	public function roomRateSetting(){
		
		if(!empty($this->input->post('submit'))){
			$this->load->library('excel');
			$newimagename = "";
			if(!empty($_FILES['room_rate_setting']['name'])){
					$image_file = "room_rate_setting";
					$directory = "./uploads/roomRateSetting/";

					
					
					$filename = $_FILES[$image_file]["name"];
					$_FILES[$image_file]["name"] = time().$filename;

					

					$config = array(
						'upload_path' => $directory, 
						'allowed_types' => 'xls',
					);
					
					$this ->load->library("upload", $config);

					

					if ($this->upload->do_upload($image_file)) {
						
						$image_data = $this->upload->data();
						$newimagename = $image_data["file_name"];						
					}

					$inputFileName  =  $directory. $newimagename;
					

					try {
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						
						
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($inputFileName);
						$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

					
						$flag = true;
						$i=0;
						$inserdata = array();
						foreach ($allDataInSheet as $value) {
						  if($flag){
							$flag =false;
							continue;
						  }
						  $room_type_short_name = trim($value['A']);
						  $room_type_id = $this->Main_Model->getRoomTypeIdByshortCode($room_type_short_name);
						 
						  if($room_type_id){
							$room_type_id = $room_type_id->id; 
						 						  
							$inserdata[$i]['room_type_id'] = $room_type_id;
							$inserdata[$i]['year'] = $value['B'];
							$inserdata[$i]['month'] = $value['C'];
							$inserdata[$i]['day_1'] = $value['D'];
							$inserdata[$i]['day_2'] = $value['E'];
							$inserdata[$i]['day_3'] = $value['F'];
							$inserdata[$i]['day_4'] = $value['G'];
							$inserdata[$i]['day_5'] = $value['H'];

							$inserdata[$i]['day_6'] = $value['I'];
							$inserdata[$i]['day_7'] = $value['J'];
							$inserdata[$i]['day_8'] = $value['K'];
							$inserdata[$i]['day_9'] = $value['L'];
							$inserdata[$i]['day_10'] = $value['M'];
							$inserdata[$i]['day_11'] = $value['N'];
							$inserdata[$i]['day_12'] = $value['O'];
							$inserdata[$i]['day_13'] = $value['P'];
							$inserdata[$i]['day_14'] = $value['Q'];

							$inserdata[$i]['day_15'] = $value['R'];
							$inserdata[$i]['day_16'] = $value['S'];
							$inserdata[$i]['day_17'] = $value['T'];
							$inserdata[$i]['day_18'] = $value['U'];
							$inserdata[$i]['day_19'] = $value['V'];
							$inserdata[$i]['day_20'] = $value['W'];
							$inserdata[$i]['day_21'] = $value['X'];
							$inserdata[$i]['day_22'] = $value['Y'];

							$inserdata[$i]['day_23'] = $value['Z'];
							$inserdata[$i]['day_24'] = $value['AA'];
							$inserdata[$i]['day_25'] = $value['AB'];
							$inserdata[$i]['day_26'] = $value['AC'];
							$inserdata[$i]['day_27'] = $value['AD'];
							$inserdata[$i]['day_28'] = $value['AE'];
							$inserdata[$i]['day_29'] = $value['AF'];
							$inserdata[$i]['day_30'] = $value['AG'];
							$inserdata[$i]['day_31'] = $value['AH'];

						  	$i++;
						  }
						}          
						
						
						$affected = "";
						if(!empty($inserdata)){
							
							$affected = $this->Main_Model->insertDatatIntoRoomRates($inserdata);   
						}
						
						

						if($affected){		
							$this->Main_Model->cronRunOrNot();
							$this->Main_Model->updateRoomBooking();
							$this->Main_Model->updateRoomRateDaily();					
							$this->session->set_flashdata('suc_msg_excel', "<span style='color:green' >Excel Upload Successfully.</span>");
						}else{
							$this->session->set_flashdata('suc_msg_excel', "<span style='color:red' >Please try again after some time.</span>");
						}
						redirect(base_url().'admin/roomRateSetting');

						          
		 
				  } catch (Exception $e) {
					   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
								. '": ' .$e->getMessage());
					}
					
			}
			
		}

		$data['result'] = $this->Main_Model->roomRateSetting();
		//echo $this->db->last_query(); exit;
		$data['main_contain'] = 'admin/roomRateSetting/index';
		$this->load->view('admin/includes/template',$data);
	}

	public function extraSetting(){


		if(!empty($this->input->post('submit'))){

		
			$this->db->set('extra_bed_amount', $this->input->post('extra_bed_amount'));
			$this->db->set('extra_adult_amount', $this->input->post('extra_adult_amount'));
			$this->db->set('extra_adult_breakfast_amount', $this->input->post('extra_adult_breakfast_amount'));
			$this->db->set('extra_child_breakfast_amount', $this->input->post('extra_child_breakfast_amount'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('extra_setting'); 

			

			$success_messge = "Update successfully";	
		
			$this->session->set_flashdata('suc_msg_extra_setting_update', "<span style='color:green' >".$success_messge."</span>");
			redirect(base_url().'admin/extraSetting');

		}
		$data['result'] = $this->Main_Model->extraSetting();
		
		$data['main_contain'] = 'admin/extraSetting/index';
		$this->load->view('admin/includes/template',$data);
	}

	public function logout(){
		$this->session->unset_userdata('admin_session');
		redirect(base_url().'admin');
	}

	function cancelApprove($order_id){
		
		$affected = $this->Main_Model->cancelApprove($order_id);

		if($affected){
			$this->session->set_flashdata('suc_msg_order_index', "<span style='color:green' >Room Canceled Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg_order_index', "<span style='color:red' >Please try again after some time.</span>");
		}
		redirect(base_url().'admin/getOrders');
	}

	function CheckoutRoom($order_id){
		$affected = $this->Main_Model->CheckoutRoom($order_id);

		if($affected){
			$this->session->set_flashdata('suc_msg_order_index', "<span style='color:green' >Room Checkout Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg_order_index', "<span style='color:red' >Please try again after some time.</span>");
		}
		redirect(base_url().'admin/getOrders');
	}

	function getOrders(){
		$where = " o.id != 0 ";
			
		if(!empty($this->input->post('submit'))){

			//echo "<pre>"; print_r($this->input->post()); exit;
			$payment_status = $this->input->post('payment_status');
			if($payment_status){
				$where .= " and o.status = '$payment_status' ";
			}

			$start_date_time = "2021-10-31";
			$end_date_time = "2021-10-31";
			
			if($start_date_time && $end_date_time){
				$where .= " and o.start_date_time >= $start_date_time and o.end_date_time <= $end_date_time ";
			}

			
		}else{
			$start_date_time = "2021-10-31";
			$end_date_time = "2021-10-31";
			$where .= " and start_date_time >= $start_date_time and end_date_time <= $end_date_time ";

		}

		$data['result'] = $this->Main_Model->getOrders();
		//echo "<pre>"; print_r($data); exit;
		
		$data['main_contain'] = 'admin/orders/index';
		$this->load->view('admin/includes/template',$data);
	}

	public function roomTypes(){
		$data['result'] = $this->Main_Model->getRoomTypes();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/room_types/index';
		$this->load->view('admin/includes/template',$data);
	}

	public function services($slug){
		
		$data['result'] = $this->Main_Model->getServices($slug);
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/services/index';
		$this->load->view('admin/includes/template',$data);
	}

	function rooms(){
		$data['result'] = $this->Main_Model->getRooms();
		//echo "<pre>"; print_r($data['result']); exit;
		$data['main_contain'] = 'admin/rooms/index';
		$this->load->view('admin/includes/template',$data);
	}
	
	
	function addRoomType(){
		if(!empty($this->input->post('submit'))){
			$this->form_validation->set_rules('name', 'Name', 'required');
		
		
			if (!$this->form_validation->run() == FALSE){
				$name = $this->input->post('name');	
				$short_name = $this->input->post('short_name');			
				
				$sql = "INSERT INTO `room_types` (short_name,name) VALUES('$short_name','$name')" ;
				$room_type_id = $this->Main_Model->addUserAlbum($sql);
				$this->session->set_flashdata('suc_msg_room_type_add', "<span style='color:green' >Room Type add successfully</span>");
				$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >Room Type add successfully</span>");
				redirect(base_url().'admin/roomTypes');
			}
		}
		
		$data['main_contain'] = 'admin/room_types/add';
		$this->load->view('admin/includes/template',$data);
	}

	function addService(){
		if(!empty($this->input->post('submit'))){
			$this->form_validation->set_rules('name', 'Name', 'required');
		
		
			if (!$this->form_validation->run() == FALSE){
				$name = $this->input->post('name');		
				$service_type_id = $this->input->post('service_type_id');		
				$service_type_slug = $this->input->post('service_type_slug');	

				$insert_data['title'] = $name;
				
				$insert_data['service_type_id'] = ($service_type_slug == 'highlights') ? '1' : '2';
				$this->db->insert('services',$insert_data);

				$success_messge = "Room Amenities add successfully";
				if($service_type_slug == 'highlights'){
					$success_messge = "Room Highlights add successfully";
				}
				
				$this->session->set_flashdata('suc_msg_room_type_add', "<span style='color:green' >".$success_messge."</span>");
				$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >".$success_messge."</span>");
				redirect(base_url().'admin/services/'.$service_type_slug);
			}
		}
		
		$data['main_contain'] = 'admin/services/add';
		$this->load->view('admin/includes/template',$data);
	}

	function editService(){
		if(!empty($this->input->post('submit'))){

			
			$service_id = $this->input->post('service_id');
			$name = $this->input->post('name');
			$service_type_slug = $this->input->post('service_type_slug');	

			if($this->input->post('name')){
				$this->db->set('title', $name);
				$this->db->where('id',  $service_id);
				$this->db->update('services'); 

			}

			$success_messge = "Room Amenities Update successfully";
			if($service_type_slug == 'highlights'){
				$success_messge = "Room Highlights Update successfully";
			}
		
			$this->session->set_flashdata('suc_msg_room_type_update', "<span style='color:green' >".$success_messge."</span>");
			redirect(base_url().'admin/services/'.$service_type_slug);
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getServiceById($id);
		
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'admin/services/update';
		$this->load->view('admin/includes/template',$data);
	}

	function addRoom(){
		if(!empty($this->input->post('submit'))){
			$this->form_validation->set_rules('name', 'Name', 'required');
		
		
			if (!$this->form_validation->run() == FALSE){
				
				$room_type_id = $this->input->post('room_type_id');
				$name = $this->input->post('name');
				$description = $this->input->post('description');
				$no_of_children = $this->input->post('no_of_children');
				$no_of_adults = $this->input->post('no_of_adults');

				$no_of_children = 1;
				$no_of_adults = 1;

			

				//$amount = $this->input->post('amount');
				$save_percentage = $this->input->post('save_percentage');
				
				$room_highlight = $this->input->post('room_highlight');
				$room_amenities = $this->input->post('room_amenities');
				if($room_highlight){
					$room_highlight = implode(',',$room_highlight);
				}else{
					$room_highlight = "";
				}
	
				if($room_amenities){
					$room_amenities = implode(',',$room_amenities);
				}else{
					$room_amenities = "";
				}

				
				// $after_discount_amount = $amount;
				// $save_amount = "0";
				// if($save_percentage){
				// 	$save_amount =  ($save_percentage / 100) * (float)$amount;
				// 	$after_discount_amount = (float)$amount - (float)$save_amount;
				// }
				
				$user_id = 1;
				$created_at = date('Y-m-d H:i:s');
				$insert_data = array(
					'room_type_id' => $room_type_id,
					'name' => $name,
					'description' => $description,
					'no_of_children' => $no_of_children,
					'no_of_adults' => $no_of_adults,
					// 'amount' => $amount,
					// 'after_discount_amount' => $after_discount_amount,
					// 'save_amount' => $save_amount,
					'save_percentage' => $save_percentage,	
					'room_highlight' => $room_highlight,	
					'room_amenities' => $room_amenities,	
					'created_by' => $user_id,	
					'updated_by' => $user_id,	
					'created_at' => $created_at,	
					'updated_at' => $created_at,	
					


				);
			//	echo "<pre>";print_r($insert_data); exit;
				$this->db->insert('rooms',$insert_data);
				$rooms_id = $this->db->insert_id(); 

				
				if($_FILES['image']['name'][0]){
					$upload_path = FRONT_CSS_JS."images/";
					$image_title = "rooms_";
					$image_file = "image";
					$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);		
					
				}
				
				


			
				if(!empty($newimagenames)){
					$values = "";	$user_id = 1; 
					foreach( $newimagenames as $row ){
						if($row){
							
							$values .= "($rooms_id,'rooms', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
						}
						
					}
					if($values){
						$sql = "INSERT INTO `slider_images` (room_type_id,title, image,created_at) VALUES $values";
						$sql = substr($sql,0,-1);	
						$this->Main_Model->addUserAlbum($sql);
					}
	
					
				
					
				}
				

				$this->session->set_flashdata('suc_msg_room_type_add', "<span style='color:green' >Room add successfully</span>");
				$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >Room add successfully</span>");
				redirect(base_url().'admin/rooms');
				
			}
		}
		$data['numbers'] = [1,2,3,4,5,6,7,8,9,10];	
		$data['discounts'] = [5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
		$data['services'] = $this->Main_Model->getRoomServices();	
		$data['room_types'] = $this->Main_Model->getRoomTypes();	
		$data['main_contain'] = 'admin/rooms/add';
		$this->load->view('admin/includes/template',$data);
	}
	
	function editRoomType(){
		if(!empty($this->input->post('submit'))){

			
			$room_type_id = $this->input->post('room_type_id');
			if($this->input->post('name')){
				$this->db->set('name', $this->input->post('name'));
				$this->db->set('short_name', $this->input->post('short_name'));
				$this->db->where('id',  $room_type_id);
				$this->db->update('room_types'); 

			}
			
			$this->session->set_flashdata('suc_msg_room_type_update', "<span style='color:green' >Room Type Update successfully</span>");
			redirect(base_url().'admin/roomTypes');
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getRoomTypesById($id);
		$data['images'] = $this->Main_Model->getRoomTypesImagesById($id);
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'admin/room_types/update';
		$this->load->view('admin/includes/template',$data);
	}

	function editRoom(){
		if(!empty($this->input->post('submit'))){

			$room_type_id = $this->input->post('room_type_id');
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$no_of_children = $this->input->post('no_of_children');
			$no_of_adults = $this->input->post('no_of_adults');

			$no_of_children = 1;
			$no_of_adults = 1;

			//$amount = $this->input->post('amount');
			$save_percentage = $this->input->post('save_percentage');


			$room_highlight = $this->input->post('room_highlight');
			$room_amenities = $this->input->post('room_amenities');			

			if($room_highlight){
				$room_highlight = implode(',',$room_highlight);
			}else{
				$room_highlight = "";
			}

			if($room_amenities){
				$room_amenities = implode(',',$room_amenities);
			}else{
				$room_amenities = "";
			}
			
			// $after_discount_amount = "0";
			// $save_amount = "0";
			// if($save_percentage){
			// 	$save_amount =  ($save_percentage / 100) * (float)$amount;
			// 	$after_discount_amount = (float)$amount - (float)$save_amount;
			// }
			
			$user_id = 1;
			$created_at = date('Y-m-d H:i:s');
			
			$room_id = $this->input->post('room_id');			
			
			$this->db->set('room_type_id', $room_type_id);
			$this->db->set('name', $name);
			$this->db->set('description', $description);
			$this->db->set('no_of_children', $no_of_children);
			$this->db->set('no_of_adults', $no_of_adults);
			//$this->db->set('amount', $amount);
			$this->db->set('save_percentage', $save_percentage);
			$this->db->set('updated_by', $user_id);
			$this->db->set('updated_at', $created_at);
			//$this->db->set('after_discount_amount', $after_discount_amount);
			//$this->db->set('save_amount', $save_amount);
			
			$this->db->set('room_highlight', $room_highlight);
			$this->db->set('room_amenities', $room_amenities);

			$this->db->where('id',  $room_id);
			$this->db->update('rooms'); 

			

			if($_FILES['image']['name'][0]){
				$upload_path = FRONT_CSS_JS."images/";
				$image_title = "room_";
				$image_file = "image";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);		
				

				if(!empty($newimagenames)){
					$values = "";	$user_id = 1; 
					foreach( $newimagenames as $row ){
						if($row){
							$values .= "($room_id,'rooms', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
						}						
					}
	
					if($values){
						$sql = "INSERT INTO `slider_images` (room_type_id,title, image,created_at) VALUES $values";
						$sql = substr($sql,0,-1);	
						$this->Main_Model->addUserAlbum($sql);
					}
					
				
					
				}

				
			}
			$this->session->set_flashdata('suc_msg_room_type_update', "<span style='color:green' >Room Update successfully</span>");
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >Room Update successfully</span>");
			redirect(base_url().'admin/rooms');
				
		}
		$id = $this->uri->segment('3');
		$data['result'] = $this->Main_Model->getRoomsById($id);
		$data['images'] = $this->Main_Model->getRoomImagesById($id);
		$data['room_types'] = $this->Main_Model->getRoomTypes();	

		$data['services'] = $this->Main_Model->getRoomServices();	

		$data['numbers'] = [1,2,3,4,5,6,7,8,9,10];	
		$data['discounts'] = [5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
		$data['room_highlight'] = ($data['result']->room_highlight) ? explode(',',$data['result']->room_highlight) : array();
		$data['room_amenities'] = ($data['result']->room_amenities) ? explode(',',$data['result']->room_amenities) : array();

		
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'admin/rooms/update';
		$this->load->view('admin/includes/template',$data);
	}
	
	
	function deleteRoomType($id){		
		$affected = $this->Main_Model->deleteRoomType($id);
		if($affected){
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >Room Type Deleted Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:red' >Room Type  Not Deleted Succefully.</span>");
		}
		redirect(base_url().'admin/roomTypes');
		
	}


	function deleteService($id,$service_type_slug){		
		$affected = $this->Main_Model->deleteService($id);

		$success_messge = "Room Amenities Deleted successfully";
		$not_success_messge = "Room Amenities Not Deleted successfully";
		if($service_type_slug == 'highlights'){
			$success_messge = "Room Highlights Deleted successfully";
			$not_success_messge = "Room Highlights Not Deleted successfully";
		}
			
		
		if($affected){
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >".$success_messge."</span>");
		}else{
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:red' >".$not_success_messge."</span>");
		}
		redirect(base_url().'admin/services/'.$service_type_slug);
		
	}

	function deleteRoom($id){		
		//echo "<pre>"; print_r($id); exit;
		$affected = $this->Main_Model->deleteRoom($id);
		if($affected){
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:green' >Room Deleted Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg_room_type_index', "<span style='color:red' >Room Not Deleted Succefully.</span>");
		}
		redirect(base_url().'admin/rooms');
		
	}

	function deleteRoomTypeImage(){	
		$id = $this->input->post('id');	
		$affected = $this->Main_Model->deleteRoomTypeImage($id);
		if($affected){
			$this->session->set_flashdata('suc_msg_room_type_update', "<span style='color:green' >Image Deleted Succefully.</span>");
		}else{
			$this->session->set_flashdata('suc_msg_room_type_update', "<span style='color:red' >Image  Not Deleted Succefully.</span>");
		}
	//	redirect(base_url().'admin/roomTypes');
		
	}

	function deleteGallery(){
		$id = $this->input->post('id');
		$data = $this->Main_Model->deleteGallery($id);
		//echo $this->db->last_query(); exit;
		if($data){
			//echo $this->db->last_query();
			$this->session->set_flashdata('suc_msg_gallery_index', "<span style='color:green' >Image Deleted Succefully.</span>");
			echo "Image deleted successfully";
		}else{
			$this->session->set_flashdata('suc_msg_gallery_index', "<span style='color:red' >Image Not Deleted Succefully.</span>");
			echo "Image not deleted successfully";
		}
		
	}

	function gallery(){
		if(!empty($this->input->post('submit'))){
			$newimagenames = "";
			if(!empty($_FILES['user_album_images']['name'][0])){
				$upload_path = FRONT_CSS_JS."images/";
				$image_title = "home_page";
				$image_file = "user_album_images";
				$newimagenames = $this->database_library->multipleImageUpload($upload_path,$image_file,$image_title);				
				

			}

			//echo "<pre>"; print_r($newimagenames); exit;
			
			if(!empty($newimagenames)){
				$values = "";	$user_id = 1; 
				foreach( $newimagenames as $row ){
					$values .= "('home_gallery', '".'images/'.$row."','".date('Y-m-d H:i:s')."'),"; 
				}

				$sql = "INSERT INTO `slider_images` (title, image,created_at) VALUES $values";
				$sql = substr($sql,0,-1);	
			
				$this->Main_Model->addUserAlbum($sql);
				$this->session->set_flashdata('suc_msg_gallery_index', "<span style='color:green' >Image Add Succefully.</span>");
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

