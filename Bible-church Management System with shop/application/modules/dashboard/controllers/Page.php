<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MX_Controller {
    
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
	
	/*****************************/
	/***** Website Index Page *****/
	/*****************************/
	public function index(){
            $data['pages'] = $this->allpage();
            $this->load->view('Dashboard/header');
            $this->load->view('Page/page', $data);
            $this->load->view('Dashboard/footer');
	}
        
	/*****************************/
	/***** Website Page *****/
	/*****************************/
	public function page(){
            $data['pages'] = $this->allpage();
            $this->load->view('Dashboard/header');
            $this->load->view('Page/page', $data);
            $this->load->view('Dashboard/footer');
	}
        
        /*****************************/
	/********** Add Page *********/
	/*****************************/
	public function add(){
            
            $errors = array();	
            $success = array();	
            $data = array();

            $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
            $this->form_validation->set_rules('slug', 'Page Slug/Keyword', 'trim|required');	
            if($this->form_validation->run() == FALSE){
                $errors['errorFormValidation'] = validation_errors();				
                echo json_encode($errors);
            }else{
                
                $data['pagetitle'] = $this->input->post('title');
                $data['pageslug'] = $this->input->post('slug');		
                $data['pagecontent'] = $this->input->post('content');
                $data['cdate'] = date("j F Y");
                
                $inserted = $this->db->insert('page', $data); 
                if($inserted == TRUE){
                    $succcess['success'] = "Successfully Inserted";
                    echo json_encode($succcess);
                }else{
                    $errors['notsuccess'] = 'Opps! Something Wrong';					
                    echo json_encode($errors);
                }
            }
	}
        
        /*****************************/
	/***** Website Page View *****/
	/*****************************/
	public function edit(){
            $data['individual'] = $this->individual();
            $this->load->view('Dashboard/header');
            $this->load->view('Page/edit', $data);
            $this->load->view('Dashboard/footer');
	}
        
        
        /*****************************/
	/********** Add Page *********/
	/*****************************/
	public function update(){
            
            $errors = array();	
            $success = array();	
            $data = array();
            
            $pageid = $this->input->post('pageid');
            
            $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
            $this->form_validation->set_rules('slug', 'Page Slug/Keyword', 'trim|required');	
            if($this->form_validation->run() == FALSE){
                $errors['errorFormValidation'] = validation_errors();				
                echo json_encode($errors);
            }else{
                
                $data['pagetitle'] = $this->input->post('title');
                $data['pageslug'] = $this->input->post('slug');		
                $data['pagecontent'] = $this->input->post('content');
                $data['cdate'] = date("j F Y");
                
                $this->db->where('pageid', $pageid);
                $updated = $this->db->update('page', $data); 
                if($updated == TRUE){
                    $succcess['success'] = "Successfully Updted";
                    echo json_encode($succcess);
                }else{
                    $errors['notsuccess'] = 'Opps! Something Wrong';					
                    echo json_encode($errors);
                }
            }
	}
        
        /****************************************/
	/******** Individual Delete Page ********/
	/****************************************/
	public function delete($pageid){
            $this->db->where('pageid', $pageid);
            $deleted = $this->db->delete('page');		
            if($deleted == TRUE){			
                $this->session->set_flashdata('success', 'Successfully Deleted');
                redirect('dashboard/page/', 'refresh');	
            }else{
                $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
                redirect('dashboard/page/', 'refresh');	
            }
	}
        
        
        /*****************************/
	/***** Website Page **********/
	/*****************************/
	public function allpage(){
            $query = $this->db->get('page');
            return $query->result();
	}
        
        /*****************************/
	/***** Website Page **********/
	/*****************************/
	public function individual(){
            $pageid = $this->uri->segment(4);
            $this->db->where('pageid', $pageid);
            $query = $this->db->get('page');
            return $query->result();
	}
        
}