<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MX_Controller {

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
    /***** Page Index  ********/
    /*****************************/
    public function index(){
        $data['basicinfo'] = $this->getBasicInfo();
        $data['page'] = $this->getPage();
        $this->load->view('header');
        $this->load->view('page/view', $data);
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
    /***** Get Page Info ********/
    /*****************************/
    public function getPage(){
        $pagekey = $this->uri->segment(3);
        if(is_numeric($pagekey)){
            $this->db->where('pageid', $pagekey);
            $query = $this->db->get('page');
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
        }else{
            $this->db->where('pageslug', $pagekey);
            $query = $this->db->get('page');
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
        }
    }


}
