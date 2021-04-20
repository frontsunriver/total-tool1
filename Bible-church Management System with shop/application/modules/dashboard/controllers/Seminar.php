<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Seminar extends MX_Controller
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

    /*     * ******************************* */
    /*     * ****** Index Of Seminar ******* */
    /*     * ******************************* */

    public function index()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/addseminar');
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ****** Index Of Seminar ******* */
    /*     * ******************************* */

    public function addseminar()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/addseminar');
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ****** Adding New Of Seminar ******* */
    /*     * ******************************* */

    public function addnewseminar()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('slogan', 'Slogan', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('sstart', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('send', 'End Date', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['seminartitle'] = $this->input->post('title');
            $data['seminarslogan'] = $this->input->post('slogan');
            $data['seminardescription'] = $this->input->post('description');
            $data['seminarstart'] = $this->input->post('sstart');
            $data['seminarend'] = $this->input->post('send');
            $data['seminarlocation'] = $this->input->post('location');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Seminar Banner ******* */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/seminar');
            $profileimage = $_FILES['profileimage']['tmp_name'];

            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['seminarbanner'] = $uploaded_data['file_name'];
                } else {
                    $data['seminarbanner'] = '';
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

                    /** ****** Resizing Uploaded Banner ******* */
                    /*************************************** */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/banner';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 750;
                    $config['height'] = 250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    /* Deleting Uploaded Image After Croping and Resizing */
                    /* Why Deleting because it's saving space */
                    unlink($imagePath . '/crop/' . $uploaded_data['file_name']);


                } else {

                    /** ****** Resizing Seminar Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/banner';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 750;
                    $config['height'] = 250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                }

                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }

            $inserted = $this->db->insert('seminar', $data);
            if ($inserted == true) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ******************************* */
    /*     * ****** All Seminar ************ */
    /*     * ******************************* */

    public function allseminar()
    {
        $baselink = "seminar/allseminar";
        $database = "seminar";
        $perpage = 10;
        $limit = iniPagination($baselink, $database, $perpage);
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['seminars'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/allseminar', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** All Applicants Of Seminar *** */
    /*     * ******************************* */

    public function allregistered()
    {
        $data['seminar_list'] = $this->getSeminarList();
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/allregistered', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** View Individual Seminar *** */
    /*     * ******************************* */

    public function view()
    {
        $data['individual'] = $this->getIndividualSeminar();
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Edit Individual Seminar *** */
    /*     * ******************************* */

    public function edit()
    {
        $data['individual'] = $this->getIndividualSeminar();
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ****** Update Existing  ******* */
    /*     * ******************************* */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('slogan', 'Slogan', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('sstart', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('send', 'End Date', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $seminarid = $this->input->post('seminarid');
            $data['seminartitle'] = $this->input->post('title');
            $data['seminarslogan'] = $this->input->post('slogan');
            $data['seminardescription'] = $this->input->post('description');
            $data['seminarstart'] = $this->input->post('sstart');
            $data['seminarend'] = $this->input->post('send');
            $data['seminarlocation'] = $this->input->post('location');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Seminar Banner ******* */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/seminar');
            $profileimage = $_FILES['profileimage']['tmp_name'];

            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['seminarbanner'] = $uploaded_data['file_name'];
                } else {
                    $data['seminarbanner'] = '';
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

                    /******** Resizing Seminar Banner ******* */
                    /**************************************** */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/banner';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 750;
                    $config['height'] = 250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    /* Deleting Uploaded Image After Croping and Resizing */
                    /* Why Deleting because it's saving space */
                    unlink($imagePath . '/crop/' . $uploaded_data['file_name']);

                } else {

                    /** ****** Resizing Seminar Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/banner';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 750;
                    $config['height'] = 250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                }

                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);

            }

            $this->db->where('seminarid', $seminarid);
            $updated = $this->db->update('seminar', $data);
            if ($updated == true) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ******************************* */
    /*     * ** Delete Seminar ************* */
    /*     * ******************************* */

    public function delete($seminarid)
    {
        $this->db->where('seminarid', $seminarid);
        $deleted = $this->db->delete('seminar');
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/seminar/allseminar', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/seminar/allseminar', 'refresh');
        }
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function applicants()
    {
        $data['seminar_list'] = $this->getSeminarList();
        $data['applicants'] = '';
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/applicants', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function applicantslist()
    {
        $selectedseminarid = $this->input->post('selectedseminarid');
        if ($selectedseminarid > 0) {
            $data['seminar_list'] = $this->getSeminarList();
            $data['applicants'] = $this->getSelectedApplicants($selectedseminarid);
            $data['current_seminar'] = $this->getCurrentSeminarTitle($selectedseminarid);
            $this->load->view('Dashboard/header');
            $this->load->view('Seminar/applicants', $data);
            $this->load->view('Dashboard/footer');
        } else {
            redirect('dashboard/seminar/applicants', 'refresh');
        }
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function viewapplicant($seminarregid)
    {
        $data['individual'] = $this->getCurrentApplicant($seminarregid);
        $data['seminartitle'] = $this->getApplicantSeminarTitle($seminarregid);
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/viewapplicant', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function editapplicant($seminarregid)
    {
        $data['individual'] = $this->getCurrentApplicant($seminarregid);
        $data['seminartitle'] = $this->getApplicantSeminarTitle($seminarregid);
        $data['seminar_list'] = $this->getSeminarList();
        $this->load->view('Dashboard/header');
        $this->load->view('Seminar/editapplicant', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Update Individual Applicant */
    /*     * ******************************* */

    public function updateaplicant()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('selectedseminarid', 'Seminar', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $seminarregid = $this->input->post('seminarregid');
            $data['selectedseminarid'] = $this->input->post('selectedseminarid');
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['age'] = $this->input->post('age');
            $data['education'] = $this->input->post('education');
            $data['church'] = $this->input->post('church');
            $data['churchpastor'] = $this->input->post('churchpastor');
            $data['guardian'] = $this->input->post('guardian');
            $data['guardiancontact'] = $this->input->post('guardiancontact');
            $data['nationality'] = $this->input->post('nationality');
            $data['paymentgateway'] = $this->input->post('paymentgateway');
            $data['paymentgatewayinfo'] = $this->input->post('paymentgetwayinfo');
            $data['paymentsenderinfo'] = $this->input->post('paymentsenderinfo');
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
            $imagePath = realpath(APPPATH . '../assets/assets/images/seminar');
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

                    /* Resizing Uploaded Images */
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

                    /** ****** Resizing Seminer Banner ****** */
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

            $this->db->where('seminarregid', $seminarregid);
            $updated = $this->db->update('seminarregistration', $data);
            if ($updated == true) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ******************************* */
    /*     * ** Delete Seminar ************* */
    /*     * ******************************* */

    public function deleteapplicant($seminarregid)
    {
        $this->db->where('seminarregid', $seminarregid);
        $deleted = $this->db->delete('seminarregistration');
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/seminar/applicants', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/seminar/applicants', 'refresh');
        }
    }

    /*     * ******************************* */
    /*     * ** Get Selected Applicants **** */
    /*     * ******************************* */

    public function getCurrentApplicant($seminarregid)
    {
        $query = $this->db->get_where('seminarregistration', array('seminarregid' => $seminarregid));
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ** Get Current Seminar Title ** */
    /*     * ******************************* */

    public function getApplicantSeminarTitle($seminarregid)
    {
        $query = $this->db->get_where('seminarregistration', array('seminarregid' => $seminarregid));
        $seminarid = $query->result()[0]->selectedseminarid;

        $query = $this->db->get_where('seminar', array('seminarid' => $seminarid));
        return $query->result()[0]->seminartitle;
    }

    /*     * ******************************* */
    /*     * ** Get Selected Applicants **** */
    /*     * ******************************* */

    public function getSelectedApplicants($selectedseminarid)
    {
        $this->db->order_by("seminarregid", "desc");
        $query = $this->db->get_where('seminarregistration', array('selectedseminarid' => $selectedseminarid));
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ** Get Current Seminar Title ** */
    /*     * ******************************* */

    public function getCurrentSeminarTitle($selectedseminarid)
    {
        $query = $this->db->get_where('seminar', array('seminarid' => $selectedseminarid));
        return $query->result()[0]->seminartitle;
    }

    /*     * ******************************* */
    /*     * ** Get Seminar Lists ********** */
    /*     * ******************************* */

    public function getSeminarList()
    {
        $this->db->order_by("seminarid", "desc");
        $query = $this->db->get('seminar');
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ** View Individual Seminar *** */
    /*     * ******************************* */

    public function getIndividualSeminar()
    {
        $seminarid = $this->uri->segment(4);
        $query = $this->db->get_where('seminar', array('seminarid' => $seminarid));
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ******************************* */
    /*     * ** Get Pagination Of Seminar *** */

    public function getPagiData($limit, $start)
    {
        $this->db->order_by("seminarid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('seminar');
        return $query->result();
    }
}
