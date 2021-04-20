<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends MX_Controller
{

	/*
| -----------------------------------------------------
| PRODUCT NAME: ONEZEROART CHURCH MANAGEMENT SYSTEM (CHMS)
| -----------------------------------------------------
| AUTHOR: ONEZEROART TEAM
| -----------------------------------------------------
| EMAIL: support@onezeroart.com
| -----------------------------------------------------
| COPYRIGHT: RESERVED BY ONEZEROART.COM
| -----------------------------------------------------
| WEBSITE: http://onezeroart.com
| -----------------------------------------------------
*/


	function __construct()
	{
		parent::__construct();

		if (isLogin() == TRUE) {
			redirect('access/login', 'refresh');
		}
	}

	public function index()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_position');
		$this->session->unset_userdata('logged_in', FALSE);
		$this->session->unset_userdata('license_status', FALSE);
		$this->session->sess_destroy();

		$session_msg = array();
		$session_msg['logout_msg'] = 'You are successfully logout';
		$this->session->set_flashdata($session_msg);
		redirect('access/login', 'refresh');
	}

	/*****************************/
	/***** Get Basic Info ********/
	/*****************************/
	public function getBasicInfo()
	{
		$query = $this->db->get('websitebasic');
		return $query->result();
	}
}
