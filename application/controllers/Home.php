<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		Parent::__construct();
		$this->load->library('session');
		$this->load->model('Home_Model');
		$this->load->model('Main_Model');
		$this->load->library('database_library');
		$this->load->library('Someclass');
		//$this ->is_logged_in();
		error_reporting(0);
		$this->Cronjob();
	}

	function emailtest(){
		$order_datails = 	 $this->db->where('id',1)->get('orders')->row();
		$room_type = 	 $this->db->where('id',$order_datails->room_id)->get('rooms')->row();

		$payment_gateway_response = '{"order_id":"102","tracking_id":"111025025451","bank_ref_no":"727646","order_status":"Success","failure_message":"","payment_mode":"Debit Card","card_name":"Visa Debit Card","status_code":"00","status_message":"APPROVED","currency":"AED","amount":"6267.0","billing_name":"Tatiana Oktysuk ","billing_address":"Gintovta st 26-66","billing_city":"Minsk ","billing_state":"","billing_zip":"220125","billing_country":"Belarus","billing_tel":"375291868373 ","billing_email":"Okt.tania@gmail.com","delivery_name":"Tatiana Oktysuk ","delivery_address":"Gintovta st 26-66","delivery_city":"Minsk ","delivery_state":"","delivery_zip":"null","delivery_country":"Belarus","delivery_tel":"375291868373 ","merchant_param1":"1","merchant_param2":"9","merchant_param3":"EN","merchant_param4":"","merchant_param5":"","vault":"N","offer_type":"null","offer_code":"null","discount_value":"0.0","mer_amount":"6267.0","eci_value":"05","card_holder_name":"","bank_qsi_no":"null","bank_receipt_no":"206414316902\u0004\u0004\u0004\u0004"}';
		$payment_gateway_response = json_decode($payment_gateway_response,true);
		$email_data['payment_gateway_response'] = $payment_gateway_response;
		$email_data['order_datails'] = $order_datails;
		$email_data['room_type'] = $room_type->name;
	
		//echo "<pre>"; print_r($email_data); exit;
		$msg  = $this->load->view('front/email_template/send_mail_to_customer', $email_data);
	}

	function Cronjob(){			
		
		try {
			
			$this->Main_Model->cronRunOrNot();
			$this->Main_Model->updateRoomBooking();
			$this->Main_Model->updateRoomRateDaily();
		} catch (\Exception $e) {
			echo "<pre>"; print_r($e); exit;
		}
		
		
	}


	public function buynow_old(){


		
		if (!empty($this->input->post('submit'))) {
			$this->form_validation->set_rules('room_no_of_adult', 'Number Of Adult', 'required');
			$this->form_validation->set_rules('room_no_of_children', 'Number of Children', 'required');

			$this->form_validation->set_rules('no_of_room', 'Number of Room', 'required');
			$this->form_validation->set_rules('room_start_date', 'Check In Date', 'required');
			$this->form_validation->set_rules('room_end_date', 'Check Out Date', 'required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('err_msg', "<div style='color:red' >" . validation_errors() . "</div>");
				redirect('bookRoom/' . $this->input->post('id'));
			}


			$merchant_data = '';

			// --------------------Demo details for payment gateway  --------------------------
			// $merchant_id = "48750";
			// $working_key = 'F27A519F332FE588317FDC3377C69120'; //Shared by CCAVENUES
			// $access_code = 'AVIK04IL09CA00KIAC'; //Shared by CCAVENUES
			// $currency = "INR";

			// --------------------Live details for payment gateway  --------------------------
			$merchant_id = "48750";
			$access_code = 'AVDM04IL19BH89MDHB'; //Shared by CCAVENUES			
			$working_key = 'BA717F6DFF02A6ED886AAF2275B39F8B'; //Shared by CCAVENUES
			$currency = "AED";


			$id = $this->input->post('id');
			$room_no_of_adult = $this->input->post('room_no_of_adult');
			$room_no_of_children = $this->input->post('room_no_of_children');
			$no_of_room = $this->input->post('no_of_room');

			$start_date_time = $this->input->post('room_start_date');
			$end_date_time = $this->input->post('room_end_date');
			
			$start_date_time = date("Y-m-d", strtotime($start_date_time));
			$end_date_time = date("Y-m-d", strtotime($end_date_time));

			$date1 = date_create($start_date_time);
			$date2 = date_create($end_date_time);
			$diff = date_diff($date1, $date2);
			$no_of_days = $diff->days;
			$data['selected_data']['no_of_days']  = $no_of_days;


			$user_id = $this->session->userdata('user_session')['logged_in'];

			$where = array('r.id' => $id);
			$result = $this->Home_Model->getProducts($where);
			if (!empty($result)) {

				if ($result[0]->is_free != 1) {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >This room is already occupied you can not book this room.</span>");
					redirect('product/' . $id);
				}

				$total_room_amount = $result[0]->after_discount_amount;
				if ($no_of_room) {
					$total_room_amount = $result[0]->after_discount_amount * $no_of_room;
				}

				$total_save_amount = $result[0]->save_amount;
				if ($no_of_room) {
					$total_save_amount = $result[0]->save_amount * $no_of_room;
				}

				if ($no_of_days > 1) {
					$total_room_amount = $total_room_amount * $no_of_days;
					$total_save_amount = $total_save_amount * $no_of_days;
				}

				$total_room_amount = round($total_room_amount);
				$total_save_amount = round($total_save_amount);

				$result[0]->user_id = $user_id;
				$result[0]->start_date_time = $start_date_time;
				$result[0]->end_date_time = $end_date_time;
				$result[0]->room_no_of_adult = $room_no_of_adult;
				$result[0]->room_no_of_children = $room_no_of_children;
				$result[0]->no_of_room = $no_of_room;
				$result[0]->total_room_amount = $total_room_amount;
				$result[0]->total_save_amount = $total_save_amount;

				$total_room_amount = "1";
				$order_id = $this->Home_Model->insertIntoOrder($result[0], $user_id);

				$payment_parameter = array(

					'merchant_id' =>  $merchant_id,
					'order_id' =>  $order_id,
					'amount' =>  $total_room_amount,

					'currency' =>  $currency,
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
				//$check_url = "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
				$check_url = "https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction";


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

	public function bookRoom($id){

		$current_url =  base_url(uri_string()); 
		$this->session->set_userdata('previous_url', $current_url);
		
	
		$data['selected_data'] = $this->Home_Model->setVariablesFromSession();	
		
		if (!empty($this->input->post('update_submit'))) {
			$data['selected_data']  = $this->Home_Model->setVariables();	
		}

		if (!empty($this->input->post('update_bed_breakfast'))) {
			
			$data['selected_data']  = $this->Home_Model->setVariables();	
		}

										
		$data = $this->Home_Model->bookRoom($id,$data);		
		

		if (!empty($this->input->post('submitBookNow'))) {	
			$data['selected_data']  = $this->Home_Model->setVariables();	
			$data = $this->Home_Model->bookRoom($id,$data);	
			
			$this->Home_Model->buynow($id,$data);			
		}

		$data = $this->Home_Model->bookRoom($id,$data);	

		
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/bookRoom/index';
		$this->load->view('front/includes/template', $data);
	}


	public function products(){
		$data['selected_data']  = $this->Home_Model->setVariables();


		if (!empty($this->input->post('submit'))) {
				
			$room_type = $data['selected_data']['room_type'];
			
			
			$where = array(
				'r.room_type_id' => $room_type,
				'r.is_free' => '1'
			);
			
			$result  = $this->Home_Model->getProducts($where);					
			
			$new_result = array();
			if(count($result) > 0){					
				foreach($result as $row){	
					$data_selected = $this->Home_Model->bookRoom($row->id,$data);					
					$new_result[] = $data_selected['result'][0];
				}
			}
						
			$data['result'] = $new_result;


			$where = array(
				'r.room_type_id<>' => $room_type,
				'r.is_free' => '1'
			);

			
			
			$other_rooms  = $this->Home_Model->getProducts($where);
			$new_result_other_room = array();
			if(count($other_rooms) > 0){					
				foreach($other_rooms as $row){	
					$data_other = $this->Home_Model->bookRoom($row->id,$data);					
					$new_result_other_room[] = $data_other['result'][0];
				}
			}

			$data['other_rooms'] = $new_result_other_room;

		}

		
		//echo "<pre>"; print_r($data); exit;
		
		///exit;
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}

	public function products_old(){


		$data['selected_data']['room_type']  = '';
		$data['selected_data']['no_of_room']  = '';
		$data['selected_data']['room_start_date']  = '';
		$data['selected_data']['room_end_date']  = '';
		$data['selected_data']['room_no_of_adult']  = '';
		$data['selected_data']['room_no_of_children']  = '';
		$data['selected_data']['room_start_date']  = date("d-m-Y", strtotime($d . " +1 days")); // date('d/m/Y');
		$data['selected_data']['room_end_date']  =  date("d-m-Y", strtotime($d . " +2 days"));



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
			
				
 
 				$this->session->set_userdata($data['selected_data']);

				$start_date_time = date("Y-m-d", strtotime($room_start_date));
				$end_date_time = date("Y-m-d", strtotime($room_end_date));

				$date1 = date_create($start_date_time);
				$date2 = date_create($end_date_time);
				$diff = date_diff($date1, $date2);
				$no_of_days = $diff->days;
				$data['selected_data']['no_of_days']  = $no_of_days;

				

				$where = array(
					'r.room_type_id' => $room_type,
					'r.is_free' => '1'
				);

				$result  = $this->Home_Model->getProducts($where);			
				
				$where = array(
					'r.room_type_id<>' => $room_type,
					'r.is_free' => '1'
				);
				
				$other_rooms  = $this->Home_Model->getProducts($where);

				$new_result = array();
				if($result){
					foreach($result as $row){						
						$new_result[] = $row;
					}
				}
				if($other_rooms){
					foreach($other_rooms as $row){
						$new_result[] = $row;
					}
				}
				
				if($new_result){
					foreach($new_result as $row){
						$row->total_amount =  $row->after_discount_amount * $no_of_room;
						$row->save_amount =  $row->save_amount * $no_of_room;
					}
				}
				$data['result'] = $new_result;
								
			} else {

				$this->session->set_flashdata('err_msg', "<div style='color:red' >" . validation_errors() . "</div>");
				redirect($_SERVER['REQUEST_URI'], 'refresh');
			}
		} else {
			$data['result']  = $this->Home_Model->getProducts();
		}


		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}



	public function product_old_change($id){

		if ($id) {

			$data['selected_data']  = $this->Home_Model->setVariables();
			$data = $this->Home_Model->bookRoom($id,$data);		
			
		}
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}

	public function product_old($id){

		if ($id) {

			$where = array('r.id' => $id);
			$data['result']  = $this->Home_Model->getProducts($where);



			if ($data['result']) {
				foreach ($data['result'] as $row) {
					$data['selected_data']['room_type']  = $row->room_type_id;
					$data['selected_data']['no_of_room']  = '1';
					$data['selected_data']['room_start_date']  = date("d-m-Y", strtotime($d . " +1 days")); // date('d/m/Y');
					$data['selected_data']['room_end_date']  =  date("d-m-Y", strtotime($d . " +2 days"));
					$data['selected_data']['room_no_of_adult']  = 1;
					$data['selected_data']['room_no_of_children']  = 0;
				}
			}
		}
		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['main_contain'] = 'front/products_page/product';
		$this->load->view('front/includes/template', $data);
	}

	

	








	public function getPaymentGatewayResponse()
	{

		// https://sitarahotelapartment.com/project/1
		$payment_gateway_response = array();
		$this->load->library('someclass');
		//$workingKey = 'F27A519F332FE588317FDC3377C69120'; //Shared by CCAVENUES for demo
		$workingKey = 'BA717F6DFF02A6ED886AAF2275B39F8B'; //Shared by CCAVENUES for Live

		$encResponse = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString = $this->someclass->decrypt($encResponse, $workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status = "";
		$decryptValues = explode('&', $rcvdString);
		$dataSize = sizeof($decryptValues);

		for ($i = 0; $i < $dataSize; $i++) {
			$information = explode('=', $decryptValues[$i]);
			$payment_gateway_response[$information[0]] = $information[1];
		}
		if (!empty($payment_gateway_response)) {
			$user_id = $payment_gateway_response['merchant_param1'];
			$room_id = $payment_gateway_response['merchant_param2'];

			$user_id = $this->Home_Model->getPaymentGatewayResponse($payment_gateway_response);

			//$this->Home_Model->generateSession($user_id);
			
			if ($user_id) {
				$this->session->set_flashdata('suc_msg', "<span style='color:green' >Room Book Succefully.</span>");
				redirect(base_url() . 'dashboard/'.$user_id);
			} else {
				$this->session->set_flashdata('suc_msg', "<span style='color:red' >Payment fail. Please try again.</span>");
				redirect(base_url() . 'product/' . $room_id);
			}
		} else {
			redirect(base_url());
		}
	}


	function cancelBooking($room_id, $login_user_id){
		$room_id =  base64_decode(urldecode($room_id));
		$login_user_id =  base64_decode(urldecode($login_user_id));


		$is_cancled =  $this->Home_Model->cancelBooking($room_id, $login_user_id);
		if ($is_cancled) {
			$this->session->set_flashdata('suc_msg', "<span style='color:green' >Canceled Request send to Admin Succefully.</span>");
		} else {
			$this->session->set_flashdata('suc_msg', "<span style='color:red' >Please try again.</span>");
		}
		redirect(base_url() . 'dashboard');
	}

	function logout(){
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
		$is_get_result =  $this->db->where('email_verify_link', $email_verify_link)->get('users')->row();
		$this->session->set_flashdata('suc_msg_register', "<span style='color:red' >Sorry please try again after some time.</span>");
		if ($is_get_result) {
			$this->db->set('is_verify_email', '1');
			$this->db->where('email_verify_link', $email_verify_link);
			$this->db->update('users');
			$this->session->set_flashdata('suc_msg_register', "<span style='color:green' >Your email is verify. thanks.</span>");
		}


		redirect(base_url() . 'login');
	}

	function resetPassword($forgot_password_link)
	{

		$is_get_result =  $this->db->where('forgot_password_link', $forgot_password_link)->get('users')->row();
		///echo "<pre>"; print_r($is_get_result); exit;

		if ($is_get_result) {
		} else {
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
				$last_id = $this->Home_Model->resetPasswordSubmit($forgot_password_link, $user_password);
				if ($last_id) {
					$this->session->set_flashdata('suc_msg', "<span style='color:green' >Password Change Succefully.</span>");
				} else {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >Please try again.</span>");
				}

				redirect(base_url() . 'login');
			}
		}
	}



	






	public function index()
	{

		$data['room_types'] =  $this->db->where('is_deleted', '0')->get('room_types')->result();
		$data['rooms'] =  $this->db->from('rooms as r')
		->select('r.*')
		->join('room_types as rt','rt.id = r.room_type_id')
		->where('r.is_deleted', '0')
		->get()->result();

		$slider_images = $this->Home_Model->getRoomImagesWithRoomType($data['rooms']);
		//echo "<pre>";  print_r($slider_images); exit;
		$data['room_type_with_images'] = $slider_images;

		$data['slider_images'] =  $this->db->where('title', 'home')->get('slider_images')->result();

		$data['home_explore_our_hotel'] =  $this->db->where('title', 'home_explore_our_hotel')->get('slider_images')->result();

		$home_gallery =  $this->db->where('title', 'home_gallery')->order_by("id", "desc")->get('slider_images')->result_array();
		$data['home_gallery_all'] = $home_gallery;
		$home_gallery = array_chunk($home_gallery, 6, true);
		$data['home_gallery'] = $home_gallery;


		$data['result'] =  $this->db->where('title', 'home')->get('pages')->row();
		$data['result2'] =  $this->db->where('title', 'home_2')->get('pages')->row();

		//$data['selected_data']['room_type']  = ;
		$data['selected_data']['no_of_room']  = '1';
		$data['selected_data']['room_start_date']  = date("d-m-Y", strtotime($d . " +1 days")); // date('d/m/Y');
		$data['selected_data']['room_end_date']  =  date("d-m-Y", strtotime($d . " +2 days"));
		$data['selected_data']['room_no_of_adult']  = 1;
		$data['selected_data']['room_no_of_children']  = 0;

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
		$user_id = $this->uri->segment(2);
		//$user_id = $this->session->userdata('user_session')['logged_in'];
		//echo "<pre>"; print_r($user_id); exit;
		if ($user_id) {
			$room_ids = array();
			$user_orders =  $this->db->select('room_id')
				->where('user_id', $user_id)
				->where('status', 'Booked')
				->get('orders')->result();
			if (!empty($user_orders)) {
				foreach ($user_orders as $row) {
					$room_ids[] = $row->room_id;
					$room_ids = array_unique($room_ids);
				}
			}
			//echo "<pre>"; print_r($room_ids); exit;
			if ($room_ids) {
				$this->db->where_in('r.id', $room_ids);
				$result = $this->Home_Model->getProducts();
				if ($result) {
					foreach ($result as $row) {
						$this->db->where_in('o.status', 'Booked');
						$order_result = $this->Home_Model->getOrderStausByRoomId($row->id, $user_id);

						$row->order_id = $order_result->id;
						$row->order_no_of_children = $order_result->no_of_children;
						$row->order_no_of_adults = $order_result->no_of_adults;
						$row->order_start_date_time = date('m/d/Y', strtotime($order_result->start_date_time));
						$row->order_end_date_time = date('m/d/Y', strtotime($order_result->end_date_time));
						$row->order_status = $order_result->end_date_time;
						$row->after_discount_amount = $order_result->after_discount_amount;
						$row->save_amount = $order_result->save_amount;
					}
				}
			}





			$data['result'] = $result;
			//echo "<pre>"; print_r($data['result']); exit;

			//echo "<pre>"; print_r($this->db->last_query()); exit;

		} else {
			$data['result'] = "";
		}



		//echo "<pre>"; print_r($data['result']); exit;

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


	

	public function roomDetails($id){

		if ($id) {
			$where = array('r.id' => $id);
			$data['result']  = $this->Home_Model->getProducts($where);
		}
		$where = array('r.is_free' => 1, 'r.is_deleted' => 0, 'r.is_active' => 1);
		$data['other_rooms'] =   $this->Home_Model->getProducts($where);

		//echo "<pre>"; print_r($data); exit;
		$data['main_contain'] = 'front/roomDetails/index';
		$this->load->view('front/includes/template', $data);
	}


	


	public function login(){

		if (!empty($this->input->post('submit'))) {


			$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			if (!$this->form_validation->run() == FALSE) {
				//echo "inn"; exit;
				$output_data = $this->Home_Model->postFrontLogin($this->input->post('user_email'), $this->input->post('user_password'));
				//echo "<pre>"; print_r($_SESSION); exit;
				if ($output_data['status']) {
					
					if($this->session->userdata('previous_url')){
						$previous_url = $this->session->userdata('previous_url');
						$this->session->unset_userdata('previous_url');
						redirect($previous_url);
						
					}else{
						redirect(base_url());
					}
					
				} else {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >" . $output_data['message'] . "</span>");
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

				if ($find_user) {
					$last_id = $this->Home_Model->forgotPassword($email);
					if ($last_id) {
						$this->session->set_flashdata('suc_msg_forgot', "<span style='color:green' >Reset password link send to your email address.</span>");
					} else {
						$this->session->set_flashdata('suc_msg_forgot', "<span style='color:red' >Sorry please try again after some time.</span>");
					}
				} else {
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
