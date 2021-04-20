<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MX_Controller {
    
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
    /***** Gallery Index  ********/
    /*****************************/
    public function index(){        
        $data['basicinfo'] = $this->getBasicInfo();  
        $data['gallery'] = $this->getGallery(); 
        $this->load->view('header');
        $this->load->view('gallery/gallery', $data);
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
    /***** Get Gallery Info ********/
    /*****************************/
    public function getGallery(){ 
        $query = $this->db->get('gallery');
        return $query->result();
    }
    
    
}