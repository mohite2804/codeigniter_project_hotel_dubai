<?php
header('Access-Control-Allow-Origin:*');

defined('BASEPATH') OR exit('No direct script access allowed');



class Webservice extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		$this->load->model('Webservice_Model','Web');
		$this->load->library('database_library');

	}
	

//------------------------------------- webservice code start------------------------------------------------------	
	public function getAdminCategoryImages(){
		
		$data['admin_category_list'] = $this->Web->getAdminCategoriesList();
		$data['admin_video_list'] = $this->Web->getAdminVideoList();
		
		$category_id = $data['admin_category_list'][0]->id;
		$data['catgory_name'] = $this->Web->getAdminCategoryNameById($category_id );
		$data['result'] = $this->Web->getImagesByAdminCategoryId($category_id);
		echo $this->jsonEncode($data);
		
	}
	
	public function getImagesByAdminCategoryId($category_id){
		$data['admin_category_list'] = $this->Web->getAdminCategoriesList();
		$data['catgory_name'] = $this->Web->getAdminCategoryNameById($category_id );
		$data['result'] = $this->Web->getImagesByAdminCategoryId($category_id);
		echo $this->jsonEncode($data);
		
	}
	
	public function getVideoByAdminCategoryId($category_id){
		$data['admin_category_list'] = $this->Web->getAdminCategoriesList();
		$data['admin_video_list'] = $this->Web->getAdminVideoList();
		$data['catgory_name'] = $this->Web->getAdminVideoCategoryNameById($category_id );
		$data['result'] = $this->Web->getVideoByAdminCategoryId($category_id);
		echo $this->jsonEncode($data);
		
	}
	
	
	public function submitLogin(){
		$data = (array)json_decode(file_get_contents("php://input"));
		$data = $this->Web->submitLogin($data);
		echo $this->jsonEncode($data);
	}
	
	public function getVideoByCategoryId(){
		$video_category_id = 1;
		$data['result'] = $this->Web->getVideoByCategoryId($video_category_id);
		echo $this->jsonEncode($data);
	}
	
	public function getImagesByUserCategoryId($category_id,$user_id){
		$category_id = 1; $user_id = 2;
		$data['result'] = $this->Web->getImagesByUserCategoryId($category_id,$user_id);
		echo $this->jsonEncode($data);
	}
	
	
	
	public function userFeedback(){
		$data['last_insert_id'] = $this->Web->userFeedback();
		echo $this->jsonEncode($data);
	}
	
	
	function jsonEncode($data){
		return json_encode($data);
	}
//------------------------------------- webservice code end ------------------------------------------------------		
	
}

