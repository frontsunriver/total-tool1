<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MX_Controller {

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
    /***** Blog Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/blog/index";
        $database = "blog";
        $perpage = 9;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['blog'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('blog/blog', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Blog View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['blog'] = $this->getIndividual();
        $data['recents'] = $this->getRecent(5);
        $this->load->view('header');
        $this->load->view('blog/view', $data);
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
    /***** Get Blog Info ********/
    /*****************************/
    public function getBlog(){
        $query = $this->db->get('blog');
        return $query->result();
    }

    /****************************************/
    /********* Get Recent Seminar *************/
    /****************************************/
    public function getRecent($limit){
        $current = $this->uri->segment(4);
        $this->db->limit($limit);
        $this->db->order_by('postID', 'desc');
        $this->db->where_not_in('postID', $current);
        $query = $this->db->get('blog');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    /*****************************/
    /***** Get Blog Individual ********/
    /*****************************/
    public function getIndividual(){
        $postID = $this->uri->segment(4);
        $query = $this->db->get_where('blog', array('postID' => $postID));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home/blog/', 'refresh');
        }
    }

    /****************************************/
    /********* Get Pagination Blog *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('blog');
            return $query->result();
    }

}
