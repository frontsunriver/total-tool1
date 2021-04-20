<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
{
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

    public function __construct()
    {
        parent::__construct();

        isLoginRedirect();
        isKenaRedirect();

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    /*     * ************************** */
    /*     * *** Index Page Of User **** */
    /*     * ************************** */

    public function index()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Users/adduser');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Add From Page Of User **** */
    /*     * ************************** */

    public function adduser()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Users/adduser');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Adding New User **** */
    /*     * ************************** */

    public function addnewuser()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|matches[conpassword]');
        $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
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
            $data['password'] = md5($this->input->post('password'));
            $data['position'] = $this->input->post('position');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['nationality'] = $this->input->post('nationality');
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

                if (round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['quality'] = '100%';
                    $config['maintain_ratio'] = false;
                    $config['width'] = round($this->input->post('width'));
                    $config['height'] = round($this->input->post('height'));
                    $config['x_axis'] = $this->input->post('x');
                    $config['y_axis'] = $this->input->post('y');

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                    /*                 * ***** Resizing Uploaded Images ****** */
                    /*                 * ************************* ************ */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/profile';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 250;
                    $config['height'] = 250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    /* Deleting Uploaded Image After Croping and Resizing */
                    /* Why Deleting because it's saving space */
                    unlink($imagePath . '/crop/' . $uploaded_data['file_name']);

                } else {

                    /** ****** Resizing Staff Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/profile';
                    $config['maintain_ratio'] = true;
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

            $inserted = $this->db->insert('users', $data);
            if ($inserted == true) {
                $succcess['success'] = "Successfully Inserted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * *** Displaying All Users **** */
    /*     * ************************** */

    public function allusers()
    {
        $table = "users";
        $data['users'] = $this->getTotal($table);

        $this->load->view('Dashboard/header');
        $this->load->view('Users/allusers', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Viewing Individual User **** */
    /*     * ************************** */

    public function view()
    {
        $data['indiUser'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Users/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Editing Individual User **** */
    /*     * ************************** */

    public function edit()
    {
        $data['individual_user'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Users/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Updating Individual User **** */
    /*     * ************************** */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();

        $userID = $this->input->post('userid');
        $email = $this->input->post('email');
        $checked = $this->isEmailUnique($email, $userID);
        if ($checked == true) {
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean|min_length[4]|max_length[12]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|min_length[6]|max_length[12]|matches[conpassword]');
            $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|xss_clean');
            if ($this->form_validation->run() == false) {
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

                    if (round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $uploaded_data['full_path'];
                        $config['new_image'] = $imagePath . '/crop';
                        $config['quality'] = '100%';
                        $config['maintain_ratio'] = false;
                        $config['width'] = round($this->input->post('width'));
                        $config['height'] = round($this->input->post('height'));
                        $config['x_axis'] = $this->input->post('x');
                        $config['y_axis'] = $this->input->post('y');

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->crop();

                        /*                 * ***** Resizing Uploaded Images ****** */
                        /*                 * ************************* ************ */
                        $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                        $config['new_image'] = $imagePath . '/profile';
                        $config['maintain_ratio'] = true;
                        $config['width'] = 250;
                        $config['height'] = 250;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        /* Deleting Uploaded Image After Croping and Resizing */
                        /* Why Deleting because it's saving space */
                        unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                    } else {

                        /** ****** Resizing Staff Banner ****** */
                        /** ************************************** */
                        $config['source_image'] = $uploaded_data['full_path'];
                        $config['new_image'] = $imagePath . '/profile';
                        $config['maintain_ratio'] = true;
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

                $this->db->where('userid', $userID);
                $updated = $this->db->update('users', $data);
                if ($updated == true) {
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

    /*     * ************************** */
    /*     * *** Deleting Individual User **** */
    /*     * ************************** */

    public function delete($userID)
    {
        $this->db->where('userid', $userID);
        $this->db->delete('users');
        redirect('dashboard/user/allusers', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting Users By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start)
    {
        $this->db->order_by("userid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('users');
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ********** Get Total ********** */
    /*     * ************************************* */

    public function getTotal($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Getting Individual User **** */
    /*     * ************************** */

    public function getIndividual()
    {
        $userid = $this->uri->segment(4);
        $query = $this->db->get_where('users', array('userid' => $userid));
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Checking If User Update Email Is Unique/Duplicate **** */
    /*     * ************************** */

    public function isEmailUnique($email, $userID)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        if ($query->num_rows() > 0) { //If rows bigger than 0 Email Found
            foreach ($query->result() as $row) {
                $newuserid = $row->userid;
            }
            if ($newuserid == $userID) {
                return true;
            } else {
                return false; // True means unique email
            }
        } else {
            return true; // True means unique email
        }
    }

    ## User Role Functionality

    public function roles(){
        $table = "users";
        $data['users'] = $this->getTotal($table);

        $this->load->view('Dashboard/header');
        $this->load->view('Users/roles', $data);
        $this->load->view('Dashboard/footer');
    }


    public function rolepermission(){

        $data = array();
        $data['website'] = $this->input->post('website');
        $data['finance'] = $this->input->post('finance');
        $data['sermon'] = $this->input->post('sermons');
        $data['event'] = $this->input->post('events');
        $data['prayer'] = $this->input->post('prayers');
        $data['notice'] = $this->input->post('notice');
        $data['speech'] = $this->input->post('speech');
        $data['family'] = $this->input->post('family');
        $data['department'] = $this->input->post('department');
        $data['committee'] = $this->input->post('committee');
        $data['member'] = $this->input->post('members');
        $data['pastor'] = $this->input->post('pastors');
        $data['clans'] = $this->input->post('clans');
        $data['chorus'] = $this->input->post('chorus');
        $data['staffs'] = $this->input->post('staffs');
        $data['school'] = $this->input->post('sundays');
        $data['user'] = $this->input->post('users');
        $data['seminar'] = $this->input->post('seminar');
        $data['attendance'] = $this->input->post('attendance');
        $data['communicaction'] = $this->input->post('communication'); //database name wrong spelling
        $data['blog'] = $this->input->post('blog');
        $data['shop'] = $this->input->post('shop');
        $data['import'] = $this->input->post('import');
        $data['roletype'] = $this->input->post('roletype');

        $roletype = $this->input->post('roletype');
        $roleObj = $this->db->get_where('role', array('roletype' => $roletype));
        if($roleObj->num_rows() > 0){
            $true = $this->db->update('role', $data, array('roletype' => $roletype));
        }else{
            $true = $this->db->insert('role', $data);
        }
        if ($true) {
            $this->session->set_flashdata('success', 'Successfully Changed Permission');
            redirect('dashboard/user/roles', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Opps! Something Went Wrong');
            redirect('dashboard/user/roles', 'refresh');
        }

    }

    public function checkroles(){
        $roletype = $this->input->post('roletype');
        $roleObj = $this->db->get_where('role', array('roletype' => $roletype));
        if($roleObj->num_rows() > 0){
            echo json_encode($roleObj->result());
        }else{
            echo json_encode(0);
        }

        // echo json_encode($roletype);
    }


}
