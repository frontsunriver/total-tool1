<?php

defined('BASEPATH') or exit('No direct script access allowed');

class License extends MX_Controller
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

    function __construct()
    {
        parent::__construct();

        $this->load->library('hybridauth');

        isLoginRedirect();

        $this->load->dbforge();
        //no where to go as dashboard already redirect here

    }

    public function index()
    {
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header', $data);
        $this->load->view('license', $data);
        $this->load->view('footer', $data);
    }

    /*     * ************************** */
    /*     * *** Get Basic Info ******* */
    /*     * ************************** */

    public function getBasicInfo()
    {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    public function insertLicense()
    {

        //modify fields for settings table
        $SettingsFieldsModify = array(
            array('licUsername' => array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE,)),
            array('licPurchaseDate' => array('type' => 'varchar', 'constraint' => 255, 'null' => TRUE,)),
        );

        for ($x = 0; count($SettingsFieldsModify) > $x; $x++) {
            $fieldName = key($SettingsFieldsModify[$x]); //field name
            if ($this->db->field_exists($fieldName, 'websitebasic') == false) {
                $this->dbforge->add_column('websitebasic', $SettingsFieldsModify[$x]); //if not found then insert new column
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Envato Username', 'required');
        $this->form_validation->set_rules('code', 'Purchase Code', 'required');
        $this->form_validation->set_rules('date', 'Purchase Date', 'required');

        if ($this->form_validation->run()) {

            $data = array();
            $data['verify'] = $this->input->post('code');
            $data['licUsername'] = $this->input->post('username');
            $data['licPurchaseDate'] = $this->input->post('date');
            $this->db->where('basicid', 1);
            $insertRes = $this->db->update('websitebasic', $data);
            if ($insertRes == TRUE) {
                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('user_email');
                $this->session->unset_userdata('user_position');
                $this->session->unset_userdata('logged_in', FALSE);
                $this->session->unset_userdata('license_status', FALSE);
                $this->session->sess_destroy();                
                redirect('access/login', 'refresh');
            } else {
                redirect('access/license', 'refresh');
            }
        } else {
            $sessionMessage['error'] = validation_errors();
            $this->session->set_flashdata($sessionMessage);
            redirect('access/license', 'refresh');
        }
    }
}
