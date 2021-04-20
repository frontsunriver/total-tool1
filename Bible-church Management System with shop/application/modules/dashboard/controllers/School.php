<?php

defined('BASEPATH') or exit('No direct script access allowed');

class School extends MX_Controller
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

    /*     * ************************************* */
    /*     * ****** Index Of Sunday School ****** */
    /*     * ************************************* */

    public function index()
    {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('School/addstudent', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ****** Add Student Sunday School ****** */
    /*     * ************************************* */

    public function addstudent()
    {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('School/addstudent', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ****** Add New Student Sunday School ****** */
    /*     * ************************************* */

    public function addnewstudent()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('guardian_phone', 'Guardian Phone', 'trim|required');
        $this->form_validation->set_rules('guardian', 'Guardian', 'trim|required');
        $this->form_validation->set_rules('age', 'Age', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
            $data['phone'] = $this->input->post('guardian_phone');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['guardian'] = $this->input->post('guardian');
            $data['age'] = $this->input->post('age');
            $data['sclass'] = $this->input->post('sclass');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['family'] = $this->input->post('family');
            $data['department'] = $this->input->post('department');
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

            /*             * ****** Uploading Profile Image ******* */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/sundayschool');
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
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
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

                    /* ****** Resizing Uploaded Image ******* */
                    /* ************************************** */
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

                    /** ****** Resizing School Banner ****** */
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

            $inserted = $this->db->insert('sundayschool', $data);
            if ($inserted == true) {
                $succcess['success'] = "Successfully Inserted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ****** View Student Sunday School ****** */
    /*     * ************************************* */

    public function allstudents()
    {
        $table = "sundayschool";
        $data['sundayschool'] = $this->getTotal($table);

        $this->load->view('Dashboard/header');
        $this->load->view('School/allstudents', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ****** View Student Sunday School ****** */
    /*     * ************************************* */

    public function view()
    {
        $data['individual'] = $this->getIndividual();
        $data['events'] = $this->getEvents();
        $this->load->view('Dashboard/header');
        $this->load->view('School/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ****** Edit Individual Student ****** */
    /*     * ************************************* */

    public function edit()
    {
        $data['individual'] = $this->getIndividual();
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('School/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ****** Add New Student Sunday School ****** */
    /*     * ************************************* */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();

        $sschoolid = $this->input->post('sschoolid');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('guardian_phone', 'Guardian Phone', 'trim|required');
        $this->form_validation->set_rules('guardian', 'Guardian', 'trim|required');
        $this->form_validation->set_rules('age', 'Age', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
            $data['phone'] = $this->input->post('guardian_phone');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['guardian'] = $this->input->post('guardian');
            $data['age'] = $this->input->post('age');
            $data['sclass'] = $this->input->post('sclass');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['family'] = $this->input->post('family');
            $data['department'] = $this->input->post('department');
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

            /*             * ****** Uploading Profile Image ******* */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/sundayschool');
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
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
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

                    /** ****** Resizing Uploaded Image ******* */
                    /** ************************************** */
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

                    /** ****** Resizing School Banner ****** */
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

            $this->db->where('sschoolid', $sschoolid);
            $updated = $this->db->update('sundayschool', $data);
            if ($updated == true) {
                $succcess['success'] = "Successfully Updated";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ****** Delete Individual Student ****** */
    /*     * ************************************* */

    public function delete($sschoolid)
    {
        $this->db->where('sschoolid', $sschoolid);
        $deleted = $this->db->delete('sundayschool');
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/school/allstudents', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/school/allstudents', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ********** Get Total ********** */
    /*     * ************************************* */

    public function getTotal($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ****** Get Individual Student ****** */
    /*     * ************************************* */

    public function getIndividual()
    {
        $sschoolid = $this->uri->segment(4);
        $query = $this->db->get_where('sundayschool', array('sschoolid' => $sschoolid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ****** Get Pagination Data ****** */
    /*     * ************************************* */

    public function getPagiData($limit, $start)
    {
        $this->db->order_by("sschoolid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('sundayschool');
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getEvents()
    {
        $group = $this->uri->segment(2);
        $userID = $this->uri->segment(4);
        $queryEvents = $this->db->get_where('attendance', array('userid' => $userID, 'grouptype' => $group, 'status' => 'present'));
        return $queryEvents->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getFamily()
    {
        $queryFamily = $this->db->get('family');
        return $queryFamily->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getDepartment()
    {
        $queryDepartment = $this->db->get('department');
        return $queryDepartment->result();
    }
}
