<?php
class Home_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
				$this->load->library('session');
				$this->load->library('database_library');
        }


	function getPaymentGatewayResponse($payment_gateway_response){
		$insert_into_payment = array();
		if(!empty($payment_gateway_response)){
			$insert_into_payment['order_id'] = $payment_gateway_response['order_id'];
			$insert_into_payment['tracking_id'] = $payment_gateway_response['tracking_id'];
			$insert_into_payment['bank_ref_no'] = $payment_gateway_response['bank_ref_no'];
			$insert_into_payment['order_status'] = $payment_gateway_response['order_status'];
			$insert_into_payment['payment_mode'] = $payment_gateway_response['payment_mode'];			
			$insert_into_payment['retry_transaction'] = $payment_gateway_response['retry'];
			$insert_into_payment['response_code'] = $payment_gateway_response['response_code'];
			$insert_into_payment['trans_date'] = $payment_gateway_response['trans_date'];
			$insert_into_payment['created_at'] = date('Y-m-d H:i:s');

			$insert_into_payment['payment_gateway_response'] = json_encode($payment_gateway_response) ;

			if($this->db->insert('payment_details' , $insert_into_payment)){
				$room_id = $payment_gateway_response['merchant_param2'];	
				$order_id = $payment_gateway_response['order_id'];		
				//echo "<pre>"; print_r($payment_gateway_response); exit;

				if(trim($payment_gateway_response['order_status'])  == 'Success'){					
					
					$this->db->set('is_free','0')->where('id', $room_id)->update('rooms'); 
					$this->db->set('status','Booked')->where('id', $order_id)->update('orders'); 

				}else{
				
					$this->db->set('is_free','1')->where('id', $room_id)->update('rooms'); 
					$this->db->set('status','Fail')->where('id', $order_id)->update('orders'); 
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
				
			
				
	}
		
	function FrontsubmitRegister($post_data){
		if($this->db->insert('users' , $post_data)){
			return $this->db->insert_id();
		}else{
			return false;
		}	
			
	}

	function sendOTP($inser_data,$last_id){

		
		$from = "fo@sitarahotelapartment.com";
		$to = $inser_data['user_email'];
		$otp = rand (1000 , 9999 );
		$sub = "Email Verification";
		$comp_name = "Sitara";

		$data['comp_name'] = $comp_name;
		$data['otp'] = $otp;
		$email_verify_link = substr(md5(uniqid(rand(), true)), 16, 16); // 16 characters long
		$data['email_verify_link'] = base_url().'varifyEmail/'. $email_verify_link;
	
		$msg  = $this->load->view('front/email_template/email_verify', $data,true);

		$this->load->library('database_library');
		$is_send = $this->database_library->sendEmail($from,$to,$sub,$msg,$comp_name);

		$this->db->set('email_verify_link',$email_verify_link);
		$this->db->where('user_id', $last_id);
		$this->db->update('users'); 	

		if($is_send){
			
			
			return true;
			
		}else{
			return false;
		}


	}

	function resetPasswordSubmit($forgot_password_link,$user_password){
		$user_password = md5($user_password);
		$this->db->set('user_password',$user_password);
		$this->db->where('forgot_password_link', $forgot_password_link);
		$this->db->update('users'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}


	function forgotPassword($email){

		
		$from = "fo@sitarahotelapartment.com";
		$to = $email;
		$sub = "Change Password";
		$msg = "password";
		$comp_name = "Sitara";

		$data['comp_name'] = $comp_name;
		
		$forgot_password_link = substr(md5(uniqid(rand(), true)), 16, 16); // 16 characters long
		$data['forgot_password_link'] = base_url().'resetPassword/'.$forgot_password_link;


		$msg  = $this->load->view('front/email_template/forgot_password', $data,true);

		$this->load->library('database_library');
		$is_send =  $this->database_library->sendEmail($from,$to,$sub,$msg,$comp_name);

		$this->db->set('forgot_password_link',$forgot_password_link);
		$this->db->where('user_email', $email);
		$this->db->update('users'); 

		if($is_send){	
			
			return true;
			
		}else{
			return false;
		}

		


	}

	function insertIntoOrder($data,$user_id){
		//echo "<pre>"; print_r($data); exit;
		$insert_data = array(
			'user_id' => $data->user_id,
			'room_id' => $data->id,
			'no_of_children' => $data->no_of_children,
			'no_of_adults' => $data->no_of_adults,
			'start_date_time' =>  date('Y-m-d 14:00:00',strtotime($data->start_date_time)) ,
			'end_date_time' =>  date('Y-m-d 12:00:00',strtotime($data->end_date_time)) ,
			'status' => 'pending',
			'after_discount_amount' => $data->after_discount_amount,
			'save_amount' => $data->save_amount,
			'save_percentage' => $data->save_percentage,
			'created_at' => date('Y-m-d H:i:s'),
		);
		//echo "<pre>"; print_r($insert_data); exit;
		if($this->db->insert('orders' , $insert_data))
			return $this->db->insert_id();
		else	
			return false;
	}



	function getRoomImagesWithRoomType($room_types){
		$slider_images = 	 $this->db->where('title','rooms')->get('slider_images')->result();
		if($room_types){
			foreach($room_types as $row){
				if($slider_images){					
					foreach($slider_images as $row_image){
						if($row_image->room_type_id ==  $row->id){
							$row->images[] = $row_image->image;
							
						}
					}
				}

			}
		}
		return $room_types;
		
	}


	

	function getDashboard(){

		$user_id = $this->session->userdata('user_session')['logged_in'];
		
		if($user_id){
			$this->db->where('o.user_id', $user_id );
			$result =  $this->db->select('o.*,s.image as room_image,rt.name as heading')
			->from('orders as o')
			->join('rooms as r','r.id = o.room_id')
			->join('room_types as rt','rt.id = r.room_type_id')
			->join('slider_images as s','s.room_type_id = rt.id')
			->where('r.is_active', 1)
			->group_by('r.id')
			->order_by('r.id')
			->get()->result();

			if($result){
				foreach($result as $row){
					$row->services = $this->getServicesByRoomId($row->id);
				}
			}

		}

		

		return $result;

	}

	function feedback($insert_data){
		if($this->db->insert('feedbacks' , $insert_data))
			return $this->db->insert_id();
		else	
			return false;

	}

	function getServicesByRoomId($room_id){
		return $result =  $this->db->select('rs.*,s.heading as service_name,s.image as service_image,s.amount as service_amount,')
		->from('room_services as rs')			
		->join('services as s','s.id = rs.service_id')		
		->where('s.is_active', 1)
		->where('rs.room_id', $room_id)
		->get()->result();

	}

	function getRoomWiseServices($where){
		
		if( count($where) > 0 ){
			$this->db->where($where);
		}

		$result =  $this->db->select('r.*,s.image as room_image')
		->from('rooms as r')
		->join('room_types as rt','rt.id = r.room_type_id')
		->join('slider_images as s','s.room_type_id = rt.id')
		->where('r.is_active', 1)
		->where('r.is_free', 1)
		->group_by('r.id')
		->order_by('r.id')
		->get()->result();

		if($result){
			foreach($result as $row){
				$row->services = $this->getServicesByRoomId($row->id);
			}
		}

		return $result;		

	}

	function getProducts($where = array()){

		if( count($where) > 0 ){
			$this->db->where($where);
		}
		// s.image as room_image,

		$result =  $this->db->select('r.*,r.name as heading')
		->from('rooms as r')
		->join('room_types as rt','rt.id = r.room_type_id')		
		->where('r.is_deleted', 0)
		->where('rt.is_deleted', 0)
	
		->order_by('r.id')
		->get()->result();

		if($result){
			foreach($result as $row){
				if($row->room_amenities){
					$row->amenities =  $this->db->select('title,image')->where_in('id', explode(',',$row->room_amenities))->get('services')->result();
				}

				if($row->room_highlight){
					$row->highlights = $this->db->select('title,image')->where_in('id',explode(',',$row->room_highlight))->get('services')->result();
				}

				
				$row->images = $this->db->select('title,image')->where('room_type_id',$row->room_type_id)->get('slider_images')->result();
				
			}
		}

		return $result;
	}

	function generateSession($id){
		$where = array('user_id ' => $id,'user_role_id' => 2);
		$this->db->select('is_verify_email,user_id,user_name,user_fullname,user_image,user_email');
		$this->db->where($where);
		$query = $this->db->get('users');
		$result = $query->row();
		

		$newdata = array(
			'user_fullname'  => $result->user_fullname,
			'email'     => $result->user_email,
			'logged_in' => $result->user_id,
			'user_image' => $result->user_image
		);
		$this->session->set_userdata('user_session',$newdata);
	}

	function postFrontLogin($email,$pass){
		$output_data = array();
		$output_data['status'] = false;
		$output_data['message'] = "Email or Password wrong.";
		
		$where = array('user_email' => $email,'user_password' => md5($pass),'user_role_id' => 2);
		$this->db->select('is_verify_email,user_id,user_name,user_fullname,user_image,user_email');
		$this->db->where($where);
		$query = $this->db->get('users');
		$result = $query->row();
		
		if(isset($result)){
			$newdata = array(
			'user_fullname'  => $result->user_fullname,
			'email'     => $result->user_email,
			'logged_in' => $result->user_id,
			'user_image' => $result->user_image
		);
		$this->session->set_userdata('user_session',$newdata);
			
			$output_data['status'] = true;
			$output_data['message'] = "User data get successfully.";
			//echo "<pre>"; print_r($result); exit;
			if(!$result->is_verify_email){
				$output_data['status'] = false;
				$output_data['message'] = "Please verify your email address.";
			}
			
		}

		return $output_data;
		
	}

	function getRoomTypesWithRooms(){
		return $this->db->select('rooms.*,slider_images.image')
		->from('slider_images')
		->join('rooms','rooms.id = slider_images.room_type_id')
		->where('rooms.is_deleted', '0')
		->where('slider_images.title', 'rooms')
		->order_by("rooms.id", "desc")
		->group_by(array("rooms.id"))
		->get()->result();
	}

	

	

	

	function admin_email_check($email){
		$id = $this->session->userdata('admin_session')['logged_in'];
		return $this->db->select('user_id')->where('user_id<>',$id)->where('user_email',$email)->get('users')->row();
	}
	
	function user_email_check($email,$user_id){
		if($user_id)
			return $this->db->select('user_id')->where('user_id<>',$user_id)->where('user_email',$email)->get('users')->row();
		else
			return $this->db->select('user_id')->where('user_email',$email)->get('users')->row();
	}

	function getProfileData($id){
		return $this->db->select('user_id,user_fullname,user_password,user_name,user_email,user_address,user_mobile_no_1,user_mobile_no_2,user_pincode,user_image')
		->where('user_id',$id)->get('users')->row();
	}
	
	function getUsers(){
		return $this->db->select('user_id,user_fullname,user_password,user_name,user_email,user_birthday,user_address,user_mobile_no_1,user_mobile_no_2,user_pincode,user_image')
		->where(array('user_is_active' => 1,'user_is_deleted' => 0,'user_role_id'=>3 ))
		->get('users')->result();
	}
	
	

	function submitProfile(){
		$this->db->set($this->input->post());
		$this->db->where('user_id', $this->session->userdata('admin_session')['logged_in']);
		$this->db->update('users'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	
	
	
	function addUser(){
		if($this->db->insert('users' , $this->input->post()))
			return $this->db->insert_id();
		else	
			return false;
	}
	
	function editUser($id){
		$this->db->set($this->input->post());
		$this->db->where('user_id', $id);
		$this->db->update('users'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	function getSiteInfo(){
		return $this->db->select('id,name,email,mobile_no_1,mobile_no_2,image,footer')
		->where('id',1)->get('site_setting')->row();
	}
	
	function editSiteInformation(){
		$this->db->set($this->input->post());
		$this->db->where('id', 1);
		$this->db->update('site_setting'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	
	
	function getAdminAlbum(){
		return $this->db->select('admin_categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname')
		->from('user_albums')
		->join('users','user_albums.user_id = users.user_id')
		->join('admin_categories','admin_categories.id = user_albums.category_id')
		->where('users.user_is_active', 1)->where('users.user_is_deleted', 0)
		->where('users.user_role_id', 1)->where('users.user_id', 1)->where('user_albums.user_id', 1)
		->group_by(array("user_albums.user_id", "user_albums.category_id"))
		->get()->result();
	}
	
	function getUserAlbum(){
		return $this->db->select('categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname')
		->from('user_albums')
		->join('users','user_albums.user_id = users.user_id')
		->join('categories','categories.id = user_albums.category_id')
		->group_by(array("user_albums.user_id", "user_albums.category_id"))
		->get()->result();
	}
	
	function getCustomers(){
		return $this->db->select('user_id,user_fullname')
		->where('user_is_active', 1)->where('user_is_deleted', 0)
		->where('user_role_id', 3)
		->from('users')->get()->result();
	}

	function getHomePageAlbum(){
		return $this->db->select('id,image')
		->where('is_deleted', 0)
		->from('home_page_albums')->get()->result();
	}
	
	function addUserAlbum($sql){
		$this->db->query($sql);
		return $this->db->insert_id();
	}
	
	function getAlbumDataByUserId($id){
		return $this->db->select('categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname,user_albums.image')
		->from('user_albums')
		->join('users','user_albums.user_id = users.user_id')
		->join('categories','categories.id = user_albums.category_id')
		->where('user_albums.category_id',$id)
		->get()->result();
	}
	
	function getAdminAlbumDataByUserId($id){
		return $this->db->select('admin_categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname,user_albums.image')
		->from('user_albums')
		->join('users','user_albums.user_id = users.user_id')
		->join('admin_categories','admin_categories.id = user_albums.category_id')
		->where('user_albums.category_id',$id)
		->get()->result();
	}
	
	function updateUserAlbum(){
		$this->db->set($this->input->post());
		$this->db->where('id', 1);
		$this->db->update('user_albums'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	function getCategories(){
		return $this->db->select('id,name')
		->from('categories')
		->where('is_deleted',0)
		->where('is_active',1)
		->get()->result();
	}
	
	function getAdminCategories(){
		return $this->db->select('id,name')
		->from('admin_categories')
		->where('is_deleted',0)
		->where('is_active',1)
		->get()->result();
	}
	
	function userDelete($user_id){
		$this->db->set('user_is_deleted','1');
		$this->db->set('user_deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $user_id);
		$this->db->update('users'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	function deleteUserAlbum($id){
		$this->db->delete('user_albums', array('id' => $id));
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	
	function getMessage(){
		return $this->db->select('send_messages.id,send_messages.user_id,send_messages.is_message,send_messages.email_template_id,send_messages.message,send_messages.created_at')
		->from('send_messages')
		//->join ('users' , 'users.user_id = send_messages.user_id','left')
		->get()->result();
	}
	
	function getEmailTemplate(){
		return $this->db->select('id,name,image')
		->from('email_templates')
		->get()->result();
	}
	
	function getEmailIdAndDeviceTokenByUserids($user_ids){
		return $this->db->select('users.user_id,users.user_email,device_tokan,mobile_type')
		->from('users')
		->join ('user_device_tokan_mobile_types' , 'user_device_tokan_mobile_types.user_id = users.user_id','left')
		->where('user_is_active', 1)
		->where('user_is_deleted', 0)
		->where_in('users.user_id',$user_ids) 
		->get()->result();
		
	}
	
	function getSiteEmail(){
		return $this->db->select('email,name')
		->from('site_setting')
		->get()->row();
	}
	
	function sendEmail($to,$msg){
		$site_details = $this->getSiteEmail();
		$from = $site_details->email;
		$comp_name = $site_details->name;
		$this->load->library('database_library');
		$this->database_library->sendEmail($from,$to,$sub,$msg,$comp_name);
	}
	
	function getVideos(){
		return $this->db->select('id,video_name,video_link,video_image,created_at')
		->from('videos')
		->where('is_active', 1)
		->where('is_deleted', 0)
		->get()->result();
	}
	
	function editVideo($id){
		return $this->db->select('id,video_link,video_name,video_image,created_at')
		->from('videos')
		->where('id',$id)
		->get()->row();
	}
	
	function updateVideo(){
		$this->db->set($this->input->post());
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('videos'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	function deleteVideo($id){
		$this->db->set('is_deleted','1');
		$this->db->where('id', $id);
		$this->db->update('videos'); 
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
	
	
	function addVideo(){
		if($this->db->insert('videos' , $this->input->post()))
			return $this->db->insert_id();
		else	
			return false;
	}
	

//------------------------------------------------ feedback management start -------------------------------------------------------------------
//countNotReadablyMail getInboxMail getSentMail getDraftMail 
	function countNotReadablyMail(){
		return $this->db->select('count(*) as not_readable')
		->from('feedbacks')
		->where('is_readable', 0)
		->where('is_deleted', 0)
		->where('inbox_send_draft', 1)
		->get()->row();
	}
	
	function getInboxMail(){
		$sql = "
			select feedbacks.id,GROUP_CONCAT(users.user_fullname ORDER BY users.user_id) Usersame
			from feedbacks
			join users on FIND_IN_SET(users.user_id,feedbacks.feedback_from)
			group by feedbacks.id
		";
		$this->db->query($sql);
		
		//return $this->db->select('feedbacks.*,GROUP_CONCAT(users.user_fullname ORDER BY users.user_id) Usersame')
	//	->from('feedbacks')
		//->join('users','users.user_id = feedbacks.feedback_from')
		//->where('is_deleted', 0)
	//	->where('inbox_send_draft', 1)
		//->get()->result();
	}
	function getSentMail(){
		return $this->db->select('*')
		->from('feedbacks')
		->where('is_deleted', 0)
		->where('inbox_send_draft', 2)
		->get()->result();
	}
	
	function getDraftMail(){
		return $this->db->select('*')
		->from('feedbacks')
		->where('is_deleted', 0)
		->where('inbox_send_draft', 3)
		->get()->result();
	}

//------------------------------------------------- feedback management end ------------------------------------------------------------------
	
}
	
