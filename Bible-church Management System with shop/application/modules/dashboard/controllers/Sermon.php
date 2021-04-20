<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sermon extends MX_Controller {

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
        $this->load->library('upload');

    }

    /*     * ************************************* */
    /*     * ******* Index Of Sermon ************ */
    /*     * ************************************* */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Sermon/addsermon');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Add Sermon **************** */
    /*     * ************************************* */

    public function addsermon() {
        $this->load->view('Dashboard/header');
        $this->load->view('Sermon/addsermon');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Add New Sermons ************ */
    /*     * ************************************* */

    public function addnewsermon() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('sermontitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('sermondate', 'Date', 'trim|required');
        $this->form_validation->set_rules('sermontime', 'Time', 'trim|required');
        $this->form_validation->set_rules('sermonauthor', 'Author/Writer/Speaker', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['sermontitle'] = $this->input->post('sermontitle');
            $data['sermondate'] = $this->input->post('sermondate');
            $data['sermontime'] = $this->input->post('sermontime');
            $data['sermonauthor'] = $this->input->post('sermonauthor');
            $data['sermonyoutube'] = $this->input->post('sermonyoutube');
            $data['sermonsoundcloud'] = $this->input->post('sermonsoundcloud');
            $data['sermonlocation'] = $this->input->post('sermonlocation');
            $data['sermondescription'] = $this->input->post('sermondescription');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/sermon');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if (!empty($profileimage)) {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                // $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['sermonbanner'] = $uploaded_data['file_name'];
                } else {
                    $data['sermonbanner'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
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


                  /** ****** Resizing Sermon Banner ****** */
                  /** ************************************** */
                  $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                  $config['new_image'] = $imagePath . '/feature';
                  $config['maintain_ratio'] = TRUE;
                  $config['width'] = 500;
                  $config['height'] = 300;

                  $this->image_lib->clear();
                  $this->image_lib->initialize($config);
                  $this->image_lib->resize();

                  /* Deleting Uploaded Image After Cropping and Resizing */
                  /* Why Deleting because it's saving space */
                  unlink($imagePath . '/crop/' . $uploaded_data['file_name']);

                }else{

                  /** ****** Resizing Sermon Banner ****** */
                  /** ************************************** */
                  $config['source_image'] = $uploaded_data['full_path'];
                  $config['new_image'] = $imagePath . '/feature';
                  $config['maintain_ratio'] = TRUE;
                  $config['width'] = 500;
                  $config['height'] = 300;

                  $this->image_lib->clear();
                  $this->image_lib->initialize($config);
                  $this->image_lib->resize();

                }

                /* Deleting Uploaded Image After Cropping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }


            //Uploading Video File
            $videoPath = realpath(APPPATH . '../assets/assets/video/sermon');
            $videoFile = $_FILES['video']['tmp_name'];
            if (!empty($videoFile)) {
                $video['upload_path'] = $videoPath;
                $video['allowed_types'] = 'mp4|mov|wmv|flv|avi|mkv|3gp';
                $video['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($video);
                if ($this->upload->do_upload('video')) {
                    $uploaded_data = $this->upload->data();
                    $data['video'] = $uploaded_data['file_name'];
                } else {
                    $errors['video_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }


            //Uploading Audio File
            $audioPath = realpath(APPPATH . '../assets/assets/audio/sermon');
            $audioFile = $_FILES['audio']['tmp_name'];
            if (!empty($audioFile)) {
                $audio['upload_path'] = $audioPath;
                $audio['allowed_types'] = 'mp3|avi|mp4|rmvb|flv|mpg|wma|wmv';
                $audio['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($audio);
                if ($this->upload->do_upload('audio')) {
                    $uploaded_data = $this->upload->data();
                    $data['audio'] = $uploaded_data['file_name'];
                } else {
                    $errors['audio_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }

            //Uploading Audio File
            $filePath = realpath(APPPATH . '../assets/assets/files');
            $fileFile = $_FILES['file']['tmp_name'];
            if (!empty($fileFile)) {
                $fileConfig['upload_path'] = $filePath;
                $fileConfig['allowed_types'] = 'doc|docx|odt|rtf|txt|wpd|wps|csv|pps|ppt|pptx|xml|pdf|xlr|xls|xlsx';
                $fileConfig['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($fileConfig);
                if ($this->upload->do_upload('file')) {
                    $uploaded_data = $this->upload->data();
                    $data['file'] = $uploaded_data['file_name'];
                } else {
                    $errors['file_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }

            $inserted = $this->db->insert('sermon', $data);
            if ($inserted == TRUE) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* View All Sermons ************ */
    /*     * ************************************* */

    public function allsermons() {
        $table = "sermon";
        $data['sermon'] = $this->getTotal($table);
        $this->load->view('Dashboard/header');
        $this->load->view('Sermon/allsermons', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************* View Sermon ************* */
    /*     * ************************************* */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Sermon/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************ Edit Sermon ************ */
    /*     * ************************************* */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Sermon/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Update Sermons ************ */
    /*     * ************************************* */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();
        $sermonid = $this->input->post('sermonid');
        $this->form_validation->set_rules('sermontitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('sermondate', 'Date', 'trim|required');
        $this->form_validation->set_rules('sermontime', 'Time', 'trim|required');
        $this->form_validation->set_rules('sermonauthor', 'Author/Writer/Speaker', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['sermontitle'] = $this->input->post('sermontitle');
            $data['sermondate'] = $this->input->post('sermondate');
            $data['sermontime'] = $this->input->post('sermontime');
            $data['sermonauthor'] = $this->input->post('sermonauthor');
            $data['sermonyoutube'] = $this->input->post('sermonyoutube');
            $data['sermonsoundcloud'] = $this->input->post('sermonsoundcloud');
            $data['sermonlocation'] = $this->input->post('sermonlocation');
            $data['sermondescription'] = $this->input->post('sermondescription');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/sermon');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['sermonbanner'] = $uploaded_data['file_name'];
                } else {
                    $data['sermonbanner'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
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


                  /** ****** Resizing Sermon Banner ****** */
                  /** ************************************** */
                  $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                  $config['new_image'] = $imagePath . '/feature';
                  $config['maintain_ratio'] = TRUE;
                  $config['width'] = 500;
                  $config['height'] = 300;

                  $this->image_lib->clear();
                  $this->image_lib->initialize($config);
                  $this->image_lib->resize();

                  /* Deleting Uploaded Image After Cropping and Resizing */
                  /* Why Deleting because it's saving space */
                  unlink($imagePath . '/crop/' . $uploaded_data['file_name']);

                }else{

                  /** ****** Resizing Sermon Banner ****** */
                  /** ************************************** */
                  $config['source_image'] = $uploaded_data['full_path'];
                  $config['new_image'] = $imagePath . '/feature';
                  $config['maintain_ratio'] = TRUE;
                  $config['width'] = 500;
                  $config['height'] = 300;

                  $this->image_lib->clear();
                  $this->image_lib->initialize($config);
                  $this->image_lib->resize();

                }

                /* Deleting Uploaded Image After Cropping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }

            //Uploading Video File
            $videoPath = realpath(APPPATH . '../assets/assets/video/sermon');
            $videoFile = $_FILES['video']['tmp_name'];
            if (!empty($videoFile)) {
                $video['upload_path'] = $videoPath;
                $video['allowed_types'] = 'mp4|mov|wmv|flv|avi|mkv|3gp';
                $video['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($video);
                if ($this->upload->do_upload('video')) {
                    $uploaded_data = $this->upload->data();
                    $data['video'] = $uploaded_data['file_name'];
                } else {
                    $errors['video_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }


            //Uploading Audio File
            $audioPath = realpath(APPPATH . '../assets/assets/audio/sermon');
            $audioFile = $_FILES['audio']['tmp_name'];
            if (!empty($audioFile)) {
                $audio['upload_path'] = $audioPath;
                $audio['allowed_types'] = 'mp3|avi|mp4|rmvb|flv|mpg|wma|wmv';
                $audio['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($audio);
                if ($this->upload->do_upload('audio')) {
                    $uploaded_data = $this->upload->data();
                    $data['audio'] = $uploaded_data['file_name'];
                } else {
                    $errors['audio_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }

            //Uploading Audio File
            $filePath = realpath(APPPATH . '../assets/assets/files');
            $fileFile = $_FILES['file']['tmp_name'];
            if (!empty($fileFile)) {
                $fileConfig['upload_path'] = $filePath;
                $fileConfig['allowed_types'] = 'doc|docx|odt|rtf|txt|wpd|wps|csv|pps|ppt|pptx|xml|pdf|xlr|xls|xlsx';
                $fileConfig['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->upload->initialize($fileConfig);
                if ($this->upload->do_upload('file')) {
                    $uploaded_data = $this->upload->data();
                    $data['file'] = $uploaded_data['file_name'];
                } else {
                    $errors['file_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }
            }

            $this->db->where('sermonid', $sermonid);
            $updated = $this->db->update('sermon', $data);
            if ($updated == TRUE) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* Delete Individual Sermon ******* */
    /*     * ************************************* */

    public function delete($sermonid) {
        $this->db->where('sermonid', $sermonid);
        $deleted = $this->db->delete('sermon');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/sermon/allsermons', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/sermon/allsermons', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ******* Get Individual Sermon ******* */
    /*     * ************************************* */

    public function getIndividual() {
        $sermonid = $this->uri->segment(4);
        $query = $this->db->get_where('sermon', array('sermonid' => $sermonid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Pagination Sermons ************ */
    /*     * ************************************* */

    public function getPagiData($limit, $start) {
        $this->db->order_by("sermonid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('sermon');
        return $query->result();
    }


    /*     * ************************************* */
    /*     * ******* Get Pagination Sermons ************ */
    /*     * ************************************* */
    public function getTotal($table) {
        $query = $this->db->get($table);
        return $query->result();
    }

}
