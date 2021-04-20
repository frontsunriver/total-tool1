<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Speech extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        isLoginRedirect();
        isKenaRedirect();

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    /*     * ************************** */
    /*     * *** Index Page Of Speech **** */
    /*     * ************************** */

    public function index()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Speech/addspeech');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Add Speech ******* */
    /*     * ************************** */

    public function addspeech()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Speech/addspeech');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Adding New Speech ******* */
    /*     * ************************** */

    public function addnewspeech()
    {
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        $this->form_validation->set_rules('speech', 'Speech', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['position'] = $this->input->post('position');
            $data['speech'] = $this->input->post('speech');
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['youtube'] = $this->input->post('youtube');
            $data['googleplus'] = $this->input->post('googleplus');
            $data['linkedin'] = $this->input->post('linkedin');
            $data['pinterest'] = $this->input->post('pinterest');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['instagram'] = $this->input->post('instagram');
            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/speech');
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
                    echo json_encode($errors);
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

                    /**** Resizing Upload Image ****/
                    /** ****************************** */
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

                    /** ****** Resizing Speech Banner ****** */
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

            $inserted = $this->db->insert('speech', $data);
            if ($inserted == true) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * ******* All Speechs ******* */
    /*     * ************************** */

    public function allSpeech()
    {
        $baselink = "speech/allSpeech";
        $database = "speech";
        $perpage = 9;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['speech'] = $this->get_pagi_data($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('Dashboard/header');
        $this->load->view('Speech/allspeech', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* View Individual Speech ******* */
    /*     * ************************** */

    public function view()
    {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Speech/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Edit Speech Profile **** */
    /*     * ************************** */

    public function edit()
    {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Speech/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Update Speech Profile **** */
    /*     * ************************** */

    public function update()
    {
        $errors = array();
        $success = array();
        $data = array();

        $speechid = $this->input->post('speechid');

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        $this->form_validation->set_rules('speech', 'Speech', 'trim|required');
        if ($this->form_validation->run() == false) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['position'] = $this->input->post('position');
            $data['speech'] = $this->input->post('speech');
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['youtube'] = $this->input->post('youtube');
            $data['googleplus'] = $this->input->post('googleplus');
            $data['linkedin'] = $this->input->post('linkedin');
            $data['pinterest'] = $this->input->post('pinterest');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['instagram'] = $this->input->post('instagram');
            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/speech');
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
                    echo json_encode($errors);
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

                    //**** Resizing Upload Image ****/
                    /*                 * ****************************** */
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
                    /** ****** Resizing Speech Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/profile';
                    $config['maintain_ratio'] = true;
                    $config['width'] = 250;
                    $config['height'] =250;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($uploaded_data['full_path']);
            }

            $this->db->where('speechid', $speechid);
            $updated = $this->db->update('speech', $data);
            if ($updated == true) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * *** Delete Speech Profile **** */
    /*     * ************************** */

    public function delete($speechid)
    {
        $this->db->where('speechid', $speechid);
        $this->db->delete('speech');
        redirect('dashboard/speech/allspeech', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting Speech By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start)
    {
        $this->db->order_by("speechid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('speech');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Get Individual Speech Profile **** */
    /*     * ************************** */

    public function getIndividual()
    {
        $Speechid = $this->uri->segment(4);
        $query = $this->db->get_where('speech', array('speechid' => $Speechid));
        return $query->result();
    }
}
