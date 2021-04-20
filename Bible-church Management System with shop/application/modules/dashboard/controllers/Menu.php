<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MX_Controller {

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
    /*     * *** Website Index Menu **** */
    /*     * ************************** */

    public function index() {
        $data['parentmenu'] = $this->parentmenus();
        $data['menus'] = $this->allmenus();
        $data['pages'] = $this->allpages();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/menu', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Menu **** */
    /*     * ************************** */

    public function menu() {
        $data['menus'] = $this->allmenus();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/menu', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******** Add Menu ******** */
    /*     * ************************** */

    public function add() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('menuname', 'Menu Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['menuname'] = $this->input->post('menuname');
            $data['menuparentid'] = $this->input->post('menuparent');
            $data['menupageid'] = $this->input->post('menupage');
            $data['menulink'] = $this->input->post('menulink');
            $data['cdate'] = date("j F Y");

            $inserted = $this->db->insert('menu', $data);
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
    /*     * *** Website Menu View **** */
    /*     * ************************** */

    public function edit() {
        $data['individual'] = $this->individual();
        $data['selectedparent'] = $this->selectedParent();
        $data['selectedpage'] = $this->selectedPage();
        $data['menus'] = $this->allmenus();
        $data['pages'] = $this->allpages();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******** Update Menu ******** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $menuid = $this->input->post('menuid');

        $this->form_validation->set_rules('menuname', 'Menu Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['menuname'] = $this->input->post('menuname');
            $data['menuparentid'] = $this->input->post('menuparent');
            $data['menupageid'] = $this->input->post('menupage');
            $data['menulink'] = $this->input->post('menulink');
            $data['cdate'] = date("j F Y");

            $this->db->where('menuid', $menuid);
            $updated = $this->db->update('menu', $data);
            if ($updated == TRUE) {
                $succcess['success'] = "Successfully Updted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ****** Individual Delete Menu ******* */
    /*     * ************************************* */

    public function delete($menuid) {
        $this->db->where('menuid', $menuid);
        $deleted = $this->db->delete('menu');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/menu/', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/menu/', 'refresh');
        }
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function selectedParent() {
        $currentMenuID = $this->uri->segment(4);
        $this->db->where('menuid', $currentMenuID);
        $qMenuID = $this->db->get('menu');
        if($qMenuID->num_rows() > 0 ){
            $qMenuIDFinal = $qMenuID->result()[0];
            $this->db->where('menuid', $qMenuIDFinal->menuparentid);
            $qParentMenu = $this->db->get('menu');
            if($qParentMenu->num_rows() > 0 ){
                $qParentFianl = $qParentMenu->result()[0];
            }else{
                $qParentFianl = "";
            }
            return array($qMenuIDFinal, $qParentFianl);
        }else{
            return " ";
        }
    }


    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function selectedPage() {
        $this->db->where('pageslug', $this->selectedParent()[0]->menupageid);
        $qPage = $this->db->get('page');
        if($qPage->num_rows() > 0 ){
            return $qPageFinal = $qPage->result()[0];
        }else{
            return " ";
        }
    }


    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function parentmenus() {
        $this->db->where('menuparentid', " ");
        $this->db->order_by('serialid', "asc");
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function unassignmenus() {
        $this->db->where('menuparentid', " ");
        $this->db->order_by('serialid', "asc");
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function individual() {
        $menuid = $this->uri->segment(4);
        $this->db->where('menuid', $menuid);
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function allmenus() {
        //$this->db->order_by('serialid');
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function allpages() {
        $query = $this->db->get('page');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function sortmenu() {
        $sorted = $this->input->post('sort');

        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $menuid = $data[0][$x]["id"];
            if (strlen($menuid) > 2) {
                $submenuarr = explode(",", $menuid);
                $submenuid = $submenuarr[0];
                $parentmenuid = $submenuarr[1];
                $submenuserial = $submenuarr[2];

                $query = $this->db->get_where('menu', array('menuid' => $parentmenuid));
                $parentmenuserialid = $query->result()[0]->serialid;

                $arrdata = array();
                $arrdata['serialid'] = $parentmenuid;
                $arrdata['subserialid'] = $x;
                $this->db->where('menuid', $submenuid);
                $this->db->update('menu', $arrdata);
            } else {
                $arrdata = array();
                $arrdata['serialid'] = $x;
                $this->db->where('menuid', $menuid);
                $this->db->update('menu', $arrdata);
            }
        }
    }



    /*     * ************************** */
    /*     * ******** Update Menu ******** */
    /*     * ************************** */

    public function updateurl() {

        $errors = array();
        $success = array();
        $data = array();
        $i=0;

        $oldUrl = $this->input->post('oldurl');
        $newurl = $this->input->post('newurl');

        $query = $this->db->get('menu');
        foreach ($query->result() as $row) {

            $menuID = $row->menuid;
            $menuLink = $row->menulink;
            $finalUrl = str_replace($oldUrl, $newurl, $menuLink);

            $data['menulink'] = $finalUrl;
            $data['cdate'] = date("j F Y");

            $this->db->where('menuid', $menuID);
            $update = $this->db->update('menu', $data);

            if ($update == TRUE) {
                $i++;
            }

        }

        if ($i > 0) {
            $this->session->set_flashdata('success', $i . ' Menu URL Successfully Changed');
            redirect('dashboard/menu/', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/menu/', 'refresh');
        }


    }



}
