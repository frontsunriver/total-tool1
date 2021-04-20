<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clan extends MX_Controller {

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
    /***** Clan Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/clan/index";
        $database = "clan";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['clan'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('clan/clan', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Clan View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['clan'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('clan/view', $data);
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
    /***** Get Clan Info ********/
    /*****************************/
    public function getClan(){
        $query = $this->db->get('clan');
        return $query->result();
    }

    /*****************************/
    /***** Get Clan Individual ********/
    /*****************************/
    public function getIndividual(){
        $clanid = $this->uri->segment(4);
        $query = $this->db->get_where('clan', array('clanid' => $clanid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/clan/', 'refresh');
        }
    }

    /****************************************/
    /*** Get Pagination Clan Member *********/
    /****************************************/
    public function getPagiData($limit, $start){
        $this->db->limit($limit, $start);
        $query = $this->db->get('clan');
        return $query->result();
    }
}
