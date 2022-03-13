<?php
class Home_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
				$this->load->library('session');
				$this->load->library('database_library');
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

	public function buynow($id,$data){
		
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


			//echo "<pre>"; print_r($data); exit;
			
			$total_amount = $data['result'][0]->total_amount;
			$save_amount = $data['result'][0]->save_amount;

			

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
			

			//$user_id = $this->session->userdata('user_session')['logged_in'];
			$user_id = 1;
			

			$where = array('r.id' => $id);
			$result = $this->Home_Model->getProducts($where);

			

			if (!empty($result)) {
				
				if ($result[0]->is_free != 1) {
					$this->session->set_flashdata('suc_msg', "<span style='color:red' >This room is already occupied you can not book this room.</span>");
					redirect('bookRoom/' . $id);
				}

	
			

				$result[0]->user_id = $user_id;
				$result[0]->start_date_time = $start_date_time;
				$result[0]->end_date_time = $end_date_time;
				$result[0]->room_no_of_adult = $room_no_of_adult;
				$result[0]->room_no_of_children = $room_no_of_children;
				$result[0]->no_of_room = $no_of_room;
				$result[0]->total_room_amount = $total_amount;
				$result[0]->total_save_amount = $save_amount;
				
				$order_id = $this->Home_Model->insertIntoOrder($result[0], $user_id);

				//$total_amount = "0.01";
				$payment_parameter = array(

					'merchant_id' =>  $merchant_id,
					'order_id' =>  $order_id,
					'amount' =>  $total_amount,

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
				//echo "<pre>"; print_r($merchant_data); exit;
				

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
	

		
	function setVariablesFromSession(){
		$room_type = $this->session->userdata('room_type');
		$no_of_room = $this->session->userdata('no_of_room');
		$room_start_date = $this->session->userdata('room_start_date');
		$room_end_date = $this->session->userdata('room_end_date');
		$room_no_of_adult = $this->session->userdata('room_no_of_adult');
		$room_no_of_children = $this->session->userdata('room_no_of_children');


		if(!$room_start_date){

			$room_type = $this->session->userdata('room_type');
			$no_of_room = 1;
			$room_start_date = date("d-m-Y", strtotime($d . " +1 days")); // date('d/m/Y');
			$room_end_date = date("d-m-Y", strtotime($d . " +2 days"));
			$room_no_of_adult = 1;
			$room_no_of_children = 0;
		
		}
		

		$data['selected_data']['room_type']  = $room_type;
		$data['selected_data']['no_of_room']  = $no_of_room;
		$data['selected_data']['room_start_date']  = $room_start_date;
		$data['selected_data']['room_end_date']  = $room_end_date;
		$data['selected_data']['room_no_of_adult']  = $room_no_of_adult;
		$data['selected_data']['room_no_of_children']  = $room_no_of_children;

		$data['selected_data']['multiple_child']  = $room_no_of_children;

		return $data['selected_data'];
	}

	function setVariables(){

		$room_type = $data['selected_data']['room_type'] = $this->input->post('room_type');
		$no_of_room = $data['selected_data']['no_of_room'] = $this->input->post('no_of_room');
		$room_start_date = $data['selected_data']['room_start_date'] = $this->input->post('room_start_date');
		$room_end_date = $data['selected_data']['room_end_date'] = $this->input->post('room_end_date');
		$room_no_of_adult = $data['selected_data']['room_no_of_adult'] = $this->input->post('room_no_of_adult');
		$room_no_of_children = $data['selected_data']['room_no_of_children'] = $this->input->post('room_no_of_children');
		
		if(!$this->input->post('no_of_room')){
			$data['selected_data']['no_of_room']  = '1';
		}

		if(!$this->input->post('room_start_date')){
			$data['selected_data']['room_start_date']  = date("d-m-Y", strtotime($d . " +1 days")); // date('d/m/Y');;
		}

		if(!$this->input->post('room_end_date')){
			$data['selected_data']['room_end_date']  = date("d-m-Y", strtotime($d . " +2 days"));;
		}

		if(!$this->input->post('room_no_of_adult')){
			$data['selected_data']['room_no_of_adult']  = '1';
		}

		if(!$this->input->post('room_no_of_children')){
			$data['selected_data']['room_no_of_children']  = '0';
		}

		

		$this->form_validation->set_rules('room_type', 'Room Type', 'required');
		$this->form_validation->set_rules('no_of_room', 'Room', 'required');
		$this->form_validation->set_rules('room_start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('room_end_date', 'End Date', 'required');
		$this->form_validation->set_rules('room_no_of_adult', 'Number of Adult', 'required');
		$this->form_validation->set_rules('room_no_of_children', 'Number of Children', 'required');

		//echo "<pre>"; print_r($this->input->post()); exit;
		
		if (!$this->form_validation->run() == FALSE) {
			$room_type = $this->input->post('room_type');
			$no_of_room = $this->input->post('no_of_room');
			$room_start_date = $this->input->post('room_start_date');
			$room_end_date = $this->input->post('room_end_date');
			$room_no_of_adult = $this->input->post('room_no_of_adult');
			$room_no_of_children = $this->input->post('room_no_of_children');

			
			$child_age = $this->input->post('child_age');
			

			$you_want_extra_bed = $this->input->post('you_want_extra_bed');
			$you_want_breakfast = $this->input->post('you_want_breakfast');
			
			$data['selected_data']['multiple_child']  = $child_age;

			$extra_bed_count = 0;
			if($you_want_extra_bed){
				$extra_bed_count = $this->input->post('extra_bed_count');				
			}

			$child_age_count = 0;
			if($you_want_breakfast){
				$child_age = $this->input->post('child_age');	
				if($child_age){
					foreach($child_age as $row_age){
						if($row_age){
							$child_age_count ++;
						}
					}
				}			
			}
			
			

			$data['selected_data']['room_type']  = $room_type;
			$data['selected_data']['no_of_room']  = $no_of_room;
			$data['selected_data']['room_start_date']  = $room_start_date;
			$data['selected_data']['room_end_date']  = $room_end_date;
			$data['selected_data']['room_no_of_adult']  = $room_no_of_adult;
			$data['selected_data']['room_no_of_children']  = $room_no_of_children;

			$data['selected_data']['you_want_extra_bed']  = $you_want_extra_bed;
			$data['selected_data']['extra_bed_count']  = $extra_bed_count;

			$data['selected_data']['you_want_breakfast']  = $you_want_breakfast;
			$data['selected_data']['child_age_count']  = $child_age_count;

			$this->session->set_userdata($data['selected_data']);
			

		}else{
			echo validation_errors();
		}
		return $data['selected_data'];
	}

	function extraSetting(){
		return $result =  $this->db->from('extra_setting')->where('id',1)->get()->row();
	}


	function getRoomAmountFromRoomRate($date,$row){
		$selected_amount = 0;
		$year = (int) date('Y',strtotime($date));
		$month = (int) date('m',strtotime($date));;
		$day = (int) date('d',strtotime($date));;
		$selected_day = "day_".$day;
		$room_type_id = $row->room_type_id;
		
		$result =  $this->db
		->select($selected_day)
		->from('room_rates')
		->join('room_types', 'room_types.id = room_rates.room_type_id')
		->where('room_rates.year', $year)
		->where('room_rates.month', $month)
		->where('room_rates.room_type_id', $room_type_id)
		->order_by("room_rates.id", "desc")
		->get()->row();

		if($result){
			return $selected_amount = $result->$selected_day; 
		}
		return $selected_amount;
	}


	function setAmountAndDiscount($date1,$row,$room_amount_from_room_rate,$no_of_room){
						
			$room_amount_from_room_rate = $this->Home_Model->getRoomAmountFromRoomRate($date1,$row);
			$total_amount =   $room_amount_from_room_rate;							
			$save_amount =  ($row->save_percentage / 100) * (float)$total_amount;
			
			$after_discount_amount = (float)$total_amount - (float)$save_amount;

			$row->save_amount = $save_amount  * $no_of_room;
			$row->amount = $after_discount_amount  * $no_of_room;
			$row->total_amount =   $after_discount_amount  * $no_of_room;	
		
		
		return $row;
	}

	function bookRoom($id,$data){
	
		
		$no_of_room = $data['selected_data']['no_of_room'];
		$room_no_of_adult = $data['selected_data']['room_no_of_adult'];
		$room_no_of_children = $data['selected_data']['room_no_of_children'];
		$room_start_date = $data['selected_data']['room_start_date'];
		$room_end_date = $data['selected_data']['room_end_date'];

		$extra_bed_count = $data['selected_data']['extra_bed_count'];
		$child_age_count = $data['selected_data']['child_age_count'];

		$you_want_breakfast = $data['selected_data']['you_want_breakfast'];
		$you_want_extra_bed = $data['selected_data']['you_want_extra_bed'];

		
				
		$date1 = date("Y-m-d",strtotime($room_start_date));
		$date2 = date("Y-m-d",strtotime($room_end_date));

		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		
		$extra_setting  = $this->Home_Model->extraSetting();	
				
		$where = array('r.id' => $id);
		$new_result  = $this->Home_Model->getProducts($where);			
		if($new_result){
			foreach($new_result as $row){
				$row = $this->Home_Model->setAmountAndDiscount($date1,$row,$row->after_discount_amount,$no_of_room);

				
							

				if($room_no_of_adult > $no_of_room){
					$adult_no = $room_no_of_adult - $no_of_room;
					$adult_amount = ($adult_no * $extra_setting->extra_adult_amount);					
					$row->total_amount =  $row->total_amount +  $adult_amount;					
				}

				if($days){
					$adult_no = $room_no_of_adult - $no_of_room;
					$adult_amount = ($adult_no * $extra_setting->extra_adult_amount);					
					$row->total_amount =  $row->total_amount *  $days;					
				}

				if($extra_bed_count){				
					$extra_bed_amount = ($extra_bed_count * $extra_setting->extra_bed_amount);					
					$row->total_amount =  $row->total_amount +  $extra_bed_amount;					
				}

				
				if($you_want_breakfast){
					$adult_no = $room_no_of_adult;
					$adult_breakfast_amount = ($adult_no * $extra_setting->extra_adult_breakfast_amount);					
					$row->total_amount =  $row->total_amount +  $adult_breakfast_amount;	
					
					
					$child_breakfast_amount = ($child_age_count * $extra_setting->extra_child_breakfast_amount );					
					$row->total_amount =  $row->total_amount +  $child_breakfast_amount;
				}
			

				//$data['selected_data']['room_type']  = $row->room_type_id;
			}
		}
		$data['result'] = $new_result;
		
		return $data;
	}

	function getOrderStausByRoomId($room_id,$login_user_id){
		return $result =  $this->db->select('o.*')
		->from('orders as o')			
		->join('rooms as r','r.id = o.room_id')		
		->where('o.user_id', $login_user_id)
		->where('r.id', $room_id)
		->order_by("o.id", "desc")
		->get()->row();
	}

	function cancelBooking($room_id,$login_user_id){
		$result =  $this->db->select('o.*')
		->from('orders as o')			
		->join('rooms as r','r.id = o.room_id')		
		->where('o.user_id', $login_user_id)
		->where('r.id', $room_id)
		->get()->row();

		if($result){
			try {
				$this->db->set('status','Request for Cancellation')
				->where('o.user_id', $login_user_id)
				->where('o.room_id', $room_id)
				->update('orders as o'); 
				return true;
			} catch (Exception $e) {
				return false;
			}
		}
			
		
	}

	function createUserFromPaymentResponse($payment_gateway_response){
		$insert_data = array(
			'user_fullname' => $payment_gateway_response['billing_name'],   
			'user_email' => $payment_gateway_response['billing_email'],
			'user_mobile_no_1' => $payment_gateway_response['billing_tel'],
			'user_address' => $payment_gateway_response['billing_address'],
			'user_city' => $payment_gateway_response['billing_city'],
			'user_state' => $payment_gateway_response['billing_state'],
			'user_pincode' => $payment_gateway_response['billing_zip'],
			'user_country' => $payment_gateway_response['billing_country'],	
			'user_created_at' => date('Y-m-d H:i:s'),
		);
		  
		if($this->db->insert('users' , $insert_data))
			return $this->db->insert_id();
		else  
			return 0;
	}

	function sendMailToCustomer($payment_gateway_response,$order_datails){
		$room_type = 	 $this->db->where('id',$order_datails->room_id)->get('rooms')->row();
		

		$from = "fo@sitarahotelapartment.com";
		$to = $payment_gateway_response['billing_email'];
		$sub = "Room Book";		
		$comp_name =  "Sitara Hotel Apartment";

		$email_data['payment_gateway_response'] = $payment_gateway_response;
		$email_data['order_datails'] = $order_datails;
		$email_data['room_type'] = $room_type->name;
		
		$msg  = $this->load->view('front/email_template/send_mail_to_customer', $email_data,true);

		$this->load->library('database_library');
		$is_send = $this->database_library->sendEmail($from,$to,$sub,$msg,$comp_name);
	}

	function getPaymentGatewayResponse($payment_gateway_response){
		$insert_into_payment = array();
		if(!empty($payment_gateway_response)){

			//echo "<pre>"; print_r($payment_gateway_response);  exit;
			$insert_into_payment['order_id'] = $payment_gateway_response['order_id'];
			$insert_into_payment['room_id'] = $payment_gateway_response['merchant_param2'];
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

				$user_id = $this->createUserFromPaymentResponse($payment_gateway_response);

				$this->db->set('user_id', $user_id);
				$this->db->where('id', $payment_gateway_response['order_id']);
				$this->db->update('orders');

				$room_id = $payment_gateway_response['merchant_param2'];	
				$order_id = $payment_gateway_response['order_id'];		
				

				if(trim($payment_gateway_response['order_status'])  == 'Success'){		
					
					$order_datails = 	 $this->db->where('id',$order_id)->get('orders')->row();
					// echo "<pre>";
					// print_r(date('Y-m-d')); 
					// print_r(date('Y-m-d',strtotime($order_datails->start_date_time))); 
					// exit;
					
					if($order_datails){
						if(date('Y-m-d') == date('Y-m-d',strtotime($order_datails->start_date_time))){
							$this->db->set('is_free','0')->where('id', $room_id)->update('rooms'); 
							$this->db->set('status','Booked')->where('id', $order_id)->update('orders'); 
						}
					}

					$is_send_mail = $this->sendMailToCustomer($payment_gateway_response,$order_datails);

					
					

				}else{
				
					$this->db->set('is_free','1')->where('id', $room_id)->update('rooms'); 
					$this->db->set('status','Fail')->where('id', $order_id)->update('orders'); 
					return false;
				}
				return $user_id;
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
		
		$insert_data = array(
			'user_id' => $data->user_id,			
			'room_id' => $data->id,
			'no_of_children' => $data->room_no_of_children,
			'no_of_adults' => $data->room_no_of_adult, 
			'start_date_time' =>  date('Y-m-d 14:00:00',strtotime($data->start_date_time)) ,
			'end_date_time' =>  date('Y-m-d 12:00:00',strtotime($data->end_date_time)) ,
			'status' => 'pending',
			'after_discount_amount' => $data->total_room_amount,
			'save_amount' => $data->total_save_amount,
			'save_percentage' => $data->save_percentage,
			'created_at' => date('Y-m-d H:i:s'),
		);
		
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

				
				$row->images = $this->db->select('title,image')->where('room_type_id',$row->id)->get('slider_images')->result();
				
			}
		}

		return $result;
	}

	function getDashboardProducts($where = array()){

		if( count($where) > 0 ){
			$this->db->where($where);
		}
		// s.image as room_image,

		$result =  $this->db->select('r.*,r.name as heading,o.id as order_id ,o.status as order_status ')
		->from('rooms as r')
		->join('room_types as rt','rt.id = r.room_type_id')	
		->join('orders as o','o.room_id = r.id')				
		->where('r.is_deleted', 0)
		->where('rt.is_deleted', 0)
	
		->order_by('o.id')
		->get()->result();
		//echo "<pre>"; print_r($this->db->last_query()); exit;
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
	
