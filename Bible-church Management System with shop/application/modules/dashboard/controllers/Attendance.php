<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MX_Controller {
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

    /*     * ******************************* */
    /*     * *** Attendance > Fund Index **** */
    /*     * ******************************* */

    public function index() {
        $data['attendancetypes'] = $this->getAttendanceType();
        $this->load->view('Dashboard/header');
        $this->load->view('Attendance/attendance', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ******************************* */
    /*     * *** Attendance > Attendance Type **** */
    /*     * ******************************* */

    public function addtype() {
        $data['attendancetypes'] = $this->getAttendanceType();
        $this->load->view('Dashboard/header');
        $this->load->view('Attendance/attendancetype', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Adding Attenance Type ******* */
    /*     * ************************************* */

    public function addnewattendancetype() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('attendancetype', 'Attendance Type', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['attendancetype'] = $this->input->post('attendancetype');
            $inserted = $this->db->insert('attendancetype', $data);
            if ($inserted == TRUE) {
                $succcess['success'] = "Successfully Inserted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
            
        }
    }

    /*     * ************************************************** */
    /*     * ************* Fund Browsing ********************* */
    /*     * ************************************************** */

    public function browse() {

        $attendancedate = $this->input->post('attendancedate');
        $grouptype = $this->input->post('grouptype');
        $attendancetype = $this->input->post('attendancetype');

        $query = $this->db->get($grouptype);
        $groupQuery = $query->result();

        $data['grouptype'] = $grouptype;
        $data['attendancetype'] = $attendancetype;
        $data['attendancedate'] = $attendancedate;
        $data['attendance_browse'] = $groupQuery;
        $data['attendancetypes'] = $this->getAttendanceType();

        $this->load->view('Dashboard/header');
        $this->load->view('Attendance/attendancebrowse', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ********************************************* */
    /*     * *** Attendance > Update Individual Record **** */
    /*     * ********************************************* */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $userid = $this->input->post('userID');
        $time = $this->input->post('time');
        $type = $this->input->post('type'); // weekly prayer
        $group = $this->input->post('group'); // Group member, pastor etc
        //$currentStatus = $this->input->post('currentStatus');

        $queryAtten = $this->db->get_where('attendance', array('grouptype' => $group, 'type' => $type, 'time' => $time, 'userid' => $userid));
        if ($queryAtten->num_rows() < 1) {

            $newTime = str_replace('/', '.', $time);

            $data['userid'] = $userid;
            $data['time'] = $time;
            $data['type'] = $type;
            $data['grouptype'] = $group;
            $data['status'] = "Present";

            $data['month'] = date('m', strtotime($newTime));
            $data['year'] = date('Y', strtotime($newTime));

            $inserted = $this->db->insert('attendance', $data);
            if ($inserted == TRUE) {
                $success['success'] = "Successful";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        } else {

            $data['userid'] = $userid;
            $data['time'] = $time;
            $data['type'] = $type;
            $data['grouptype'] = $group;
            if ($queryAtten->result()[0]->status == "Present") {
                $data['status'] = "Absent";
            } else {
                $data['status'] = "Present";
            }


            $this->db->where('userid', $userid);
            $this->db->where('grouptype', $group);
            $this->db->where('type', $type);
            $this->db->where('time', $time);
            $updated = $this->db->update('attendance', $data);

            if ($updated == TRUE) {
                $success['success'] = "Successful";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    public function getEvents() {

        $start = $this->input->get("start");
        $end = $this->input->get("end");

        $userID = $this->input->get("userID");
        $group = $this->input->get("group");

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp
        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');

        $calMonth = date('m', strtotime($start));
        $calYear = date('Y', strtotime($start));

        $queryEvents = $this->db->get_where('attendance', array('userid' => $userID, 'grouptype' => $group, 'month' => $calMonth, 'year' => $calYear));


        $data_events = array();
        $i = 0;
        foreach ($queryEvents->result() as $r) {
            $i++;
            $data_events[] = array(
                "id" => $i,
                "title" => $r->status,
                "description" => $r->status,
                "start" => "2017-11-27",
                "start" => "2017-12-27"
            );
        }

        echo json_encode(array("events" => $data_events));
    }
    
    
    public function getAttendanceType() {        
        $query = $this->db->get('attendancetype');
        return $query->result();  
    }
    
    
    /*     * ************************** */
    /*     * *** Delete Attendance Type **** */
    /*     * ************************** */

    public function delete($attendancetypeid) {
        $this->db->where('attendancetypeid', $attendancetypeid);
        $this->db->delete('attendancetype');
        redirect('dashboard/attendance/addtype', 'refresh');
    }

}
