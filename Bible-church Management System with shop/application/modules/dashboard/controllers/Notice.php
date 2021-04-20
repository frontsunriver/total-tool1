<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends MX_Controller {
    
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

	function __construct() {
		parent::__construct();
		
		isLoginRedirect();
		isKenaRedirect();
		
		$language = $this->session->userdata('lang');		
		$this->lang->load('dashboard', $language);
	}
	
	/****************************************/
	/************ Index Of Notice ***********/
	/****************************************/
	public function index(){
		$this->load->view('Dashboard/header');
		$this->load->view('Notice/addnotice');
		$this->load->view('Dashboard/footer');
	}
	
	/****************************************/
	/************** Add Notice *************/
	/****************************************/
	public function addnotice(){
		$this->load->view('Dashboard/header');
		$this->load->view('Notice/addnotice');
		$this->load->view('Dashboard/footer');
	}
	
	/****************************************/
	/************ Add New Notices ***********/
	/****************************************/
	public function addnewnotice(){	
			
		$errors = array();
		$success = array();		
		$data = array();
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Date', 'trim|required');
		if($this->form_validation->run() == FALSE){
			$errors['errorFormValidation'] = validation_errors();				
			echo json_encode($errors);
		}else{
		
			$data['noticetitle'] = $this->input->post('title');
			$data['noticedescription'] = $this->input->post('description');
                        $data['cdate'] = date("j F Y");
			
			$inserted = $this->db->insert('notice', $data);
			if($inserted == TRUE){
				$succcess['success'] = "Successfully Inserted";
				echo json_encode($succcess);
			}else{
				$errors['notsuccess'] = 'Opps! Something Wrong';					
				echo json_encode($errors);
			}
		}	
	}
	
	/****************************************/
	/************ View All Notices ***********/
	/****************************************/
	public function allnotices(){            
		$table = "notice";
		$data['notice'] = $this->getTotal($table);		
		$this->load->view('Dashboard/header');
		$this->load->view('Notice/allnotices', $data);
		$this->load->view('Dashboard/footer');
	}
	
	/****************************************/
	/************ Individual View Notice ***********/
	/****************************************/
	public function view(){
		$data['individual'] = $this->getIndividual();
		$this->load->view('Dashboard/header');
		$this->load->view('Notice/view', $data);
		$this->load->view('Dashboard/footer');
	}
	
	/****************************************/
	/************ Individual Edit Notice ***********/
	/****************************************/
	public function edit(){
		$data['individual'] = $this->getIndividual();
		$this->load->view('Dashboard/header');
		$this->load->view('Notice/edit', $data);
		$this->load->view('Dashboard/footer');
	}
	
	
	/****************************************/
	/************ Update Notices ***********/
	/****************************************/
	public function update(){	
			
		$errors = array();
		$success = array();		
		$data = array();
		
		$noticeid = $this->input->post('noticeid');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == FALSE){
			$errors['errorFormValidation'] = validation_errors();				
			echo json_encode($errors);
		}else{
		
			$data['noticetitle'] = $this->input->post('title');
			$data['noticedescription'] = $this->input->post('description');
                        $data['cdate'] = date("j F Y");
			
			$this->db->where('noticeid', $noticeid);
			$update = $this->db->update('notice', $data);
			if($update == TRUE){
				$succcess['success'] = "Successfully Inserted";
				echo json_encode($succcess);
			}else{
				$errors['notsuccess'] = 'Opps! Something Wrong';					
				echo json_encode($errors);
			}
		}	
	}
	
	
	/****************************************/
	/************ Individual Delete Notice ***********/
	/****************************************/
	public function delete($noticeid){
		$this->db->where('noticeid', $noticeid);
		$deleted = $this->db->delete('notice');		
		if($deleted == TRUE){			
		$this->session->set_flashdata('success', 'Successfully Deleted');
		redirect('dashboard/notice/allnotices', 'refresh');	
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/notice/allnotices', 'refresh');	
		}
	}
	
	/****************************************/
	/************ Get Total Notices ***********/
	/****************************************/
	public function getTotal($table){		
            $query = $this->db->get($table);
            return $query->result();
	}
        
	/****************************************/
	/************ Get Pagination Of Notices ***********/
	/****************************************/
	public function getPagiData($limit, $start){		
		$this->db->limit($limit, $start);
		$query = $this->db->get('notice');
		return $query->result();
	}
	
	/****************************************/
	/*************** Individual **************/
	/****************************************/
	public function getIndividual(){	
		$noticeid = $this->uri->segment(4);
		$query = $this->db->get_where('notice', array('noticeid' => $noticeid));		
		return $query->result();
	}
}