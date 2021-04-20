<?php defined('BASEPATH') or exit('No direct script access allowed');

class Prayer extends MX_Controller
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

		isLoginRedirect();
		isKenaRedirect();

		$language = $this->session->userdata('lang');
		$this->lang->load('dashboard', $language);
	}

	/****************************************/
	/************ Index Of Prayer ***********/
	/****************************************/
	public function index()
	{
		$this->load->view('Dashboard/header');
		$this->load->view('Prayer/addprayer');
		$this->load->view('Dashboard/footer');
	}

	/****************************************/
	/************** Add Prayer *************/
	/****************************************/
	public function addprayer()
	{
		$this->load->view('Dashboard/header');
		$this->load->view('Prayer/addprayer');
		$this->load->view('Dashboard/footer');
	}

	/****************************************/
	/************ Add New Prayers ***********/
	/****************************************/
	public function addnewprayer()
	{

		$errors = array();
		$success = array();
		$data = array();

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$errors['errorFormValidation'] = validation_errors();
			echo json_encode($errors);
		} else {

			$data['prayertitle'] = $this->input->post('title');
			$data['prayerdescription'] = $this->input->post('description');
			$data['userID'] = $this->session->user_id;
			$data['cdate'] = date("j F Y");

			$inserted = $this->db->insert('prayer', $data);
			if ($inserted == TRUE) {
				$succcess['success'] = "Successfully Inserted";
				echo json_encode($succcess);
			} else {
				$errors['notsuccess'] = 'Opps! Something Wrong';
				echo json_encode($errors);
			}
		}
	}

	/****************************************/
	/************ View All Prayers ***********/
	/****************************************/
	public function allprayers()
	{

		$userID = $this->session->user_id;
		$userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
			$data['prayer'] = $this->db->get_where('prayer', array('userID' => $userID))->result();
		} else {
			$data['prayer'] = $this->getTotal('prayer');
		}
		$this->load->view('Dashboard/header');
		$this->load->view('Prayer/allprayers', $data);
		$this->load->view('Dashboard/footer');
	}

	/****************************************/
	/************ Individual View Prayer ***********/
	/****************************************/
	public function view()
	{
		$data['individual'] = $this->getIndividual();
		$this->load->view('Dashboard/header');
		$this->load->view('Prayer/view', $data);
		$this->load->view('Dashboard/footer');
	}

	/****************************************/
	/************ Individual Edit Prayer ***********/
	/****************************************/
	public function edit()
	{
		$data['individual'] = $this->getIndividual();
		$this->load->view('Dashboard/header');
		$this->load->view('Prayer/edit', $data);
		$this->load->view('Dashboard/footer');
	}


	/****************************************/
	/************ Update Prayers ***********/
	/****************************************/
	public function update()
	{

		$errors = array();
		$success = array();
		$data = array();

		$prayerid = $this->input->post('prayerid');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$errors['errorFormValidation'] = validation_errors();
			echo json_encode($errors);
		} else {

			$data['prayertitle'] = $this->input->post('title');
			$data['prayerdescription'] = $this->input->post('description');
			$data['cdate'] = date("j F Y");

			$this->db->where('prayerid', $prayerid);
			$update = $this->db->update('prayer', $data);
			if ($update == TRUE) {
				$succcess['success'] = "Successfully Inserted";
				echo json_encode($succcess);
			} else {
				$errors['notsuccess'] = 'Opps! Something Wrong';
				echo json_encode($errors);
			}
		}
	}


	/****************************************/
	/************ Individual Delete Prayer ***********/
	/****************************************/
	public function delete($prayerid)
	{
		$this->db->where('prayerid', $prayerid);
		$deleted = $this->db->delete('prayer');
		if ($deleted == TRUE) {
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('dashboard/prayer/allprayers', 'refresh');
		} else {
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/prayer/allprayers', 'refresh');
		}
	}

	/****************************************/
	/************ Get Total Prayers ***********/
	/****************************************/
	public function getTotal($table)
	{
		$query = $this->db->get($table);
		return $query->result();
	}

	/****************************************/
	/************ Get Pagination Of Prayers ***********/
	/****************************************/
	public function getPagiData($limit, $start)
	{
		$this->db->limit($limit, $start);
		$query = $this->db->get('prayer');
		return $query->result();
	}

	/****************************************/
	/*************** Individual **************/
	/****************************************/
	public function getIndividual()
	{
		$prayerid = $this->uri->segment(4);
		$query = $this->db->get_where('prayer', array('prayerid' => $prayerid));
		return $query->result();
	}
}
