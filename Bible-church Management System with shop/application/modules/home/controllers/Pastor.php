<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pastor extends MX_Controller {

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
    /***** Pastor Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/pastor/index";
        $database = "pastor";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['pastor'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('pastor/pastor', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Pastor Index  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['pastor'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('pastor/view', $data);
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
    /***** Get Pastor Info ********/
    /*****************************/
    public function getPastorInfo(){
        $query = $this->db->get('pastor');
        return $query->result();
    }

    /*****************************/
    /***** Get Pastor Individual ********/
    /*****************************/
    public function getIndividual(){
        $pastorid = $this->uri->segment(4);
        $query = $this->db->get_where('pastor', array('pastorid' => $pastorid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/pastor/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Pastor *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('pastor');
            return $query->result();
    }
}
