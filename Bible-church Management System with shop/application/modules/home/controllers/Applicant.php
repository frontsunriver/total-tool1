<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant extends MX_Controller {

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

    }

    /*****************************/
    /***** Applicant Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/applicant/index";
        $database = "seminarregistration";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['applicant'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('applicant/applicant', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Applicant Index  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['applicant'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('applicant/view', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Get Basic Info ********/
    /*****************************/
    public function getBasicInfo(){
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    /*****************************/
    /***** Get Applicant Info ********/
    /*****************************/
    public function getApplicantInfo(){
        $query = $this->db->get('seminarregistration');
        return $query->result();
    }

    /*****************************/
    /***** Get Applicant Individual ********/
    /*****************************/
    public function getIndividual(){
        $seminarregid = $this->uri->segment(4);
        $query = $this->db->get_where('seminarregistration', array('seminarregid' => $seminarregid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/applicant/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Applicant *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('seminarregistration');
            return $query->result();
    }
}
