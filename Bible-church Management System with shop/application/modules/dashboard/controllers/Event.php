<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Event extends MX_Controller
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
    /*     * ******* Index Of Event ************ */
    /*     * ************************************* */

    public function index()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Event/addevent');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Add Event **************** */
    /*     * ************************************* */

    public function addevent()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Event/addevent');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Add New Events ************ */
    /*     * ************************************* */

    public function addnewevent()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('eventtitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('eventdate', 'Date', 'trim|required');
        $this->form_validation->set_rules('eventtime', 'Time', 'trim|required');
        $this->form_validation->set_rules('eventlocation', 'Location', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['eventtitle'] = $this->input->post('eventtitle');
            $data['eventdate'] = $this->input->post('eventdate');
            $data['eventtime'] = $this->input->post('eventtime');
            $data['eventlocation'] = $this->input->post('eventlocation');
            $data['eventdescription'] = $this->input->post('eventdescription');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/event');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['eventimage'] = $uploaded_data['file_name'];
                } else {
                    $data['eventimage'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
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

                    /******** Resizing Event Banner ****** */
                    /**************************************** */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/feature';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 500;
                    $config['height'] = 300;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    /* Deleting Uploaded Image After Cropping and Resizing */
                    /* Why Deleting because it's saving space */
                    //unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                } else {

                    /** ****** Resizing Event Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/feature';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 500;
                    $config['height'] = 300;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                /* Deleting Uploaded Image After Cropping and Resizing */
                /* Why Deleting because it's saving space */
                //unlink($uploaded_data['full_path']);
            }

            $inserted = $this->db->insert('event', $data);
            if ($inserted == true) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* View All Events ************ */
    /*     * ************************************* */

    public function allevents()
    {
        $table = "event";
        $data['event'] = $this->getTotal($table);
        $this->load->view('Dashboard/header');
        $this->load->view('Event/allevents', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************* View Event ************* */
    /*     * ************************************* */

    public function view()
    {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Event/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************ Edit Event ************ */
    /*     * ************************************* */

    public function edit()
    {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Event/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Update Events ************ */
    /*     * ************************************* */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();
        $eventid = $this->input->post('eventid');
        $this->form_validation->set_rules('eventtitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('eventdate', 'Date', 'trim|required');
        $this->form_validation->set_rules('eventtime', 'Time', 'trim|required');
        $this->form_validation->set_rules('eventlocation', 'Location', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['eventtitle'] = $this->input->post('eventtitle');
            $data['eventdate'] = $this->input->post('eventdate');
            $data['eventtime'] = $this->input->post('eventtime');
            $data['eventlocation'] = $this->input->post('eventlocation');
            $data['eventdescription'] = $this->input->post('eventdescription');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/event');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['eventimage'] = $uploaded_data['file_name'];
                } else {
                    $data['eventimage'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
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

                    /* ****** Resizing Event Banner ****** */
                    /**************************************** */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/feature';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 500;
                    $config['height'] = 300;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    /* Deleting Uploaded Image After Cropping and Resizing */
                    /* Why Deleting because it's saving space */
                    unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                } else {

                    /** ****** Resizing Event Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/feature';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 500;
                    $config['height'] = 300;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                /* Deleting Uploaded Image After Cropping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }

            $this->db->where('eventid', $eventid);
            $updated = $this->db->update('event', $data);
            if ($updated == true) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* Delete Individual Event ******* */
    /*     * ************************************* */

    public function delete($eventid)
    {
        $this->db->where('eventid', $eventid);
        $deleted = $this->db->delete('event');
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/event/allevents', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/event/allevents', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ******* Get Individual Event ******* */
    /*     * ************************************* */

    public function getIndividual()
    {
        $eventid = $this->uri->segment(4);
        $query = $this->db->get_where('event', array('eventid' => $eventid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Pagination Events ************ */
    /*     * ************************************* */

    public function getPagiData($limit, $start)
    {
        $this->db->order_by("eventid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('event');
        return $query->result();
    }


    /*     * ************************************* */
    /*     * ******* Get Pagination Events ************ */
    /*     * ************************************* */
    public function getTotal($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }


    public function addApplicant()
    {
        $data['events'] = $this->getEventList();
        $this->load->view('Dashboard/header');
        $this->load->view('Event/addapplicant', $data);
        $this->load->view('Dashboard/footer');
    }


    /*     * ************************************* */
    /*     * ******* Add New Event Registration ************ */
    /*     * ************************************* */

    public function registration()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('gender', 'Select Gender', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('postal', 'Postal', 'trim|required');
        $this->form_validation->set_rules('participanttype', 'Participant Type', 'trim|required');
        if ($this->form_validation->run() == false) {
            //$errors['errorFormValidation'] = validation_errors();
            $this->session->set_flashdata('notsuccess', validation_errors());
            redirect('home/event/view/' . $data['eventID'], 'refresh');
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['email'] = $this->input->post('email');
            $data['phone'] = $this->input->post('phone');
            $data['gender'] = $this->input->post('gender');
            $data['birthdate'] = $this->input->post('birthdate');
            $data['nationality'] = $this->input->post('nationality');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['participant'] = $this->input->post('participanttype');
            $data['hotel'] = $this->input->post('hotel');
            $data['room'] = $this->input->post('room');
            $data['seat'] = $this->input->post('seat');
            $data['bus'] = $this->input->post('bus');
            $data['badge'] = $this->input->post('badge');
            $data['confirmation'] = $this->input->post('confirmation');
            $data['userID'] = 0;
            $data['eventID'] = $this->input->post('eventid');
            $data['cdate'] = date("j F Y");

            $inserted = $this->db->insert('eventregistration', $data);
            if ($inserted == true) {
                $this->session->set_flashdata('success', 'Successfull Event Registration');
                redirect('home/event/view/' . $data['eventID'], 'refresh');
            } else {
                $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong!');
                redirect('home/event/view/' . $data['eventID'], 'refresh');
            }
        }
    }

    /*     * ******************************* */
    /*     * ** All Applicants Of Seminar *** */
    /*     * ******************************* */

    public function applicants()
    {
        // $data['applicants'] = $this->getRegisteredList();
        $data['events'] = $this->getEventList();
        $this->load->view('Dashboard/header');
        $this->load->view('Event/applicants', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function applicantslist()
    {
        $eventid = $this->input->post('eventid');
        if ($eventid > 0) {
            $data['events'] = $this->getEventList();
            $data['applicants'] = $this->getSelectedApplicants($eventid);
            $data['current_event'] = $this->getCurrentEventTitle($eventid);
            $this->load->view('Dashboard/header');
            $this->load->view('Event/applicants', $data);
            $this->load->view('Dashboard/footer');
        } else {
            redirect('dashboard/event/applicants', 'refresh');
        }
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function viewapplicant($registrationID)
    {
        $data['individual'] = $this->getCurrentApplicant($registrationID);
        $data['eventtitle'] = $this->getApplicantEventTitle($registrationID);
        $this->load->view('Dashboard/header');
        $this->load->view('Event/viewapplicant', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Get All Applicants ********* */
    /*     * ******************************* */

    public function editapplicant($seminarregid)
    {
        $data['individual'] = $this->getCurrentApplicant($seminarregid);
        $data['events'] = $this->getEventList();
        $this->load->view('Dashboard/header');
        $this->load->view('Event/editapplicant', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * ** Update Individual Applicant */
    /*     * ******************************* */

    public function updateapplicant()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('gender', 'Select Gender', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('postal', 'Postal', 'trim|required');
        if ($this->form_validation->run() == false) {
            //$errors['errorFormValidation'] = validation_errors();
            $this->session->set_flashdata('notsuccess', validation_errors());
            redirect('dashboard/event/applicants', 'refresh');
        } else {
            $registrationID = $this->input->post('registrationID');
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['email'] = $this->input->post('email');
            $data['phone'] = $this->input->post('phone');
            $data['gender'] = $this->input->post('gender');
            $data['birthdate'] = $this->input->post('birthdate');
            $data['nationality'] = $this->input->post('nationality');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['hotel'] = $this->input->post('hotel');
            $data['room'] = $this->input->post('room');
            $data['seat'] = $this->input->post('seat');
            $data['bus'] = $this->input->post('bus');
            $data['badge'] = $this->input->post('badge');
            $data['confirmation'] = $this->input->post('confirmation');
            $data['participant'] = $this->input->post('participanttype');
            $data['userID'] = 0;
            $data['eventID'] = $this->input->post('eventid');
            $data['cdate'] = date("j F Y");

            $inserted = $this->db->update('eventregistration', $data, array('registrationID' => $registrationID));
            if ($inserted == true) {
                $this->session->set_flashdata('success', 'Successfully Updated Event Registration');
                redirect('dashboard/event/viewapplicant/' . $registrationID, 'refresh');
            } else {
                $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong!');
                redirect('dashboard/event/applicants', 'refresh');
            }
        }
    }

    /*     * ******************************* */
    /*     * ** Delete Seminar ************* */
    /*     * ******************************* */

    public function deleteapplicant($registrationID)
    {
        $deleted = $this->db->delete('eventregistration', array('registrationID' => $registrationID));
        if ($deleted == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/event/applicants', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/event/applicants', 'refresh');
        }
    }

    /*     * ******************************* */
    /*     * ** Get Selected Applicants **** */
    /*     * ******************************* */

    public function getCurrentApplicant($registrationID)
    {
        $query = $this->db->get_where('eventregistration', array('registrationID' => $registrationID));
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ** Get Current Seminar Title ** */
    /*     * ******************************* */

    public function getApplicantEventTitle($registrationID)
    {
        $query = $this->db->get_where('eventregistration', array('registrationID' => $registrationID));
        $eventID = $query->result()[0]->eventID;

        $query = $this->db->get_where('event', array('eventid' => $eventID));
        return $query->result()[0]->eventtitle;
    }


    /*     * ******************************* */
    /*     * ** Get Selected Applicants **** */
    /*     * ******************************* */

    public function getSelectedApplicants($eventid)
    {
        $this->db->order_by("registrationID", "desc");
        $query = $this->db->get_where('eventregistration', array('eventID' => $eventid));
        return $query->result();
    }

    /*     * ******************************* */
    /*     * ** Get Current Seminar Title ** */
    /*     * ******************************* */

    public function getCurrentEventTitle($eventid)
    {
        $query = $this->db->get_where('event', array('eventid' => $eventid));
        return $query->result()[0]->eventtitle;
    }

    /*     * ******************************* */
    /*     * ** Get Event Registration Lists ********** */
    /*     * ******************************* */

    public function getRegisteredList()
    {
        $this->db->order_by("registrationID", "desc");
        $query = $this->db->get('eventregistration');
        return $query->result();
    }
    /*     * ******************************* */
    /*     * ** Get Event Lists ********** */
    /*     * ******************************* */

    public function getEventList()
    {
        $this->db->order_by("eventid", "desc");
        $query = $this->db->get('event');
        return $query->result();
    }
}
