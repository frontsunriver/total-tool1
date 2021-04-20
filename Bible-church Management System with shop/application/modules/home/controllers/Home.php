<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
    
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
        $this->load->library('envatoapi');
    }
    
    /*****************************/
    /***** Website Index  ********/
    /*****************************/
    public function index(){        
        $data['basicinfo'] = $this->getBasicInfo();
        $data['event'] = $this->getEventInfo();
        $data['events'] = $this->getEventsInfo();
        $data['speech'] = $this->getSpeeches();
        $data['section'] = $this->getSection();
        $data['pastors'] = $this->getPastors();
        $data['committee'] = $this->getCommittee();
        $data['prayer'] = $this->getPrayerInfo();
        $data['notice'] = $this->getNoticeInfo();
        $data['gallery'] = $this->getGalleryInfo();
        $data['slider'] = $this->getSlider();
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header', $data);
        $this->load->view('index', $data);
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
    /***** Get Event Info ********/
    /*****************************/
    public function getEventInfo(){        
        $this->db->order_by('eventid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /**********************************/
    /***** Get All Events Info ********/
    /**********************************/
    public function getEventsInfo(){        
        $this->db->order_by('eventid', 'desc');
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Speech     ********/
    /*****************************/
    public function getSpeeches(){   
        $query =  $this->db->get('speech');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Section    ********/
    /*****************************/
    public function getSection(){   
        $this->db->order_by('serialid', 'asc');
        $query =  $this->db->get('section');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Pastor Info ********/
    /*****************************/
    public function getPastors(){ 
        $this->db->limit(4);
        $query = $this->db->get('pastor');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Committee Info ********/
    /*****************************/
    public function getCommittee(){ 
        $this->db->limit(4);
        $query = $this->db->get('committee');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Payer Info ********/
    /*****************************/
    public function getPrayerInfo(){ 
        $query = $this->db->get('prayer');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Notice Info ********/
    /*****************************/
    public function getNoticeInfo(){ 
        $query = $this->db->get('notice');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function getGalleryInfo(){ 
        $this->db->limit(6);
        $query = $this->db->get('gallery');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function getSlider(){ 
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('slider');
        return $query->result();
    }
    
    
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function contactWithUs(){ 
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $body = strip_tags($this->input->post('body'));
        
        $info = $this->getBasicInfo();
        $toEmail = $info[0]->email;
        
        $this->email->from($email, $name);
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
		redirect('dashboard', 'refresh');
    }
    
    
    public function evnatoVerify(){
        $purchaseCode = $this->getBasicInfo()[0]->verify;
        $o = $this->envatoapi->verifyPurchase($purchaseCode);        
        if ( is_object($o) ) {
            return true;
        }else {
            return false;
        }
    }
    
}