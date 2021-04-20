<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends MX_Controller {

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
    /***** Staff Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/staff/index";
        $database = "staff";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['staff'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('staff/staff', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Staff View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['staff'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('staff/view', $data);
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
    /***** Get Staff Info ********/
    /*****************************/
    public function getStaff(){
        $query = $this->db->get('staff');
        return $query->result();
    }

    /*****************************/
    /***** Get Staff Individual ********/
    /*****************************/
    public function getIndividual(){
        $staffid = $this->uri->segment(4);
        $query = $this->db->get_where('staff', array('staffid' => $staffid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/staff/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Staff *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('staff');
            return $query->result();
    }
}
