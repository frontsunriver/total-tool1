<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Joinseminar extends MX_Controller {
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

        // $logged_in = $this->session->userdata('logged_in');
        // if(!$logged_in){
        // redirect('access/login', 'refresh');
        // }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    public function index() {
        $data['basicinfo'] = $this->getBasicInfo();
        $data['seminar_list'] = $this->get_seminar_list();
        $this->load->view('access/header', $data);
        $this->load->view('access/seminarregistration', $data);
        $this->load->view('access/footer', $data);
    }

    /*     * ************************** */
    /*     * *** Get Basic Info ******* */
    /*     * ************************** */

    public function getBasicInfo() {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    public function get_seminar_list() {

        $this->db->order_by("seminarid", "desc");
        $query = $this->db->get('seminar');
        return $query->result();
    }

    public function addnewapplicant() {

        ///$errors=array();
        $data = array();
        $data['selectedseminarid'] = $this->input->post('selectedseminarid');
        $data['fname'] = $this->input->post('fname');
        $data['lname'] = $this->input->post('lname');
        $data['gender'] = $this->input->post('gender');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['age'] = $this->input->post('age');
        $data['education'] = $this->input->post('education');
        $data['church'] = $this->input->post('church');
        $data['churchpastor'] = $this->input->post('churchpastor');
        $data['guardian'] = $this->input->post('guardian');
        $data['guardiancontact'] = $this->input->post('guardiancontact');
        $data['nationality'] = $this->input->post('nationality');
        $data['paymentgateway'] = $this->input->post('paymentgateway');
        $data['paymentgatewayinfo'] = $this->input->post('paymentgetwayinfo');
        $data['paymentsenderinfo'] = $this->input->post('paymentsenderinfo');
        $data['address'] = $this->input->post('address');
        $data['city'] = $this->input->post('city');
        $data['country'] = $this->input->post('country');
        $data['postal'] = $this->input->post('postal');
        $data['facebook'] = $this->input->post('facebook');
        $data['twitter'] = $this->input->post('twitter');
        $data['youtube'] = $this->input->post('youtube');
        $data['googleplus'] = $this->input->post('googleplus');
        $data['linkedin'] = $this->input->post('linkedin');
        $data['pinterest'] = $this->input->post('pinterest');
        $data['whatsapp'] = $this->input->post('whatsapp');
        $data['instagram'] = $this->input->post('instagram');
        $data['cdate'] = date("j F Y");

        /* Uploading Profile Images */
        $imagePath = realpath(APPPATH . '../assets/assets/images/seminar');
        $profileimage = $_FILES['profileimage']['tmp_name'];

        if ($profileimage !== "") {

            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('profileimage')) {
                $uploaded_data = $this->upload->data();
                $data['profileimage'] = $uploaded_data['file_name'];
            } else {
                $data['profileimage'] = '';
                ///$errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                //echo $this->upload->display_errors();
            }

            if( round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0 ){

                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploaded_data['full_path'];
                $config['new_image'] = $imagePath . '/crop';
                $config['quality'] = '100%';
                $config['maintain_ratio'] = FALSE;
                $config['width'] = round($this->input->post('width'));
                $config['height'] = round($this->input->post('height'));
                $config['x_axis'] = $this->input->post('x');
                $config['y_axis'] = $this->input->post('y');

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                /* Resizing Uploaded Images */
                $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                $config['new_image'] = $imagePath . '/profile';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                unlink($imagePath . '/crop/' . $uploaded_data['file_name']);

          }else{

                /** ****** Resizing Joinseminar Banner ****** */
                /** ************************************** */
                $config['source_image'] = $uploaded_data['full_path'];
                $config['new_image'] = $imagePath . '/profile';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

            }


            /* Deleting Uploaded Image After Croping and Resizing */
            /* Why Deleting because it's saving space */            
            unlink($uploaded_data['full_path']);
            
        }

        if ($data) {
            $inserted = $this->db->insert('seminarregistration', $data);
            redirect('dashboard/joinseminar/', 'refresh');
        } else {
            redirect('dashboard/joinseminar/', 'refresh');
        }

        //echo json_encode($errors);
    }

}
