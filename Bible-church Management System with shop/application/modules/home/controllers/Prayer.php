<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prayer extends MX_Controller {

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
    /***** Prayer Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/prayer/index";
        $database = "prayer";
        $perpage = 6;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['prayer'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('prayer/prayer', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Prayer View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['prayer'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('prayer/view', $data);
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
    /***** Get Prayer Info ********/
    /*****************************/
    public function getPrayer(){
        $query = $this->db->get('prayer');
        return $query->result();
    }

    /*****************************/
    /***** Get Prayer Individual ********/
    /*****************************/
    public function getIndividual(){
        $prayerid = $this->uri->segment(4);
        $query = $this->db->get_where('prayer', array('prayerid' => $prayerid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/prayer/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Prayer *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('prayer');
            return $query->result();
    }

}
