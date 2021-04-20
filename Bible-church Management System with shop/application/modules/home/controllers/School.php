<?php defined('BASEPATH') OR exit('No direct script access allowed');

class School extends MX_Controller {

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
    /***** School Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/school/index";
        $database = "sundayschool";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['school'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('school/student', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** School View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['school'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('school/view', $data);
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
    /***** Get School Info ********/
    /*****************************/
    public function getSchool(){
        $query = $this->db->get('sundayschool');
        return $query->result();
    }

    /*****************************/
    /***** Get School Individual ********/
    /*****************************/
    public function getIndividual(){
        $sschoolid = $this->uri->segment(4);
        $query = $this->db->get_where('sundayschool', array('sschoolid' => $sschoolid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/school/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination School *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('sundayschool');
            return $query->result();
    }
}
