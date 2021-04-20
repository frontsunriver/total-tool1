<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends MX_Controller {

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
    }

    /*     * ************************** */
    /*     * *** Index Page Of Section **** */
    /*     * ************************** */

    public function index() {

        $baselink = "section/index";
        $database = "section";
        $perpage = 10;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['section'] = $this->get_pagi_data($limit, $start);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('Dashboard/header');
        $this->load->view('Section/addsection', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Add Section ******* */
    /*     * ************************** */

    public function addsection() {
        $this->load->view('Dashboard/header');
        $this->load->view('Section/addsection');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Adding New Section ******* */
    /*     * ************************** */

    public function addnewsection() {

        $errors = array();
        $success = array();
        $data = array();

        $shortcode = $this->input->post('shortcode');
        $selectshortcode = $this->input->post('selectshortcode');
        $removebackground = $this->input->post('removebackground');
        $sectiononoff = $this->input->post('sectiononoff');
        $this->form_validation->set_rules('title', 'Section Title', 'trim|required');
        if ($shortcode !== "") {
            $this->form_validation->set_rules('content', 'Content', 'trim');
        } else {
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            if ($shortcode) {
                $data['shortcode'] = $shortcode;
            } else {
                $data['shortcode'] = $selectshortcode;
            }

            if ($removebackground == "Delete") {
                $data['background'] = "";
            }

            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $data['link'] = $this->input->post('link');
            $data['btntext'] = $this->input->post('btntext');
            $data['sectiononoff'] = $this->input->post('sectiononoff');
            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/section');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['background'] = $uploaded_data['file_name'];
                } else {
                    $data['background'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                }

                if( round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0 ){

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['quality'] = '100%';
                    $config['maintain_ratio'] = TRUE;

                    $config['width'] = round($this->input->post('width'));
                    $config['height'] = round($this->input->post('height'));
                    $config['x_axis'] = $this->input->post('x');
                    $config['y_axis'] = $this->input->post('y');

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                  }else{

                    /** ****** Resizing Section Banner ****** */
                    /** ************************************** */
                     $config['source_image'] = $uploaded_data['full_path'];
                     $config['new_image'] = $imagePath . '/crop';
                     $config['maintain_ratio'] = TRUE;

                     $this->image_lib->clear();
                     $this->image_lib->initialize($config);
                     $this->image_lib->resize();

                  }


                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }

            $inserted = $this->db->insert('section', $data);
            if ($inserted == TRUE) {
                $succcess['success'] = "Successfully Inserted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * ******* All Sections ******* */
    /*     * ************************** */

//	public function allSection(){
//
//		$baselink = "section/allSection";
//		$database = "section";
//		$perpage = 10;
//		$start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
//		$limit = iniPagination($baselink, $database, $perpage);
//		$data['section'] = $this->get_pagi_data($limit, $start);
//		$data['pagination'] = $this->pagination->create_links();
//		$this->load->view('Dashboard/header');
//		$this->load->view('Section/allsections', $data);
//		$this->load->view('Dashboard/footer');
//	}

    /*     * ************************** */
    /*     * ******* View Individual Section ******* */
    /*     * ************************** */
//	public function view(){
//		$data['individual'] = $this->getIndividual();
//		$this->load->view('Dashboard/header');
//		$this->load->view('Section/view', $data);
//		$this->load->view('Dashboard/footer');
//	}

    /*     * ************************** */
    /*     * *** Edit Section Profile **** */
    /*     * ************************** */
    public function edit() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Section/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Update Section Profile **** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $sectionid = $this->input->post('sectionid');
        $shortcode = $this->input->post('shortcode');
        $selectshortcode = $this->input->post('selectshortcode');
        $removebackground = $this->input->post('removebackground');
        $sectiononoff = $this->input->post('sectiononoff');

        $this->form_validation->set_rules('title', 'Section Title', 'trim|required');

        if ($shortcode !== "") {
            $this->form_validation->set_rules('content', 'Content', 'trim');
        } else {
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['title'] = $this->input->post('title');
            if ($shortcode) {
                $data['shortcode'] = $shortcode;
            } else {
                $data['shortcode'] = $selectshortcode;
            }

            if ($removebackground == "Delete") {
                $data['background'] = "";
            }
            $data['content'] = $this->input->post('content');
            $data['link'] = $this->input->post('link');
            $data['btntext'] = $this->input->post('btntext');
            $data['sectiononoff'] = $this->input->post('sectiononoff');

            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/section');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['background'] = $uploaded_data['file_name'];
                } else {
                    $data['background'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }

                if( round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0 ){

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['quality'] = '100%';
                    $config['maintain_ratio'] = TRUE;

                    $config['width'] = round($this->input->post('width'));
                    $config['height'] = round($this->input->post('height'));
                    $config['x_axis'] = $this->input->post('x');
                    $config['y_axis'] = $this->input->post('y');

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                }  else{

                  /* Resizing Uploaded Images */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['maintain_ratio'] = TRUE;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                }


                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                ///unlink($uploaded_data['full_path']);
            }

            $this->db->where('sectionid', $sectionid);
            $updated = $this->db->update('section', $data);
            if ($updated == TRUE) {
                $succcess['success'] = "Successfully Updated";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function sortSection() {
        $sorted = $this->input->post('sort');
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for($x=0; $x < $counted; $x++){
            $sectionid = $data[0][$x]["id"];
            $arrdata = array();
            $arrdata['serialid'] = $x;
            $this->db->where('sectionid', $sectionid);
            $this->db->update('section', $arrdata);
        }
    }


    /*     * ************************** */
    /*     * *** Delete Section Profile **** */
    /*     * ************************** */

    public function delete($sectionid) {
        $this->db->where('sectionid', $sectionid);
        $this->db->delete('section');
        redirect('dashboard/section/', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting Section By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start) {
        $this->db->order_by("serialid", "asc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('section');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Get Individual Section Profile **** */
    /*     * ************************** */

    public function getIndividual() {
        $Sectionid = $this->uri->segment(4);
        $query = $this->db->get_where('section', array('sectionid' => $Sectionid));
        return $query->result();
    }

}
