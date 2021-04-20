<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Speech extends MX_Controller {

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
    /***** Speech Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/speech/index";
        $database = "speech";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['speech'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('speech/speech', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Speech Index  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['speech'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('speech/view', $data);
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
    /***** Get Speech Info ********/
    /*****************************/
    public function getSpeechInfo(){
        $query = $this->db->get('speech');
        return $query->result();
    }

    /*****************************/
    /***** Get Speech Individual ********/
    /*****************************/
    public function getIndividual(){
        $speechid = $this->uri->segment(4);
        $query = $this->db->get_where('speech', array('speechid' => $speechid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/speech/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Speech *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('speech');
            return $query->result();
    }
}
