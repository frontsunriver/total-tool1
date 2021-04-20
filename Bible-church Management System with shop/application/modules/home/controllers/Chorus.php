<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chorus extends MX_Controller {

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
    /***** Chorus Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/chorus/index";
        $database = "chorus";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['chorus'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('chorus/chorus', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Chorus View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['chorus'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('chorus/view', $data);
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
    /***** Get Chorus Info ********/
    /*****************************/
    public function getChorus(){
        $query = $this->db->get('chorus');
        return $query->result();
    }

    /*****************************/
    /***** Get Chorus Individual ********/
    /*****************************/
    public function getIndividual(){
        $chorusid = $this->uri->segment(4);
        $query = $this->db->get_where('chorus', array('chorusid' => $chorusid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/chorus/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Chorus Member *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('chorus');
            return $query->result();
    }
}
