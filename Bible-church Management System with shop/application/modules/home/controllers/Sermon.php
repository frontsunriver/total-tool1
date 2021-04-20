<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sermon extends MX_Controller {

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
    /***** Sermon Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/sermon/index";
        $database = "sermon";
        $perpage = 10;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['sermon'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('sermon/sermon', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Sermon View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['sermon'] = $this->getIndividual();
        $data['recents'] = $this->getRecent(5);
        $this->load->view('header');
        $this->load->view('sermon/view', $data);
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
    /***** Get Sermon Info ********/
    /*****************************/
    public function getSermon(){
        $query = $this->db->get('sermon');
        return $query->result();
    }

    /****************************************/
    /********* Get Recent Seminar *************/
    /****************************************/
    public function getRecent($limit){
        $current = $this->uri->segment(4);
        $this->db->limit($limit);
        $this->db->order_by('sermonid', 'desc');
        $this->db->where_not_in('sermonid', $current);
        $query = $this->db->get('sermon');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    /*****************************/
    /***** Get Sermon Individual ********/
    /*****************************/
    public function getIndividual(){
        $sermonid = $this->uri->segment(4);
        $query = $this->db->get_where('sermon', array('sermonid' => $sermonid));
        return $query->result();
    }

    /****************************************/
    /********* Get Pagination Sermon *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('sermon');
            return $query->result();
    }

}
