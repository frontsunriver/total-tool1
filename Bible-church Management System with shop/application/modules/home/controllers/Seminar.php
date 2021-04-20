<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar extends MX_Controller {

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
    /***** Seminar Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/seminar/index";
        $database = "seminar";
        $perpage = 6;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['seminar'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('seminar/seminar', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Seminar View  ********/
    /*****************************/
    public function view(){
        $seminarid = $this->uri->segment(4);
        $baselink = "home/seminar/view/" . $seminarid . "/";
        $database = "seminarregistration";
        $perpage = 12;
        $start = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $limit = $this->iniPagination($baselink, $database, $perpage);
        $data['applicants'] = $this->getPagiApplicants($limit, $start);
        $data['pagination'] = $this->pagination->create_links();

        $data['basicinfo'] = $this->getBasicInfo();
        $data['seminar'] = $this->getIndividual();
        $data['recents'] = $this->getRecent(5);
        $this->load->view('header');
        $this->load->view('seminar/view', $data);
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
    /***** Get Basic Info ********/
    /*****************************/
    public function iniPagination($baselink, $database, $perpage){
        $config["base_url"] = base_url() . $baselink;
        $config['total_rows'] = $this->db->count_all($database);
        $limit = $config['per_page'] = $perpage;
        $config["uri_segment"] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = $this->lang->line('dash_gpanel_pre');
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = $this->lang->line('dash_gpanel_next');
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        return $limit;
    }

    /*****************************/
    /***** Get Seminar Info ********/
    /*****************************/
    public function getSeminar(){
        $query = $this->db->get('seminar');
        return $query->result();
    }

    /*****************************/
    /***** Get Seminar Individual ********/
    /*****************************/
    public function getIndividual(){
        $seminarid = $this->uri->segment(4);
        $query = $this->db->get_where('seminar', array('seminarid' => $seminarid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/seminar/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Seminar *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('seminar');
            return $query->result();
    }

    /****************************************/
    /********* Get Recent Seminar *************/
    /****************************************/
    public function getRecent($limit){
            $current = $this->uri->segment(4);
            $this->db->limit($limit);
            $this->db->order_by('seminarid', 'desc');
            $this->db->where_not_in('seminarid', $current);
            $query = $this->db->get('seminar');
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
    }

    /**********************************/
    /**** Get Seminar Applicants *****/
    /**********************************/
    public function getCurrentApplicant(){
        $seminarid = $this->uri->segment(4);
        $query = $this->db->get_where('seminarregistration', array('selectedseminarid' => $seminarid));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    /****************************************/
    /********* Get Pagination Applicants *****/
    /****************************************/
    public function getPagiApplicants($limit, $start){
            $seminarid = $this->uri->segment(4);
            $this->db->limit($limit, $start);
            $this->db->where('selectedseminarid', $seminarid);
            $query = $this->db->get('seminarregistration');
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }

    }

}
