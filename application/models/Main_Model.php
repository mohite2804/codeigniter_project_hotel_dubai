<?php
class Main_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function cronRunOrNot()
	{
		$data = array(
			'run_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('cron_run', $data);
	}

	function updateRoomRateDaily()
	{
		$year = (int) date('Y');
		$month = (int) date('m');
		$day = (int) date('d');
		$database_day = "day_" . $day;

		$today_room_rate =  $this->db
			->select("room_type_id,$database_day")
			->from('room_rates')
			->where('year', $year)
			->where('month', $month)
			->get()->result();

		if (count($today_room_rate) > 0) {
			foreach ($today_room_rate as $row) {

				$this->db
					->set('amount', $row->$database_day)
					->set('after_discount_amount', $row->$database_day)
					->set('save_amount', '0.00')
					->set('save_percentage', '0.00')
					->set('amount', $row->$database_day)

					->where('room_type_id', $row->room_type_id)
					->update('rooms');
			}
		}
	}


	function updateRoomBooking()
	{
		$order_datails =  $this->db->select('o.*')
			->from('orders as o')
			->join('payment_details as p', 'p.order_id = o.id')
			->join('rooms as r', 'r.id = o.room_id')
			->where('p.order_status', 'Success')
			->order_by("o.id", "desc")
			->get()->result();


		if (count($order_datails) > 0) {
			foreach ($order_datails as $row) {
				if (date('Y-m-d') == date('Y-m-d', strtotime($row->start_date_time))) {
					$this->db->set('is_free', '0')->where('id', $row->room_id)->update('rooms');
					$this->db->set('status', 'Booked')->where('id', $row->id)->update('orders');
				}
			}
		}
	}


	function roomRateSetting()
	{
		$year = date('Y');

		$last_month = (int)date('m', strtotime("-1 month"));
		$next_month = (int)date('m', strtotime("+1 month"));
		$current_month = (int)date('m');

		$months = array($last_month, $next_month, $current_month);
		return $result =  $this->db
			->select('room_rates.*,room_types.name as room_type,room_types.short_name as room_short_name_type,')
			->from('room_rates')
			->join('room_types', 'room_types.id = room_rates.room_type_id')
			->where('year', $year)
			->where_in('month', $months)
			->order_by("id", "desc")
			->get()->result();
	}

	function getRoomTypeIdByshortCode($shortCode)
	{
		return $result =  $this->db->from('room_types')->where('short_name', $shortCode)->get()->row();
	}

	function insertDatatIntoRoomRates($insert_data)
	{
		try{
			
			$this->db->insert_batch('room_rates', $insert_data);
			return true;
		}catch (Exception $e) {
			
			return false;
		}
		
		
	}

	function CheckoutRoom($order_id)
	{
		$result =  $this->db->from('orders')->where('id', $order_id)->get()->row();

		if ($result) {
			try {
				$this->db->set('status', 'Completed')
					->where('id', $order_id)
					->update('orders');

				$this->db->set('is_free', '1')
					->where('id', $result->room_id)
					->update('rooms');

				return true;
			} catch (Exception $e) {
				return false;
			}
		}
	}

	function cancelApprove($order_id)
	{
		$result =  $this->db->from('orders')->where('id', $order_id)->get()->row();

		if ($result) {
			try {
				$this->db->set('status', 'Canceled')
					->where('id', $order_id)
					->update('orders');

				$this->db->set('is_free', '1')
					->where('id', $result->room_id)
					->update('rooms');

				return true;
			} catch (Exception $e) {
				return false;
			}
		}
	}

	function getServices($slug)
	{
		return $this->db->select('services.*,service_types.name as service_type_name,service_types.slug as service_type_slug')
			->from('services')
			->join('service_types', 'service_types.id = services.service_type_id')
			->where('services.is_deleted', '0')
			->where('service_types.is_deleted', '0')
			->where('service_types.slug', $slug)
			->order_by("services.id", "desc")

			->get()->result();
	}

	function getServiceById($id)
	{
		return $this->db->select('services.*,service_types.name as service_type_name,service_types.slug as service_type_slug')
			->from('services')
			->join('service_types', 'service_types.id = services.service_type_id')
			->where('services.is_deleted', '0')
			->where('services.is_deleted', '0')
			->where('services.id', $id)
			->order_by("services.id", "desc")
			->get()->row();
	}

	function getOrders($where = "")
	{
		$sql = "select o.*,u.user_fullname,u.user_email,u.user_mobile_no_1,u.user_mobile_no_2,rt.name as room_type,r.name as room_name
		from orders o 
		join users u on u.user_id = o.user_id
		join rooms r on r.id = o.room_id
		join room_types rt on rt.id = r.room_type_id
		order by o.id desc";

		if ($where) {
			$sql .= " where $where";
		}


		$query = $this->db->query($sql);
		return $query->result();
	}

	function getRoomTypes()
	{
		return $this->db->from('room_types')->where('is_deleted', '0')->get()->result();
	}

	function getRooms()
	{
		return $this->db
			->select('rooms.*,room_types.name as room_type')
			->from('rooms')
			->join('room_types', 'room_types.id  = rooms.room_type_id')
			->where('rooms.is_deleted', '0')
			->get()->result();
	}

	function extraSetting()
	{
		return $this->db->from('extra_setting')->where('id', 1)->get()->row();
	}

	function getRoomTypesById($id)
	{
		return $this->db->from('room_types')->where('id', $id)->get()->row();
	}

	function getRoomsById($id)
	{
		return $this->db->from('rooms')->where('id', $id)->get()->row();
	}

	function getRoomTypesImagesById($id)
	{
		return $this->db->from('slider_images')->where('room_type_id', $id)->get()->result();
	}

	function getRoomImagesById($id)
	{
		return $this->db->from('slider_images')->where('room_type_id', $id)->get()->result();
	}

	function getRoomServices()
	{
		return $this->db
			->select('services.*,service_types.name as service_type_name')
			->from('services')
			->join('service_types', 'service_types.id  = services.service_type_id')
			->where('services.is_deleted', 0)
			->where('service_types.is_deleted', 0)


			->get()->result();
	}


	function deleteService($id)
	{
		$this->db->set('is_deleted', '1');
		$this->db->where('id', $id);
		$this->db->update('services');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteRoomType($id)
	{
		$this->db->set('is_deleted', '1');
		$this->db->where('id', $id);
		$this->db->update('room_types');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteRoom($id)
	{
		$this->db->delete('slider_images', array('room_type_id' => $id));
		$this->db->delete('rooms', array('id' => $id));

		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteRoomTypeImage($id)
	{
		$this->db->delete('slider_images', array('id' => $id));
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteGallery($id)
	{

		$this->db->delete('slider_images', array('id' => $id));
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}
	function admin_email_check($email)
	{
		$id = $this->session->userdata('admin_session')['logged_in'];
		return $this->db->select('user_id')->where('user_id<>', $id)->where('user_email', $email)->get('users')->row();
	}

	function user_email_check($email, $user_id)
	{
		if ($user_id)
			return $this->db->select('user_id')->where('user_id<>', $user_id)->where('user_email', $email)->get('users')->row();
		else
			return $this->db->select('user_id')->where('user_email', $email)->get('users')->row();
	}

	function getProfileData($id)
	{
		return $this->db->select('user_id,user_fullname,user_password,user_name,user_email,user_address,user_mobile_no_1,user_mobile_no_2,user_pincode,user_image')
			->where('user_id', $id)->get('users')->row();
	}

	function getUsers()
	{
		return $this->db->select('user_id,user_fullname,user_password,user_name,user_email,user_birthday,user_address,user_mobile_no_1,user_mobile_no_2,user_pincode,user_image')
			->where(array('user_is_active' => 1, 'user_is_deleted' => 0, 'user_role_id' => 3))
			->get('users')->result();
	}



	function submitProfile()
	{
		$this->db->set($this->input->post());
		$this->db->where('user_id', $this->session->userdata('admin_session')['logged_in']);
		$this->db->update('users');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}




	function addUser()
	{
		if ($this->db->insert('users', $this->input->post()))
			return $this->db->insert_id();
		else
			return false;
	}

	function editUser($id)
	{
		$this->db->set($this->input->post());
		$this->db->where('user_id', $id);
		$this->db->update('users');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function getSiteInfo()
	{
		return $this->db->select('id,name,email,mobile_no_1,mobile_no_2,image,footer')
			->where('id', 1)->get('site_setting')->row();
	}

	function editSiteInformation()
	{
		$this->db->set($this->input->post());
		$this->db->where('id', 1);
		$this->db->update('site_setting');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}



	function getAdminAlbum()
	{
		return $this->db->select('admin_categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname')
			->from('user_albums')
			->join('users', 'user_albums.user_id = users.user_id')
			->join('admin_categories', 'admin_categories.id = user_albums.category_id')
			->where('users.user_is_active', 1)->where('users.user_is_deleted', 0)
			->where('users.user_role_id', 1)->where('users.user_id', 1)->where('user_albums.user_id', 1)
			->group_by(array("user_albums.user_id", "user_albums.category_id"))
			->get()->result();
	}

	function getUserAlbum()
	{
		return $this->db->select('categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname')
			->from('user_albums')
			->join('users', 'user_albums.user_id = users.user_id')
			->join('categories', 'categories.id = user_albums.category_id')
			->group_by(array("user_albums.user_id", "user_albums.category_id"))
			->get()->result();
	}

	function getCustomers()
	{
		return $this->db->select('user_id,user_fullname')
			->where('user_is_active', 1)->where('user_is_deleted', 0)
			->where('user_role_id', 3)
			->from('users')->get()->result();
	}

	function getHomePageAlbum()
	{
		return $this->db->select('id,image')
			->where('title', 'home_gallery')
			->from('slider_images')->get()->result();
	}

	function addUserAlbum($sql)
	{
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	function getAlbumDataByUserId($id)
	{
		return $this->db->select('categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname,user_albums.image')
			->from('user_albums')
			->join('users', 'user_albums.user_id = users.user_id')
			->join('categories', 'categories.id = user_albums.category_id')
			->where('user_albums.category_id', $id)
			->get()->result();
	}

	function getAdminAlbumDataByUserId($id)
	{
		return $this->db->select('admin_categories.name,user_albums.category_id,user_albums.id,user_albums.user_id,users.user_fullname,user_albums.image')
			->from('user_albums')
			->join('users', 'user_albums.user_id = users.user_id')
			->join('admin_categories', 'admin_categories.id = user_albums.category_id')
			->where('user_albums.category_id', $id)
			->get()->result();
	}

	function updateUserAlbum()
	{
		$this->db->set($this->input->post());
		$this->db->where('id', 1);
		$this->db->update('user_albums');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function getCategories()
	{
		return $this->db->select('id,name')
			->from('categories')
			->where('is_deleted', 0)
			->where('is_active', 1)
			->get()->result();
	}

	function getAdminCategories()
	{
		return $this->db->select('id,name')
			->from('admin_categories')
			->where('is_deleted', 0)
			->where('is_active', 1)
			->get()->result();
	}

	function userDelete($user_id)
	{
		$this->db->set('user_is_deleted', '1');
		$this->db->set('user_deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $user_id);
		$this->db->update('users');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteUserAlbum($id)
	{
		$this->db->delete('user_albums', array('id' => $id));
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}


	function getMessage()
	{
		return $this->db->select('send_messages.id,send_messages.user_id,send_messages.is_message,send_messages.email_template_id,send_messages.message,send_messages.created_at')
			->from('send_messages')
			//->join ('users' , 'users.user_id = send_messages.user_id','left')
			->get()->result();
	}

	function getEmailTemplate()
	{
		return $this->db->select('id,name,image')
			->from('email_templates')
			->get()->result();
	}

	function getEmailIdAndDeviceTokenByUserids($user_ids)
	{
		return $this->db->select('users.user_id,users.user_email,device_tokan,mobile_type')
			->from('users')
			->join('user_device_tokan_mobile_types', 'user_device_tokan_mobile_types.user_id = users.user_id', 'left')
			->where('user_is_active', 1)
			->where('user_is_deleted', 0)
			->where_in('users.user_id', $user_ids)
			->get()->result();
	}

	function getSiteEmail()
	{
		return $this->db->select('email,name')
			->from('site_setting')
			->get()->row();
	}

	function sendEmail($to, $msg)
	{
		$sub ="";
		$site_details = $this->getSiteEmail();
		$from = $site_details->email;
		$comp_name = $site_details->name;
		$this->load->library('database_library');
		$this->database_library->sendEmail($from, $to, $sub, $msg, $comp_name);
	}

	function getVideos()
	{
		return $this->db->select('id,video_name,video_link,video_image,created_at')
			->from('videos')
			->where('is_active', 1)
			->where('is_deleted', 0)
			->get()->result();
	}

	function editVideo($id)
	{
		return $this->db->select('id,video_link,video_name,video_image,created_at')
			->from('videos')
			->where('id', $id)
			->get()->row();
	}

	function updateVideo()
	{
		$this->db->set($this->input->post());
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('videos');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteVideo($id)
	{
		$this->db->set('is_deleted', '1');
		$this->db->where('id', $id);
		$this->db->update('videos');
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}


	function addVideo()
	{
		if ($this->db->insert('videos', $this->input->post()))
			return $this->db->insert_id();
		else
			return false;
	}


	//------------------------------------------------ feedback management start -------------------------------------------------------------------
	//countNotReadablyMail getInboxMail getSentMail getDraftMail 
	function countNotReadablyMail()
	{
		return $this->db->select('count(*) as not_readable')
			->from('feedbacks')
			->where('is_readable', 0)
			->where('is_deleted', 0)
			->where('inbox_send_draft', 1)
			->get()->row();
	}

	function getInboxMail()
	{
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
	function getSentMail()
	{
		return $this->db->select('*')
			->from('feedbacks')
			->where('is_deleted', 0)
			->where('inbox_send_draft', 2)
			->get()->result();
	}

	function getDraftMail()
	{
		return $this->db->select('*')
			->from('feedbacks')
			->where('is_deleted', 0)
			->where('inbox_send_draft', 3)
			->get()->result();
	}

	//------------------------------------------------- feedback management end ------------------------------------------------------------------

}
