<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MX_Controller {
    
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

    /*     * ************************************* */
    /*     * ******* Index Of Blog ************ */
    /*     * ************************************* */

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Blog/addpost');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Add Blog **************** */
    /*     * ************************************* */

    public function addpost() {
        $this->load->view('Dashboard/header');
        $this->load->view('Blog/addpost');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Add New Blogs ************ */
    /*     * ************************************* */

    public function addnewblog() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('blogtitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('blogdescription', 'Blog Content', 'required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['title'] = $this->input->post('blogtitle');
            $data['content'] = $this->input->post('blogdescription');
            $data['cdate'] = date("j F Y");
            $data['author'] = $this->session->userdata('user_id');

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/blog');
            $blogimage = $_FILES['blogimage']['tmp_name'];
            if ($blogimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('blogimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['image'] = $uploaded_data['file_name'];
                } else {
                    $data['image'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
                }
                
            }

            $inserted = $this->db->insert('blog', $data);
            if ($inserted == TRUE) {
                $succcess['success'] = "Successfully Posted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* View All Blogs ************ */
    /*     * ************************************* */

    public function allposts() { 
        
        $userID = $this->session->user_id;
		$userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
			$data['blog'] = $this->db->get_where('blog', array('author' => $userID))->result();
		} else {
            $data['blog'] = $this->getTotal('blog');
        }      
        $this->load->view('Dashboard/header');
        $this->load->view('Blog/allposts', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************* View Blog ************* */
    /*     * ************************************* */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Blog/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ************ Edit Blog ************ */
    /*     * ************************************* */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Blog/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Update Blogs ************ */
    /*     * ************************************* */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();
        
        $postID = $this->input->post('postID');
        
        $this->form_validation->set_rules('blogtitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('blogdescription', 'Blog Content', 'required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['title'] = $this->input->post('blogtitle');
            $data['content'] = $this->input->post('blogdescription');
            $data['cdate'] = date("j F Y");
            $data['author'] = $this->session->userdata('user_id');

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../assets/assets/images/blog');
            $blogimage = $_FILES['blogimage']['tmp_name'];
            if ($blogimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('blogimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['image'] = $uploaded_data['file_name'];
                } else {
                    $data['image'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($success);
                }
                
            }

            $this->db->where('postID', $postID);
            $updated = $this->db->update('blog', $data);
            if ($updated == TRUE) {
                $succcess['success'] = "Successfully Updated";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* Delete Individual Blog ******* */
    /*     * ************************************* */

    public function delete($postID) {
        $this->db->where('postID', $postID);
        $deleted = $this->db->delete('blog');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/blog/allposts', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/blog/allposts', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ******* Get Individual Blog ******* */
    /*     * ************************************* */

    public function getIndividual() {
        $postID = $this->uri->segment(4);
        $query = $this->db->get_where('blog', array('postID' => $postID));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Pagination Blogs ************ */
    /*     * ************************************* */

    public function getPagiData($limit, $start) {
        $this->db->order_by("blogid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('blog');
        return $query->result();
    }
    
    
    /*     * ************************************* */
    /*     * ******* Get Pagination Blogs ************ */
    /*     * ************************************* */
    public function getTotal($table) {        
        $query = $this->db->get($table);
        return $query->result();
    }

}
