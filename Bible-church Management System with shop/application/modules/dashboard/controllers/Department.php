<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MX_Controller {
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
    /*     * *** Index Page Of Department **** */
    /*     * ************************** */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Department/adddepartment');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Add Department ******* */
    /*     * ************************** */

    public function adddepartment() {
        $this->load->view('Dashboard/header');
        $this->load->view('Department/adddepartment');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Adding New Department ******* */
    /*     * ************************** */

    public function addnewdepartment() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('departmentname', 'Department Name/Title', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['departmentname'] = $this->input->post('departmentname');
            $data['departmentleader'] = $this->input->post('departmentleader');
            $data['departmentarea'] = $this->input->post('departmentarea');
            $data['departmentcontact'] = $this->input->post('departmentcontact');
            $data['description'] = $this->input->post('description');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['cdate'] = date("j F Y");
            
            $inserted = $this->db->insert('department', $data);
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
    /*     * ******* All Departments ******* */
    /*     * ************************** */

    public function alldepartment() {
        $table = "department";
        $data['department'] = $this->getTotal($table);
        $this->load->view('Dashboard/header');
        $this->load->view('Department/alldepartment', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* View Individual Department ******* */
    /*     * ************************** */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Department/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Edit Department Profile **** */
    /*     * ************************** */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Department/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Update Department Profile **** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('departmentname', 'Department Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $departmentid = $this->input->post('departmentid');

            $data['departmentname'] = $this->input->post('departmentname');
            $data['departmentleader'] = $this->input->post('departmentleader');
            $data['departmentarea'] = $this->input->post('departmentarea');
            $data['departmentcontact'] = $this->input->post('departmentcontact');
            $data['description'] = $this->input->post('description');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['cdate'] = date("j F Y");
            
            $this->db->where('departmentid', $departmentid);
            $updated = $this->db->update('department', $data);
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
    /*     * *** Delete Department Profile **** */
    /*     * ************************** */

    public function delete($departmentid) {
        $this->db->where('departmentid', $departmentid);
        $this->db->delete('department');
        redirect('dashboard/department/alldepartment', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting All Departments **** */
    /*     * ************************** */

    public function getTotal($table) {
        $query = $this->db->get($table);
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Getting Department By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start) {
        $this->db->order_by("departmentid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('department');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Get Individual Department Profile **** */
    /*     * ************************** */

    public function getIndividual() {
        $departmentid = $this->uri->segment(4);
        $query = $this->db->get_where('department', array('departmentid' => $departmentid));
        return $query->result();
    }

}
