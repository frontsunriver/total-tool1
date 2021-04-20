<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends MX_Controller {
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
    /*     * *** Index Page Of Family **** */
    /*     * ************************** */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Family/addfamily');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Add Family ******* */
    /*     * ************************** */

    public function addfamily() {
        $this->load->view('Dashboard/header');
        $this->load->view('Family/addfamily');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Adding New Family ******* */
    /*     * ************************** */

    public function addnewfamily() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('familyname', 'Family Name/Title', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['familyname'] = $this->input->post('familyname');
            $data['familyleader'] = $this->input->post('familyleader');
            $data['memberquantity'] = $this->input->post('memberquantity');
            $data['familycontact'] = $this->input->post('familycontact');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['cdate'] = date("j F Y");
            
            $inserted = $this->db->insert('family', $data);
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
    /*     * ******* All Familys ******* */
    /*     * ************************** */

    public function allfamily() {
        $table = "family";
        $data['family'] = $this->getTotal($table);
        $this->load->view('Dashboard/header');
        $this->load->view('Family/allfamily', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* View Individual Family ******* */
    /*     * ************************** */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Family/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Edit Family Profile **** */
    /*     * ************************** */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Family/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Update Family Profile **** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('familyname', 'Family Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $familyid = $this->input->post('familyid');

            $data['familyname'] = $this->input->post('familyname');
            $data['familyleader'] = $this->input->post('familyleader');
            $data['memberquantity'] = $this->input->post('memberquantity');
            $data['familycontact'] = $this->input->post('familycontact');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['cdate'] = date("j F Y");
            
            $this->db->where('familyid', $familyid);
            $updated = $this->db->update('family', $data);
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
    /*     * *** Delete Family Profile **** */
    /*     * ************************** */

    public function delete($familyid) {
        $this->db->where('familyid', $familyid);
        $this->db->delete('family');
        redirect('dashboard/family/allfamily', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting All Familys **** */
    /*     * ************************** */

    public function getTotal($table) {
        $query = $this->db->get($table);
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Getting Family By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start) {
        $this->db->order_by("familyid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('family');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Get Individual Family Profile **** */
    /*     * ************************** */

    public function getIndividual() {
        $familyid = $this->uri->segment(4);
        $query = $this->db->get_where('family', array('familyid' => $familyid));
        return $query->result();
    }

}
