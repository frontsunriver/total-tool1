<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MX_Controller {
    
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

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Dashboard/dashboard');
        $this->load->view('Dashboard/footer');
    }
    
    public function about() {
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/about');
        $this->load->view('Dashboard/footer');
    }

    public function profile() {
        $data['indiUser'] = $this->getProfile();
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/profile', $data);
        $this->load->view('Dashboard/footer');
    }

    public function editprofile() {
        $data['indiUser'] = $this->getProfile();
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/editprofile', $data);
        $this->load->view('Dashboard/footer');
    }

    public function updateProfile() {

        $errors = array();
        $success = array();
        $data = array();

        $userID = $this->input->post('userid');
        $email = $this->input->post('email');
        $checked = $this->isEmailUnique($email, $userID);
        if ($checked == TRUE) {
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean|min_length[4]|max_length[12]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|min_length[6]|max_length[12]|matches[conpassword]');
            $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $errors['errorFormValidation'] = validation_errors();
                echo json_encode($errors);
            } else {
                $data['fname'] = $this->input->post('fname');
                $data['lname'] = $this->input->post('lname');
                $data['userstatus'] = 'Active';
                $data['username'] = strtolower($data['fname'] . $data['lname']);
                $data['about'] = $this->input->post('about');
                $data['phone'] = $this->input->post('phone');
                $data['email'] = $this->input->post('email');
                $password = $this->input->post('password');
                if ($password) {
                    $data['password'] = md5($password);
                }
                $data['position'] = $this->input->post('position');
                $data['bpdate'] = $this->input->post('bpdate');
                $data['blood'] = $this->input->post('blood');
                $data['dob'] = $this->input->post('dob');
                $data['nationality'] = $this->input->post('nationality');
                $data['address'] = $this->input->post('address');
                $data['city'] = $this->input->post('city');
                $data['country'] = $this->input->post('country');
                $data['postal'] = $this->input->post('postal');

                /* Uploading Profile Images */
                $imagePath = realpath(APPPATH . '../assets/assets/images/users');
                $profileimage = $_FILES['profileimage']['tmp_name'];
                //If Profile Image $profileimage Has Anything Then Continue
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
                        $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                        echo json_encode($errors);
                    }

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

                    /* Deleting Uploaded Image After Croping and Resizing */
                    /* Why Deleting because it's saving space */
                    unlink($uploaded_data['full_path']);
                }

                $this->db->where('userid', $userID);
                $updated = $this->db->update('users', $data);
                if ($updated == TRUE) {
                    $succcess['success'] = "Successfully Updated";
                    echo json_encode($succcess);
                } else {
                    $errors['notsuccess'] = 'Opps! Something Wrong';
                    echo json_encode($errors);
                }
            }
        } else {
            $errors['emailexist'] = $email . ' already exist';
            echo json_encode($errors);
        }
    }

    public function getProfile() {
        $userId = $this->session->userdata('user_id');
        $query = $this->db->get_where('users', array('userid' => $userId));
        return $query->result();
    }

    /**************************************************************/
    /***** Checking If User Update Email Is Unique/Duplicate ******/
    /**************************************************************/

    public function isEmailUnique($email, $userID) {

        $query = $this->db->get_where('users', array('email' => $email));
        if ($query->num_rows() > 0) { //If rows bigger than 0 Email Found
            foreach ($query->result() as $row) {
                $newuserid = $row->userid;
            }
            if ($newuserid == $userID) {
                return TRUE;
            } else {
                return FALSE; // True means unique email 
            }
        } else {
            return True; // True means unique email 
        }
    }

    public function switchLang($language = "") {
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('lang', $language);
        //redirect('dashboard/dashboard', 'refresh');
        redirect($_SERVER['HTTP_REFERER']);
    }

}
