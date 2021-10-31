<?php
class Webservice_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
        }
		
	
	function submitLogin($data){
		return $this->db->select('*')
		->where('user_password',md5($data['user_pass']))
		->where('user_email', $data['user_email'])
		->get('users')->result();
	}
	
	function getAdminCategoriesList(){
		return $this->db->select('id,name')
		->where('admin_categories.is_active',1)
		->where('admin_categories.is_deleted',0)
		->get('admin_categories')->result();
	}
	
	function getAdminVideoList(){
		return $this->db->select('id,name')
		->where('video_categories.is_active',1)
		->where('video_categories.is_deleted',0)
		->get('video_categories')->result();
	}
	
	function getAdminCategoryNameById($category_id){
		return $this->db->select('name')
		->where('admin_categories.id',$category_id)
		->get('admin_categories')->row()->name;
	}
	
	function getAdminVideoCategoryNameById($category_id){
		return $this->db->select('name')
		->where('video_categories.id',$category_id)
		->get('video_categories')->row()->name;
	}
	
	
	function getImagesByAdminCategoryId($category_id){
		return $this->db->select('user_albums.id,user_albums.category_id,created_at,image')
		->where('user_albums.category_id',$category_id)
		->where('user_albums.user_id',1)
		->get('user_albums')->result();
	}
	
	function getVideoByAdminCategoryId($video_category_id){
		return $this->db->select('id,video_name,video_link,video_image,created_at')
		->where('videos.video_category_id',$video_category_id)
		->where('videos.is_active',1)
		->where('videos.is_deleted',0)
		->get('videos')->result();
	}
	
	
	function getImagesByUserCategoryId($category_id,$user_id){
		return $this->db->select('user_albums.id,user_albums.category_id,created_at')
		->where('user_albums.category_id',$category_id)
		->where('user_albums.user_id',$user_id)
		->get('user_albums')->result();
	}
	
	function userFeedback(){
		
		$data = array(
			'user_name' => $this->input->post('user_name'),
			'user_contact_no' => $this->input->post('user_contact_no'),
			'user_email' => $this->input->post('user_email'),
		);
		$this->db->insert('feedbacks',$data);
		echo true;
	}
	
	

//------------------------------------------------- feedback management end ------------------------------------------------------------------
	
}
	
