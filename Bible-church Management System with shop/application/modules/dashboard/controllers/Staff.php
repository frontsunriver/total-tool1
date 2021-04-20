<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends MX_Controller
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
    /*     * ********** Index Of Staff ********** */
    /*     * ************************************* */

    public function index()
    {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Staff/addstaff', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Adding Staff *********** */
    /*     * ************************************* */

    public function addstaff()
    {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Staff/addstaff', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Adding New Staff *********** */
    /*     * ************************************* */

    public function addnewstaff()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['position'] = $this->input->post('position');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['marriagedate'] = $this->input->post('marriagedate');
            $data['socialstatus'] = $this->input->post('socialstatus');
            $data['job'] = $this->input->post('job');
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


            /*             * ***** Uploading Profile Image ******* */
            /*             * ************************* ************ */
            $imagePath = realpath(APPPATH . '../assets/assets/images/staff');
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

            $inserted = $this->db->insert('staff', $data);
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
    /*     * ************* All Staff ************* */
    /*     * ************************************* */

    public function allstaffs()
    {
        $table = "staff";
        $data['staff'] = $this->getTotal($table);

        $this->load->view('Dashboard/header');
        $this->load->view('Staff/allstaffs', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************* View Staff ************* */
    /*     * ************************************* */

    public function view()
    {
        $data['individual'] = $this->getIndividual();
        $data['events'] = $this->getEvents();
        $this->load->view('Dashboard/header');
        $this->load->view('Staff/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************* Edit Staff ************* */
    /*     * ************************************* */

    public function edit()
    {
        $data['individual'] = $this->getIndividual();
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Staff/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Adding New Staff *********** */
    /*     * ************************************* */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();

        $staffid = $this->input->post('staffid');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['position'] = $this->input->post('position');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['marriagedate'] = $this->input->post('marriagedate');
            $data['socialstatus'] = $this->input->post('socialstatus');
            $data['job'] = $this->input->post('job');
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


            /*             * ***** Uploading Profile Image ******* */
            /*             * ************************* ************ */
            $imagePath = realpath(APPPATH . '../assets/assets/images/staff');
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

            $this->db->where('staffid', $staffid);
            $updated = $this->db->update('staff', $data);
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
    /*     * ****** Delete Individual Staff ****** */
    /*     * ************************************* */

    public function delete($staffid)
    {
        $this->db->where('staffid', $staffid);
        $deleted = $this->db->delete('staff');
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/staff/allstaffs', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/staff/allstaffs', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ****** Get Pagination By Staff ****** */
    /*     * ************************************* */

    public function getPagiData($limit, $start)
    {
        $this->db->order_by("staffid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('staff');
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

    /*     * ************************************* */
    /*     * ******** Get Individual Staff ******** */
    /*     * ************************************* */

    public function getIndividual()
    {
        $staffid = $this->uri->segment(4);
        $query = $this->db->get_where('staff', array('staffid' => $staffid));
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
