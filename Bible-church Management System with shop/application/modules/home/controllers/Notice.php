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

    }

    /*****************************/
    /***** Notice Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/notice/index";
        $database = "notice";
        $perpage = 6;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['notice'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('notice/notice', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Notice View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['notice'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('notice/view', $data);
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
    /***** Get Notice Info ********/
    /*****************************/
    public function getNotice(){
        $query = $this->db->get('notice');
        return $query->result();
    }

    /*****************************/
    /***** Get Notice Individual ********/
    /*****************************/
    public function getIndividual(){
        $noticeid = $this->uri->segment(4);
        $query = $this->db->get_where('notice', array('noticeid' => $noticeid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/notice/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Notice *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('notice');
            return $query->result();
    }

}
