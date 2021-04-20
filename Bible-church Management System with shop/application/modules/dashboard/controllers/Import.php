<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MX_Controller {
    
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
    /*     * *** Import Index Page **** */
    /*     * ************************** */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Import/import');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Import Files **** */
    /*     * ************************** */

    public function import() {

        $importtype = $this->input->post('filetype');
        if (isset($_FILES["file"])) {
            $filePath = realpath(APPPATH . '../assets/assets/files');
            $config['upload_path'] = $filePath;
            $config['allowed_types'] = 'text/plain|text/csv|csv';
            $config['max_size'] = '2048';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            //$config['overwrite'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload("file")) {
                $uploaded_data = $this->upload->data();
                $file_path = $uploaded_data['full_path'];
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    //   Speech Import
                    if ($importtype == "speech") {
                        foreach ($csv_array as $row) {
                            $fname = $row['fname'];
                            $position = $row['position'];
                            if ($fname && $position) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['position'] = $row['position'];
                                $data['speech'] = $row['speech'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('speech', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }

                    //   Event Import
                    if ($importtype == "event") {
                        foreach ($csv_array as $row) {
                            if ($row['title'] && $row['date']) {
                                $data['eventimage'] = $row['image'];
                                $data['eventtitle'] = $row['title'];
                                $data['eventdate'] = $row['date'];
                                $data['eventtime'] = $row['time'];
                                $data['eventlocation'] = $row['location'];
                                $data['eventdescription'] = $row['description'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('event', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Prayer Import
                    if ($importtype == "prayer") {
                        foreach ($csv_array as $row) {
                            if ($row['title']) {
                                $data['prayertitle'] = $row['title'];
                                $data['prayerdescription'] = $row['description'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('prayer', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Notice Import
                    if ($importtype == "notice") {
                        foreach ($csv_array as $row) {
                            if ($row['title']) {
                                $data['noticetitle'] = $row['title'];
                                $data['noticedescription'] = $row['description'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('notice', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Funds Import
                    if ($importtype == "funds") {
                        foreach ($csv_array as $row) {
                            if ($row['amount'] && $row['type']) {
                                $date = $row['date'];
                                $data['fundsdate'] = date("d/m/Y", strtotime($date));
                                $data['fundsmonth'] = date("F", strtotime($date));
                                $data['fundsyear'] = date("Y", strtotime($date));
                                $data['fundsamount'] = $row['amount'];
                                $data['fundstype'] = $row['type'];
                                $data['receivedby'] = $row['verifier'];
                                $data['fundssource'] = $row['source'];
                                $data['fundsnote'] = $row['note'];
                                $data['fundsbalance'] = "";
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('funds', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Donation Import
                    if ($importtype == "donation") {
                        foreach ($csv_array as $row) {
                            if ($row['amount']) {
                                $date = $row['date'];
                                $data['donationdate'] = date("d/m/Y", strtotime($date));
                                $data['donationmonth'] = date("F", strtotime($date));
                                $data['donationyear'] = date("Y", strtotime($date));
                                $data['donationamount'] = $row['amount'];
                                $data['donationsource'] = $row['source'];
                                $data['donationby'] = $row['gateway'];
                                $data['donationinfo'] = $row['gatewayinfo'];
                                $data['donationreceivedby'] = $row['verifier'];
                                $data['donationnote'] = $row['note'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('donation', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Assets Import
                    if ($importtype == "assets") {
                        foreach ($csv_array as $row) {
                            if ($row['amount']) {
                                $date = $row['date'];
                                $data['assetsdate'] = date("d/m/Y", strtotime($date));  
                                $data['assetsmonth'] = date("F", strtotime($date));
                                $data['assetsyear'] = date("Y", strtotime($date));
                                $data['assetsitem'] = $row['item'];
                                $data['assetsamount'] = $row['amount'];
                                $data['assetsverifiedby'] = $row['verifier'];
                                $data['assetsnote'] = $row['note'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('assets', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Users Import
                    if ($importtype == "users") {
                        foreach ($csv_array as $row) {
                            if ($row['username'] && $row['fname'] && $row['position']) {                                
                                $data['userstatus'] = "";
                                $data['username'] = $row['username'];
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['password'] = md5($row['password']);
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['about'] = $row['about'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('users', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Committee Import
                    if ($importtype == "committee") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['speech'] = $row['speech'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('committee', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Members Import
                    if ($importtype == "members") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('member', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Pastor Import
                    if ($importtype == "pastors") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['speech'] = $row['speech'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('pastor', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    //   Pastor Import
                    if ($importtype == "clans") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['gender'] = $row['gender'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('clan', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Chorus Import
                    if ($importtype == "chorus") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['gender'] = $row['gender'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('chorus', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Staff Import
                    if ($importtype == "staff") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['gender'] = $row['gender'];
                                $data['dob'] = $row['birthdate'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('staff', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    //   Sunday School Import
                    if ($importtype == "sschool") {
                        foreach ($csv_array as $row) {
                            if ($row['fname'] && $row['position']) {
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['position'] = $row['position'];
                                $data['bpdate'] = $row['bpdate'];
                                $data['blood'] = $row['blood'];
                                $data['gender'] = $row['gender'];
                                $data['dob'] = $row['birthdate'];
                                $data['guardian'] = $row['guardian'];
                                $data['age'] = $row['age'];
                                $data['sclass'] = $row['class'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('sundayschool', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    // Seminar Import
                    if ($importtype == "seminar") {
                        foreach ($csv_array as $row) {
                            if ($row['title']) {
                                $data['seminarbanner'] = $row['banner'];
                                $data['seminartitle'] = $row['title'];
                                $data['seminarslogan'] = $row['slogan'];
                                $data['seminardescription'] = $row['description'];
                                $data['seminarstart'] = $row['start'];
                                $data['seminarend'] = $row['end'];
                                $data['seminarlocation'] = $row['location'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('seminar', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                    // Seminar Applicants Import
                    if ($importtype == "seminarapplicants") {
                        foreach ($csv_array as $row) {
                            if ($row['seminarid'] && $row['fname']) {                                
                                $data['selectedseminarid'] = $row['seminarid'];
                                $data['profileimage'] = $row['photo'];
                                $data['fname'] = $row['fname'];
                                $data['lname'] = $row['lname'];
                                $data['phone'] = $row['phone'];
                                $data['email'] = $row['email'];
                                $data['gender'] = $row['gender'];
                                $data['guardian'] = $row['guardian'];
                                $data['guardiancontact'] = $row['guardiancontact'];
                                $data['age'] = $row['age'];
                                $data['education'] = $row['education'];
                                $data['church'] = $row['church'];
                                $data['churchpastor'] = $row['churchpastor'];
                                $data['paymentgateway'] = $row['paymentgateway'];
                                $data['paymentgatewayinfo'] = $row['paymentgatewayinfo'];
                                $data['paymentsenderinfo'] = $row['paymentsenderinfo'];
                                $data['nationality'] = $row['nationality'];
                                $data['address'] = $row['address'];
                                $data['city'] = $row['city'];
                                $data['country'] = $row['country'];
                                $data['postal'] = $row['postal'];
                                $data['cdate'] = date("j F Y");
                                $inserted = $this->db->insert('seminarregistration', $data);
                            }
                        }

                        if ($inserted) {
                            $this->session->set_flashdata("success", "Successfully Imported");
                            redirect('dashboard/import/');
                        }
                    }
                    
                    
                } else {
                    $this->session->set_flashdata("notsuccess", "Something Wrong!");
                    redirect('dashboard/import/');
                }
            } else {
                $this->session->set_flashdata("notsuccess", "File Not Uploaded! Max Limit 2 MB");
                redirect('dashboard/import/');
            }
        } else {
            $this->session->set_flashdata("notsuccess", "Select Valid File!");
            redirect('dashboard/import/');
        }
    }

    /*     * ************************** */
    /*     * *** Getting Import Basic Info **** */
    /*     * ************************** */

    public function getBasicInfo() {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Import Save Basic Info **** */
    /*     * ************************** */

    public function updatebasic() {

        $errors = array();
        $success = array();
        $data = array();

        $title = $this->input->post('title');
        $tag = $this->input->post('tag');
        $map = $this->input->post('map');
        $email = $this->input->post('email');
        $color = $this->input->post('color');
        $currency = $this->input->post('currency');
        $churchtime = $this->input->post('churchtime');
        $about = $this->input->post('about');
        $contact = $this->input->post('contact');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $country = $this->input->post('country');
        $postal = $this->input->post('postal');
        $copyright = $this->input->post('copyright');

        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($tag)) {
            $data['tag'] = $tag;
        }
        if (!empty($map)) {
            $data['map'] = $map;
        }
        if (!empty($map)) {
            $data['color'] = $color;
        }
        if (!empty($map)) {
            $data['email'] = $email;
        }
        if (!empty($currency)) {
            $data['currency'] = $currency;
        }
        if (!empty($churchtime)) {
            $data['churchtime'] = $churchtime;
        }
        if (!empty($about)) {
            $data['about'] = $about;
        }
        if (!empty($contact)) {
            $data['contact'] = $contact;
        }
        if (!empty($address)) {
            $data['address'] = $address;
        }
        if (!empty($city)) {
            $data['city'] = $city;
        }
        if (!empty($country)) {
            $data['country'] = $country;
        }
        if (!empty($postal)) {
            $data['postal'] = $postal;
        }
        if (!empty($copyright)) {
            $data['copyright'] = $copyright;
        }

        $imagePath = realpath(APPPATH . '../assets/assets/images/website');
        $favicon = $_FILES['favicon']['tmp_name'];
        $logo = $_FILES['logo']['tmp_name'];

        if ($favicon !== "") {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '200';
            $config['max_width'] = '500';
            $config['max_height'] = '500';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('favicon')) {
                $uploaded_data = $this->upload->data();
                $data['favicon'] = $uploaded_data['file_name'];
            } else {
                $data['favicon'] = '';
                $errors['favicon_error'] = strip_tags($this->upload->display_errors());
                echo json_encode($errors);
            }
        }

        if ($logo !== "") {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '5000';
            $config['max_width'] = '500';
            $config['max_height'] = '500';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logo')) {
                $uploaded_data = $this->upload->data();
                $data['logo'] = $uploaded_data['file_name'];
            } else {
                $data['logo'] = '';
                $errors['logo_error'] = strip_tags($this->upload->display_errors());
                echo json_encode($errors);
            }
        }

        $this->db->where('basicid', 1);
        $updated = $this->db->update('websitebasic', $data);
        if ($updated == TRUE) {
            $succcess['success'] = "Successfully Updated";
            echo json_encode($succcess);
        } else {
            $errors['notsuccess'] = 'Opps! Something Wrong';
            echo json_encode($errors);
        }
    }

    /*     * ************************** */
    /*     * *** Import Upload Gallery **** */
    /*     * ************************** */

    public function uploadgallery() {

        $this->load->library('upload');
        $data = array();
        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);

        for ($i = 0; $i < $count; $i++) {

            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $imagePath = realpath(APPPATH . '../assets/assets/images/website/gallery');
            $config['upload_path'] = $imagePath . "/large";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->upload->initialize($config);

            if ($this->upload->do_upload()) {
                $fileData = $this->upload->data();
                $data['filename'] = $fileData['file_name'];
                $data['cdate'] = date("j F Y");
                $this->db->insert('gallery', $data);

                $config['source_image'] = $fileData['full_path'];
                $config['new_image'] = $imagePath . '/small';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                redirect('dashboard/website/gallery', 'refresh');
            } else {
                echo strip_tags($this->upload->display_errors());
            }
        }
    }

    /*     * ************************** */
    /*     * *** Import get Slider **** */
    /*     * ************************** */

    public function getSlider() {
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('slider');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Import get Slider **** */
    /*     * ************************** */

    public function getGallery() {
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('gallery');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Import Slider Delete **** */
    /*     * ************************** */

    public function sliderdelete($sliderid) {
        $this->db->where('sliderid', $sliderid);
        $this->db->delete('slider');
        redirect('dashboard/website/slider', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function slidersort() {
        $sorted = $this->input->post('sort');
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $sliderid = $data[0][$x]["id"];
            $arrdata = array();
            $arrdata['serialid'] = $x;
            $this->db->where('sliderid', $sliderid);
            $this->db->update('slider', $arrdata);
        }
    }

    /*     * ************************** */
    /*     * *** Import Gallery Delete **** */
    /*     * ************************** */

    public function gallerydelete($galleryid) {
        $this->db->where('galleryid', $galleryid);
        $this->db->delete('gallery');
        redirect('dashboard/website/gallery', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function sortgallery() {
        $sorted = $this->input->post('sort');
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $galleryid = $data[0][$x]["id"];
            $arrdata = array();
            $arrdata['serialid'] = $x;
            $this->db->where('galleryid', $galleryid);
            $this->db->update('gallery', $arrdata);
        }
    }

    /*     * ************************** */
    /*     * *** Import Upload Slider **** */
    /*     * ************************** */

    public function uploadslider() {

        $this->load->library('upload');
        $data = array();
        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);

        for ($i = 0; $i < $count; $i++) {

            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $imagePath = realpath(APPPATH . '../assets/assets/images/website/slider');
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->upload->initialize($config);

            if ($this->upload->do_upload()) {
                $fileData = $this->upload->data();

                $config['source_image'] = $fileData['full_path'];
                $config['new_image'] = $imagePath . '/resize';
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data['filename'] = $fileData['file_name'];
                $data['cdate'] = date("j F Y");
                $this->db->insert('slider', $data);
                redirect('dashboard/website/slider', 'refresh');
            } else {
                echo strip_tags($this->upload->display_errors());
            }
        }
    }

}
