<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MX_Controller {
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

        isLoginRedirect();
        isKenaRedirect();

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
        $this->load->dbforge(); 

    }

    /*     * ************************** */
    /*     * *** Website Index Page **** */
    /*     * ************************** */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Website/basic');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Header **** */
    /*     * ************************** */

    public function header() {
        $data['website'] = $this->getBasicInfo();
        $this->load->view('Dashboard/header');
        $this->load->view('Website/basic', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Getting Website Basic Info **** */
    /*     * ************************** */

    public function getBasicInfo() {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Slider **** */
    /*     * ************************** */

    public function slider() {
        $data['slider'] = $this->getSlider();
        $this->load->view('Dashboard/header');
        $this->load->view('Website/slider', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Gallery **** */
    /*     * ************************** */

    public function gallery() {
        $data['gallery'] = $this->getGallery();
        $this->load->view('Dashboard/header');
        $this->load->view('Website/gallery', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Footer **** */
    /*     * ************************** */

    public function footer() {
        $this->load->view('Dashboard/header');
        $this->load->view('Website/basic');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Save Basic Info **** */
    /*     * ************************** */

    public function updatebasic() {

        $errors = array();
        $success = array();
        $data = array();

        $title = $this->input->post('title');
        $tag = $this->input->post('tag');
        $map = $this->input->post('map');
        $email = $this->input->post('email');
        $color = $this->input->post('color');
        $currency = $this->input->post('currency');
        $pscurrency = $this->input->post('pscurrency');
        $sscurrency = $this->input->post('sscurrency');
        $pdcurrency = $this->input->post('pdcurrency');
        $sdcurrency = $this->input->post('sdcurrency');
        $churchtime = $this->input->post('churchtime');
        $about = $this->input->post('about');
        $contact = $this->input->post('contact');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $country = $this->input->post('country');
        $postal = $this->input->post('postal');
        $donationtext = $this->input->post('donationtext');
        $copyright = $this->input->post('copyright');

        $facebook = $this->input->post('facebook');
        $twitter = $this->input->post('twitter');
        $googleplus = $this->input->post('googleplus');
        $linkedin = $this->input->post('linkedin');
        $youtube = $this->input->post('youtube');
        $pinterest = $this->input->post('pinterest');
        $instagram = $this->input->post('instagram');
        $whatsapp = $this->input->post('whatsapp');

        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($tag)) {
            $data['tag'] = $tag;
        }
        if (!empty($map)) {
            $data['map'] = $map;
        }
        if (!empty($mapapi)) {
            $data['mapapi'] = $mapapi;
        }
        if (!empty($fbappid)) {
            $data['fbappid'] = $fbappid;
        }
        if (!empty($color)) {
            $data['color'] = $color;
        }
        if (!empty($email)) {
            $data['email'] = $email;
        }
        if (!empty($currency)) {
            $data['currency'] = $currency;
        }
        if (!empty($churchtime)) {
            $data['churchtime'] = $churchtime;
        }
        if (!empty($about)) {
            $data['about'] = $about;
        }
        if (!empty($contact)) {
            $data['contact'] = $contact;
        }
        if (!empty($address)) {
            $data['address'] = $address;
        }
        if (!empty($city)) {
            $data['city'] = $city;
        }
        if (!empty($country)) {
            $data['country'] = $country;
        }
        if (!empty($postal)) {
            $data['postal'] = $postal;
        }
        if (!empty($donationtext)) {
            $data['donationtext'] = $donationtext;
        }
        if (!empty($copyright)) {
            $data['copyright'] = $copyright;
        }

        if (!empty($facebook)) {
            $data['facebook'] = $facebook;
        }
        if (!empty($twitter)) {
            $data['twitter'] = $twitter;
        }
        if (!empty($googleplus)) {
            $data['googleplus'] = $googleplus;
        }
        if (!empty($linkedin)) {
            $data['linkedin'] = $linkedin;
        }
        if (!empty($youtube)) {
            $data['youtube'] = $youtube;
        }
        if (!empty($pinterest)) {
            $data['pinterest'] = $pinterest;
        }
        if (!empty($instagram)) {
            $data['instagram'] = $instagram;
        }
        if (!empty($whatsapp)) {
            $data['whatsapp'] = $whatsapp;
        }

        $imagePath = realpath(APPPATH . '../assets/assets/images/website');
        $favicon = $_FILES['favicon']['tmp_name'];
        $logo = $_FILES['logo']['tmp_name'];

        if ($favicon !== "") {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
//			$config['max_size']     = '200';
//			$config['max_width'] = '500';
//			$config['max_height'] = '500';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('favicon')) {
                $uploaded_data = $this->upload->data();
                $data['favicon'] = $uploaded_data['file_name'];
            } else {
                $data['favicon'] = '';
                $errors['favicon_error'] = strip_tags($this->upload->display_errors());
                echo json_encode($errors);
            }
        }

        if ($logo !== "") {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
//			$config['max_size']     = '5000';
//			$config['max_width'] = '500';
//			$config['max_height'] = '500';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logo')) {
                $uploaded_data = $this->upload->data();
                $data['logo'] = $uploaded_data['file_name'];
            } else {
                $data['logo'] = '';
                $errors['logo_error'] = strip_tags($this->upload->display_errors());
                echo json_encode($errors);
            }
        }

        $this->db->where('basicid', 1);
        $updated = $this->db->update('websitebasic', $data);
        if ($updated == TRUE) {
            $succcess['success'] = "Successfully Updated";
            echo json_encode($succcess);
        } else {
            $errors['notsuccess'] = 'Opps! Something Wrong';
            echo json_encode($errors);
        }
    }


    /*     * ************************** */
    /*     * *** Website Save Third APIs **** */
    /*     * ************************** */

    public function updateapis() {

        $errors = array();
        $success = array();
        $data = array();

        $data['mapapi'] = $this->input->post('mapapi');
        $data['fbappid'] = $this->input->post('fbappid');
        $data['smsapi'] = $this->input->post('smsapi');

        $data['mailgun_api'] = $this->input->post('mailgun_api');
        $data['mailgun_from'] = $this->input->post('mailgun_from');
        $data['mailgun_domain'] = $this->input->post('mailgun_domain');

        $data['nexmo_api'] = $this->input->post('nexmo_api');
        $data['nexmo_secret'] = $this->input->post('nexmo_secret');
        $data['nexmo_from'] = $this->input->post('nexmo_from');

        $data['paypal_client_id'] = $this->input->post('paypal_client_id');
        $data['paypal_secret'] = $this->input->post('paypal_secret');

        $data['stripe_apikey'] = $this->input->post('stripe_apikey');
        $data['stripe_secret'] = $this->input->post('stripe_secret');

        $data['twilio_sid'] = $this->input->post('twilio_sid');
        $data['twilio_token'] = $this->input->post('twilio_token');
        $data['twilio_sender'] = $this->input->post('twilio_sender');

        $data['paystack_secret'] = $this->input->post('paystack_secret');

        $this->db->where('basicid', 1);
        $updated = $this->db->update('websitebasic', $data);
        if ($updated == TRUE) {
            $succcess['success'] = "Successfully Updated";
            echo json_encode($succcess);
        } else {
            $errors['notsuccess'] = 'Opps! Something Wrong';
            echo json_encode($errors);
        }
    }

    /*     * ************************** */
    /*     * *** Website Upload Gallery **** */
    /*     * ************************** */

    public function uploadgallery() {

        $this->load->library('upload');
        $data = array();
        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);

        for ($i = 0; $i < $count; $i++) {

            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $imagePath = realpath(APPPATH . '../assets/assets/images/website/gallery');
            $config['upload_path'] = $imagePath . "/large";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->upload->initialize($config);

            if ($this->upload->do_upload()) {
                $fileData = $this->upload->data();
                $data['filename'] = $fileData['file_name'];
                $data['cdate'] = date("j F Y");
                $this->db->insert('gallery', $data);

                $config['source_image'] = $fileData['full_path'];
                $config['new_image'] = $imagePath . '/small';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            } else {
                echo strip_tags($this->upload->display_errors());
                redirect('dashboard/website/gallery', 'refresh');
            }
        }

        redirect('dashboard/website/gallery', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Website get Slider **** */
    /*     * ************************** */

    public function getSlider() {
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('slider');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website get Slider **** */
    /*     * ************************** */

    public function getGallery() {
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('gallery');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Slider Delete **** */
    /*     * ************************** */

    public function sliderdelete($sliderid) {
        $this->db->where('sliderid', $sliderid);
        $this->db->delete('slider');
        redirect('dashboard/website/slider', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function slidersort() {
        $sorted = $this->input->post('sort');
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $sliderid = $data[0][$x]["id"];
            $arrdata = array();
            $arrdata['serialid'] = $x;
            $this->db->where('sliderid', $sliderid);
            $this->db->update('slider', $arrdata);
        }
    }

    /*     * ************************** */
    /*     * *** Website Gallery Delete **** */
    /*     * ************************** */

    public function gallerydelete($galleryid) {
        $this->db->where('galleryid', $galleryid);
        $this->db->delete('gallery');
        redirect('dashboard/website/gallery', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function sortgallery() {
        $sorted = $this->input->post('sort');
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $galleryid = $data[0][$x]["id"];
            $arrdata = array();
            $arrdata['serialid'] = $x;
            $this->db->where('galleryid', $galleryid);
            $this->db->update('gallery', $arrdata);
        }
    }

    /*     * ************************** */
    /*     * *** Website Upload Slider **** */
    /*     * ************************** */

    public function uploadslider() {

        $this->load->library('upload');
        $data = array();
        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);

        for ($i = 0; $i < $count; $i++) {

            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $imagePath = realpath(APPPATH . '../assets/assets/images/website/slider');
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->upload->initialize($config);

            if ($this->upload->do_upload()) {
                $fileData = $this->upload->data();

                $config['source_image'] = $fileData['full_path'];
                $config['new_image'] = $imagePath . '/resize';
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data['filename'] = $fileData['file_name'];
                $data['cdate'] = date("j F Y");
                $this->db->insert('slider', $data);
            } else {
                echo strip_tags($this->upload->display_errors());
            }
        }
        redirect('dashboard/website/slider', 'refresh');
    }


    //update database
    public function updateDatabase(){

        //modify fields for settings table
        $SettingsFieldsModify = array(
            array('licUsername' => array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE,)),
            array('licPurchaseDate' => array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE,)),
            array('paystack_secret' => array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE,)),            
        );

        for($x=0; count($SettingsFieldsModify) > $x; $x++){
            $fieldName = key($SettingsFieldsModify[$x]); //field name
            if($this->db->field_exists($fieldName, 'websitebasic') == false){
                $this->dbforge->add_column('websitebasic', $SettingsFieldsModify[$x]); //if not found then insert new column
            }
        }
        
        //prayer table
        $prayerFieldsAdd = array(
            array('userID' =>  array('type' => 'int', 'constraint' => 11, 'null' => TRUE,)),          
        );

        for($x=0; count($prayerFieldsAdd) > $x; $x++){
            $fieldName = key($prayerFieldsAdd[$x]); //field name
            if($this->db->field_exists($fieldName, 'prayer') == false){
                $this->dbforge->add_column('prayer', $prayerFieldsAdd[$x]); //if not found then insert new column
            }
        }

        $this->session->set_flashdata('success', 'Database Successfully Updated');
        redirect('dashboard', 'refresh');

    }

}
