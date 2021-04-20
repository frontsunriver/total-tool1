<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MX_Controller {
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
        $this->load->library('hybridauth');        
    }

    public function index() {
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header', $data);
        $this->load->view('register', $data);
        $this->load->view('footer', $data);
    }

    /*     * ************************** */
    /*     * *** Get Basic Info ******* */
    /*     * ************************** */

    public function getBasicInfo() {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    public function addnewuser() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'User Name', 'required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]');

        if ($this->form_validation->run()) {

            $data = array();
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $data['position'] = 'Subscriber';

            if (!empty($username)) {
                $data['username'] = $this->input->post('username');
            }

            if (!empty($email)) {
                $data['email'] = $this->input->post('email');
            }

            if (!empty($password)) {
                $data['password'] = md5($this->input->post('password'));
            }

            if ($data) {
                $this->db->insert('users', $data);
            }

            //echo json_encode($errors);
            redirect('access/login/', 'refresh');
        } else {

            $session_msg = array();
            $session_msg['register_error'] = validation_errors();
            //$this->session->set_userdata($session_msg);
            $this->session->set_flashdata($session_msg);

            $data['basicinfo'] = $this->getBasicInfo();
            $this->load->view('header', $data);
            $this->load->view('register', $data);
            $this->load->view('footer', $data);
        }
    }

    public function media($provider_id) {
        $params = array(
            'hauth_return_to' => site_url("access/register/media/{$provider_id}"),
        );
        if (isset($_REQUEST['openid_identifier'])) {
            $params['openid_identifier'] = $_REQUEST['openid_identifier'];
        }
        try {
            $adapter = $this->hybridauth->HA->authenticate($provider_id, $params);
            $profile = $adapter->getUserProfile();
            $media = $this->uri->segment(4);
            if ($media == "Facebook") {
                $accessKey = $profile->email;
            } elseif ($media == "Google") {
                $accessKey = $profile->email;
            } elseif ($media == "Twitter") {
                $accessKey = $profile->identifier;
            }

            if (!empty($accessKey)) {

                if ($media == "Facebook") {
                    $this->db->where('email', $accessKey);
                } elseif ($media == "Google") {
                    $this->db->where('email', $accessKey);
                } elseif ($media == "Twitter") {
                    $this->db->where('mediaIdentifier', $accessKey);
                }

                $query = $this->db->get('users');
                if ($query->num_rows() < 1) {

                    //Insert new User
                    if ($media == "Facebook") {
                        $data['email'] = $profile->email;
                    } elseif ($media == "Google") {
                        $data['email'] = $profile->email;
                    } elseif ($media == "Twitter") {
                        $data['mediaIdentifier'] = $profile->identifier;
                    }
                    $this->db->insert('users', $data);

                    //Auto Login after register by social media
                    $queryLogin = $this->db->get_where('users', array('email' => $profile->email));
                    foreach ($queryLogin->result() as $rows) {
                        $newdata = array(
                            'user_id' => $rows->userid,
                            'user_email' => $rows->email,
                            'user_position' => $rows->position,
                            'logged_in' => TRUE,
                        );
                        $this->session->set_userdata($newdata);
                    }
                    if ($this->session->userdata('logged_in')) {
                        redirect('dashboard', 'refresh');
                    }
                } else {

                    $session_msg = array();
                    $session_msg['login_error'] = "User Already Exist";
                    $this->session->set_flashdata($session_msg);
                    $data['basicinfo'] = $this->getBasicInfo();
                    $this->load->view('header', $data);
                    $this->load->view('login', $data);
                    $this->load->view('footer', $data);
                }
            } else {

                $session_msg = array();
                $session_msg['login_error'] = "Sorry! Something Went Wrong, Please Try Another Media";
                $this->session->set_flashdata($session_msg);

                $data['basicinfo'] = $this->getBasicInfo();
                $this->load->view('header', $data);
                $this->load->view('login', $data);
                $this->load->view('footer', $data);
            }
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    /**
     * Handle the OpenID and OAuth endpoint
     */
    public function endpoint() {
        $this->hybridauth->process();
    }

}
