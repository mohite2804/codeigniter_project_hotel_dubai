<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->library('session');
		$this->load->model('Home_Model');
		$this->load->library('database_library');
		$this->load->library('Someclass');
		//$this ->is_logged_in();
		error_reporting(0);
	}

	public function logout()
	{
		$this->session->unset_userdata('user_session');
		redirect(base_url());
	}

	
	function sendOTP()
	{
		$email = $this->input->post('email');
		echo $is_send = $this->Home_Model->sendOTP($email);
		//return $is_send;

	}

	function varifyEmail($email_verify_link)
	{
		$is_get_result =  $this->db->where('email_verify_link',$email_verify_link)->get('users')->row();
		$this->session->set_flashdata('suc_msg_register', "<span style='color:red' >Sorry please try again after some time.</span>");
		if($is_get_result){
			$this->db->set('is_verify_email','1');
			$this->db->where('email_verify_link', $email_verify_link);
			$this->db->update('users'); 
			$this->session->set_flashdata('suc_msg_register', "<span style='color:green' >Your email is verify. thanks.</span>");
			
		}
		
	
		redirect(base_url() . 'login');
		
	}

	function resetPassword($forgot_password_link){

		$is_get_result =  $this->db->where('forgot_password_link',$forgot_password_link)->get('users')->row();
		///echo "<pre>"; print_r($is_get_result); exit;
		
		if($is_get_result){	
	
			
			
		}else{
			$this->session->set_flashdata('suc_msg_register', "<span style='color:red' >Sorry please try again after some time or check your link</span>");
		}
		
		$data['forgot_password_link'] = $forgot_password_link;
		$data['main_contain'] = 'front/reset_password/index';
		$this->load->view('front/includes/template', $data);

	}

	

	function resetPasswordSubmit()
	{

		if (!empty($this->input->post('submit'))) {

			$this->form_validation->set_rules('forgot_password_link', 'forgot Password', 'required');		
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_confirm_password', 'Confirm Password', 'required|matches[user_password]');
		
			if (!$this->form_validation->run() == FALSE) {
				$forgot_password_link = $this->input->post('forgot_password_link');
				$user_password = $this->input->post('user_password');
				$last_id = $this->Home_Model->resetPasswordSubmit($forgot_password_link,$user_password);
				if ($last_id) {
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >Password Change Succefully.</span>");
				} else {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >Please try again.</span>");
				}

				redirect(base_url() . 'login');
			}
		}
	}

	

	public function getPaymentGatewayResponse(){
		
		// https://sitarahotelapartment.com/project/1
		$payment_gateway_response = array();
		$this->load->library('someclass');
		$workingKey='F27A519F332FE588317FDC3377C69120';//Shared by CCAVENUES
		
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=$this->someclass->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		
		for($i = 0; $i < $dataSize; $i++){
			$information=explode('=',$decryptValues[$i]);
			$payment_gateway_response[$information[0]] = $information[1];		
			
		}
		if(!empty($payment_gateway_response)){
			$user_id = $payment_gateway_response['merchant_param1'];
			$room_id = $payment_gateway_response['merchant_param2'];
			
			$last_id = $this->Home_Model->getPaymentGatewayResponse($payment_gateway_response);	

			$this->Home_Model->generateSession($user_id);
			//echo "inn";
			//echo "<pre>"; print_r($last_id); exit;
			if ($last_id) {
				$this->session->set_flashdata('suc_msg', "<span style='color:green' >Room Book Succefully.</span>");
				redirect(base_url() . 'dashboard');
			} else {
				$this->session->set_flashdata('suc_msg', "<span style='color:red' >Payment fail. Please try again.</span>");
				redirect(base_url() . 'product/'.$room_id);
			}
	

		}else{
			redirect(base_url());
		}
		
		

	
	}


	public function getPaymentGatewayResponse_old()
	{
		
		
	
		$this->load->library('someclass');
		$workingKey='F27A519F332FE588317FDC3377C69120';//Shared by CCAVENUES
		
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=$this->someclass->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	if($order_status==="Success")
	{
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";





	var_dump($encrypted_data);
	}


	public function buynow()
	{
		//echo "<pre>"; print_r($_POST); exit;
		if (!empty($this->input->post('submit'))) {
			$merchant_data = '';
			$merchant_id = "48750";
			$working_key = 'BA717F6DFF02A6ED886AAF2275B39F8B'; //Shared by CCAVENUES
			$access_code = 'AVDM04IL19BH89MDHB'; //Shared by CCAVENUES

			$working_key='F27A519F332FE588317FDC3377C69120';//Shared by CCAVENUES
			$access_code='AVIK04IL09CA00KIAC';//Shared by CCAVENUES

			$id = $this->input->post('id');
			$start_date_time = $this->input->post('room_start_date');
			$end_date_time = $this->input->post('room_end_date');
			$start_date_time = str_replace("/","-",$start_date_time);
			$end_date_time = str_replace("/","-",$end_date_time);


			//echo "<pre>"; print_r($start_date_time);print_r($end_date_time); exit;
			$user_id = $this->session->userdata('user_session')['logged_in'];
			//$user_id = 1;
			$where = array('r.id' => $id);
			$result = $this->Home_Model->getProducts($where);
			if (!empty($result)) {


				$result[0]->user_id = $user_id;
				$result[0]->start_date_time = $start_date_time;
				$result[0]->end_date_time = $end_date_time;
				//echo "<pre>"; print_r($result);print_r($end_date_time); exit;
				$order_id = $this->Home_Model->insertIntoOrder($result[0], $user_id);

				$payment_parameter = array(
				
					'merchant_id' =>  $merchant_id,
					'order_id' =>  $order_id,
					'amount' =>  $result[0]->after_discount_amount,
	
					'currency' =>  "INR",
					'redirect_url' =>  "https://sitarahotelapartment.com/getPaymentGatewayResponse",
					'cancel_url' =>  "https://sitarahotelapartment.com",
					'language' =>  "EN",
					'merchant_param1' => $user_id,
					'merchant_param2' =>   $id,
					'merchant_param3' =>  "EN",
					'mobile_number' => ''
	
				);

				if ($payment_parameter) {
					foreach ($payment_parameter as $key => $value) {
						$merchant_data .= $key . '=' . urlencode($value) . '&';
					}
				}
				$this->load->library('someclass');

				$encrypted_data = $this->someclass->encrypt($merchant_data, $working_key);
				$check_url = "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
				//$check_url = "https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction";
				
	
				?>
				<form method="post" name="redirect" action="<?php echo $check_url; ?>">
					<?php
					echo "<input type=hidden name=encRequest value=$encrypted_data>";
					echo "<input type=hidden name=access_code value=$access_code>";
					?>
				</form>
				<script language='javascript'>
					document.redirect.submit();
				</script>
				<?php

			}


		






		}
	}



	public function bookRoom()
	{

		echo "<pre>";
		print_r($_POST);
		exit;
		$data = $this->input->post(array(
			'tid' => 'tid',
			'merchant_id' => 'merchant_id',
			'order_id' => 'order_id',
			'amount' => 'amount',
			'currency' => 'currency',
			'redirect_url' => 'redirect_url',
			'cancel_url' => 'cancel_url',
			'language' => 'language',
			'delivery_name' => 'delivery_name',
			'delivery_address' => 'delivery_address',
			'delivery_city' => 'delivery_city',
			'delivery_state' => 'delivery_state',
			'delivery_zip' => 'delivery_zip',
			'delivery_country' => 'delivery_country',
			'delivery_tel' => 'delivery_tel'

		));
		$merchant_data = '';
		$working_key = 'change_with_your_working_key'; //Shared by CCAVENUES
		$access_code = 'change_with_your_access_code'; //Shared by CCAVENUES

		foreach ($data as $key => $value) {
			$merchant_data .= $key . '=' . $value . '&';
		}

		$this->load->library('someclass');

		$encrypted_data = $this->someclass->encrypt($merchant_data, $working_key);

		var_dump($encrypted_data);

		?>
		<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
			<?php
			echo "<input type=hidden name=encRequest value=$encrypted_data>";
			echo "<input type=hidden name=access_code value=$access_code>";
			?>
		</form>
		</center>
		<script language='javascript'>
			document.redirect.submit();
		</script>


<?php
		echo "Payment Works";
	}


	public function index()
	{

		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['rooms'] =  $this->db->where('is_deleted', '0')->get('rooms')->result();

		$slider_images = $this->Home_Model->getRoomImagesWithRoomType($data['rooms']);
		$data['room_type_with_images'] = $slider_images;

		$data['slider_images'] =  $this->db->where('title', 'home')->get('slider_images')->result();

		$data['home_explore_our_hotel'] =  $this->db->where('title', 'home_explore_our_hotel')->get('slider_images')->result();

		$home_gallery =  $this->db->where('title', 'home_gallery')->order_by("id", "desc")->get('slider_images')->result_array();
		$data['home_gallery_all'] = $home_gallery;
		$home_gallery = array_chunk($home_gallery, 6, true);
		$data['home_gallery'] = $home_gallery;


		$data['result'] =  $this->db->where('title', 'home')->get('pages')->row();
		$data['result2'] =  $this->db->where('title', 'home_2')->get('pages')->row();

		$data['main_contain'] = 'front/home_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function aboutUs()
	{

		$data['slider_images'] =  $this->db->where('title', 'about_us')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title', 'about_us')->get('pages')->row();

		$data['main_contain'] = 'front/aboutus_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function gallery()
	{

		$data['slider_images'] =  $this->db->where('title', 'gallery')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title', 'home_gallery')->order_by("id", "desc")->get('slider_images')->result();

		$data['main_contain'] = 'front/gallery_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function rooms()
	{
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();

		$slider_images = $this->Home_Model->getRoomTypesWithRooms();
		$data['slider_images'] = $slider_images;

		//echo "<pre>"; print_r($data); exit;

		$data['slider_imagesmain'] =  $this->db->where('title', 'about_us')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title', 'rooms')->get('pages')->row();
		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'front/rooms_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function privacyPolicy()
	{
		$data['slider_images'] =  $this->db->where('title', 'privacy_policy')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title', 'privacy_policy')->get('pages')->row();

		$data['main_contain'] = 'front/privacy_policy_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function termsAndConditions()
	{

		$data['slider_images'] =  $this->db->where('title', 'terms_and_conditions')->get('slider_images')->result();
		$data['result'] =  $this->db->where('title', 'terms_and_conditions')->get('pages')->row();

		$data['main_contain'] = 'front/terms_conditions_page/index';
		$this->load->view('front/includes/template', $data);
	}
	public function contact()
	{
		$data['slider_images'] =  $this->db->where('title', 'contact_us')->get('slider_images')->result();
		//$data['result'] =  $this->db->where('title', 'contact_us')->get('pages')->row();
		//$data['result2'] =  $this->db->where('title', 'contact_us_2')->get('pages')->row();

		$data['main_contain'] = 'front/contact_page/index';
		$this->load->view('front/includes/template', $data);
	}

	public function dashboard()
	{
		$user_id = $this->session->userdata('user_session')['logged_in'];
		//echo "<pre>"; print_r($user_id); exit;
		if($user_id){	
			$room_ids = array();
			$user_orders =  $this->db->select('room_id')->where('user_id', $user_id)->get('orders')->result();
		
		//	echo "<pre>"; print_r($user_orders); exit;
			if(!empty($user_orders)){
				foreach($user_orders as $row){
					$room_ids[] = $row->room_id;
				}

			}
			//echo "<pre>"; print_r($room_ids); exit;
			$this->db->where_in('r.id', $room_ids);
			
			$data['result']  = $this->Home_Model->getProducts();
			//echo "<pre>"; print_r($this->db->last_query()); exit;

		}else{
			$data['result'] = "";
		}
		
		
	
		
		
		$data['main_contain'] = 'front/dashboard_page/index';
		$this->load->view('front/includes/template', $data);
	}

	function feedback()
	{

		if (!empty($this->input->post('submit'))) {

			$this->form_validation->set_rules('feedback_subject', 'Room Type', 'required');
			$this->form_validation->set_rules('feedback_comment', 'Start Date', 'required');

			if (!$this->form_validation->run() == FALSE) {
				$rediret_url = $this->input->post('feedback_current_url');
				$insert = array(
					'feedback_sub' =>  $this->input->post('feedback_subject'),
					'feedback_msg' => $this->input->post('feedback_comment')
				);


				$last_id = $this->Home_Model->feedback($insert);
				if ($last_id) {
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >Feedback Send Succefully.</span>");
				} else {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >Please try again.</span>");
				}

				redirect($rediret_url);
			}
		}
	}





	public function product($id)
	{

		if ($id) {

			$where = array('r.id' => $id);
			$data['result']  = $this->Home_Model->getProducts($where);
			//echo "<pre>"; print_r($data); exit;
			

			if ($data['result']) {
				foreach ($data['result'] as $row) {
					$data['selected_data']['room_type']  = $row->room_type_id;
					$data['selected_data']['no_of_room']  = '1';
					$data['selected_data']['room_start_date']  = date("d/m/Y",strtotime( $d . " +1 days")); // date('d/m/Y');
					$data['selected_data']['room_end_date']  =  date("d/m/Y",strtotime($d . " +2 days"));
					$data['selected_data']['room_no_of_adult']  = 1;
					$data['selected_data']['room_no_of_children']  = 1;
				}
			}
		}
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}

	public function products()
	{


		$data['selected_data']['room_type']  = '';
		$data['selected_data']['no_of_room']  = '';
		$data['selected_data']['room_start_date']  = '';
		$data['selected_data']['room_end_date']  = '';
		$data['selected_data']['room_no_of_adult']  = '';
		$data['selected_data']['room_no_of_children']  = '';



		if (!empty($this->input->post('submit'))) {

			

			$this->form_validation->set_rules('room_type', 'Room Type', 'required');
			$this->form_validation->set_rules('no_of_room', 'Room', 'required');
			$this->form_validation->set_rules('room_start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('room_end_date', 'End Date', 'required');
			$this->form_validation->set_rules('room_no_of_adult', 'Number of Adult', 'required');
			$this->form_validation->set_rules('room_no_of_children', 'Number of Children', 'required');



			if (!$this->form_validation->run() == FALSE) {

				$room_type = $this->input->post('room_type');
				$no_of_room = $this->input->post('no_of_room');
				$room_start_date = $this->input->post('room_start_date');
				$room_end_date = $this->input->post('room_end_date');
				$room_no_of_adult = $this->input->post('room_no_of_adult');
				$room_no_of_children = $this->input->post('room_no_of_children');

				$data['selected_data']['room_type']  = $room_type;
				$data['selected_data']['no_of_room']  = $no_of_room;
				$data['selected_data']['room_start_date']  = $room_start_date;
				$data['selected_data']['room_end_date']  = $room_end_date;
				$data['selected_data']['room_no_of_adult']  = $room_no_of_adult;
				$data['selected_data']['room_no_of_children']  = $room_no_of_children;

				$where = array(
					'r.room_type_id' => $room_type,
					'r.is_free' => '1'
					

				);
				//echo "<pre>"; print_r($where); exit;
				//$data['room_wise_services'] =  $this->Home_Model->getRoomWiseServices($where);
				$data['result']  = $this->Home_Model->getProducts($where);
			} else {
				echo validation_errors();
				exit;
			}
		}else{
			$data['result']  = $this->Home_Model->getProducts();
		}

		

		//echo "<pre>"; print_r($data['result']); exit;

		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}


	public function login()
	{

		if (!empty($this->input->post('submit'))) {


			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			if (!$this->form_validation->run() == FALSE) {
				//echo "inn"; exit;
				$output_data = $this->Home_Model->postFrontLogin($this->input->post('user_email'), $this->input->post('user_password'));
				//echo "<pre>"; print_r($output_data); exit;
				if ($output_data['status']) {					
					//redirect(base_url() . 'dashboard', 'refresh');
					redirect(base_url());

				} else {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >".$output_data['message']."</span>");
					redirect(base_url() . 'login');
				}
			}
		}

		$data['main_contain'] = 'front/login_page/index';
		$this->load->view('front/includes/template', $data);
	}




	public function forgotPassword()
	{

		if (!empty($this->input->post('submit'))) {
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');

			if (!$this->form_validation->run() == FALSE) {
				$email = $this->input->post('user_email');		
				$find_user = $this->db->where('user_email', $email)->get('users')->row();

				if($find_user){
					$last_id = $this->Home_Model->forgotPassword($email);
					if ($last_id) {
						$this->session->set_flashdata('suc_msg_forgot', "<span style='color:green' >Reset password link send to your email address.</span>");
					} else {
						$this->session->set_flashdata('suc_msg_forgot', "<span style='color:red' >Sorry please try again after some time.</span>");
					}
				}else{
					$this->session->set_flashdata('suc_msg_forgot', "<span style='color:red' >This Email Address not available. Please check your email address.</span>");
				}

				
				
				redirect(base_url() . 'forgot-password');
			}
		}
		$data['main_contain'] = 'front/forgot_password_page/index';
		$this->load->view('front/includes/template', $data);
	}


	public function register()
	{


		if (!empty($this->input->post('submit'))) {

			$this->form_validation->set_rules('user_fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('user_confirm_password', 'Confirm Password', 'required|matches[user_password]');
			$this->form_validation->set_rules('user_checkbox', 'Terms and Conditions', 'required');


			if (!$this->form_validation->run() == FALSE) {

				$inser_data['user_fullname'] = $this->input->post('user_fullname');
				$inser_data['user_email'] = $this->input->post('user_email');
				$inser_data['user_password'] = md5($this->input->post('user_password'));
				$inser_data['user_role_id'] = 2;

				$find_user = $this->db->where('user_email', $this->input->post('user_email'))->get('users')->row();
				if (!$find_user) {
					$last_id = $this->Home_Model->FrontsubmitRegister($inser_data);
					if ($last_id) {
						$is_mail_send = $this->Home_Model->sendOTP($inser_data, $last_id);
						$this->session->set_flashdata('suc_msg_register', "<span style='color:green' >Congratulations, your account has been successfully created. Please verify your email address.</span>");
						redirect(base_url() . 'login');
					} else {
						$this->session->set_flashdata('suc_msg_register', "<span style='color:red' >Sorry please try again after some time.</span>");
					}
				} else {
					$this->session->set_flashdata('suc_msg_register', "<span style='color:red' >This Email Already Register.</span>");
					redirect(base_url() . 'login');
				}
			}
		}
		$data['main_contain'] = 'front/register_page/index';
		$this->load->view('front/includes/template', $data);
	}
}
