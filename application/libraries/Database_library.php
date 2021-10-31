<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Database_library {

   
   function __construct() {
     $this->CI =& get_instance();
	
   }
   
   function checkLogin(){
	  if($this->CI->session->has_userdata('admin_session'))
		  return true;
	  else
		  return false;
	  
   }

	function postAdminLogin($email,$pass){
			$where = array('user_email' => $email,'user_password' => md5($pass),'user_role_id' => 1);
			$this->CI->db->select('user_id,user_name,user_fullname,user_image,user_email');
			$this->CI->db->where($where);
			$query = $this->CI->db->get('users');
			$result = $query->row();
			if(isset($result)){
				$newdata = array(
					'user_fullname'  => $result->user_fullname,
					'email'     => $result->user_email,
					'logged_in' => $result->user_id,
					'user_image' => $result->user_image
				);
				$this->CI->session->set_userdata('admin_session',$newdata);
				//echo "<pre>"; print_r($_SESSION); exit;
				return true;
			}else{
				return false;
			}
			
	}

	
	
	function uploadImage($image_file,$directory){
		if ($image_file && $directory) {
			$filename = $_FILES[$image_file]["name"];
			$_FILES[$image_file]["name"] = time().$filename;
			$config = array(
				'upload_path' => './'.$directory, 
				'allowed_types' => 'jpg|jpeg|gif|png',
			 );
			$this ->CI-> load -> library("upload", $config);
			if ($this ->CI-> upload -> do_upload($image_file)) {
				$image_data = $this ->CI-> upload -> data();
				return $newimagename = $image_data["file_name"];
			}else{
			return false;
			
			}
		}
	}
	function resizeImage($height,$width,$source_path,$destination_path){
		$config['image_library'] = 'gd2';
		$config['source_image'] = $source_path;
		$config['new_image'] = './'.$destination_path;
		$config['create_thumb'] = TRUE;
		$config['thumb_marker'] = '';
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->CI->load->library('image_lib', $config);
		if($this->CI->image_lib->resize())
			return true;
		else
			return false;
	}
	
	//$upload_path = "./uploads/products/";
	//$image_title = "user_album_";
	//$image_file = "user_album_images";
	function multipleImageUpload($upload_path,$image_file,$image_title){
		
		$config = array(
			'upload_path' => $upload_path, 
			'allowed_types' => 'jpg|jpeg|gif|png'
			
		 );
		$this ->CI-> load -> library('upload', $config);
		$images = array();
		$files = $_FILES[$image_file];

		foreach ($files['name'] as $key => $image) {

			$_FILES['images[]']['name'] = $files['name'][$key];
			$_FILES['images[]']['type'] = $files['type'][$key];
			$_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
			$_FILES['images[]']['error'] = $files['error'][$key];
			$_FILES['images[]']['size'] = $files['size'][$key];
			$title = $image_title . time();
			$fileName = $title . '_' . $files['name'][$key];
			$images[] = $fileName;
			$newimagenames[] = $fileName;
			$config['file_name'] = $fileName;
			$this ->CI-> upload -> initialize($config);

			if ($this ->CI-> upload -> do_upload('images[]')) {
				$image_detail_data = $this ->CI-> upload -> data();
				$this ->CI-> load -> library("image_lib");
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_detail_data["full_path"];
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '';
				$config['maintain_ratio'] = TRUE;
				
				$config['new_image'] = $upload_path.'100x100/';
				$config['width'] = 100;
				$config['height'] = 100;
				$this ->CI-> image_lib -> initialize($config);
				$this ->CI-> image_lib -> resize();
			}
			
			if ($this ->CI-> upload -> do_upload('images[]')) {
				$image_detail_data = $this ->CI-> upload -> data();
				$this ->CI-> load -> library("image_lib");
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_detail_data["full_path"];
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '';
				$config['maintain_ratio'] = TRUE;
				$config['new_image'] = $upload_path.'500x500/';
				$config['width'] = 500;
				$config['height'] = 500;
				$this ->CI-> image_lib -> initialize($config);
				$this ->CI-> image_lib -> resize();
			}
			
			if ($this ->CI-> upload -> do_upload('images[]')) {
				$image_detail_data = $this ->CI-> upload -> data();
				$this ->CI-> load -> library("image_lib");
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_detail_data["full_path"];
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '';
				$config['maintain_ratio'] = TRUE;
				$config['new_image'] = $upload_path.'300x300/';
				$config['width'] = 300;
				$config['height'] = 300;
				$this ->CI-> image_lib -> initialize($config);
				$this ->CI-> image_lib -> resize();
			}
		}
		return $newimagenames;
	}
	
	function sendEmail($from,$to,$subject,$message,$name){

		$this->CI->load->library('email');
		$this->CI->email->from($from, $name);
		$this->CI->email->to($to);
		$this->CI->email->cc('another@another-example.com');
		$this->CI->email->bcc('them@their-example.com');
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);
		if($this->CI->email->send())
			return true;
		else
			return false;
		

	}
	
	function calculateLagnitudeLatitude($address){
		//$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;
		$data['lat'] = $lat;
		$data['long'] = $long;
		return $data;
		//echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;
	}
	
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
    	} else {
			return $miles;
		}
	}

	
	function setJsonEncode($data){
		return json_encode($data);
	}
   
    
	
}