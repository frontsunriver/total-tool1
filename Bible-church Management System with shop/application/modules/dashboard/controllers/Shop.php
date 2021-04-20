<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends MX_Controller
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

    function __construct()
    {
        parent::__construct();

        isLoginRedirect();
        isKenaRedirect();

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    /*     * ************************** */
    /*     * *** Index Page Of Shop **** */
    /*     * ************************** */

    public function index()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Shop/addproduct');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Add From Page Of Shop **** */
    /*     * ************************** */

    public function addproduct()
    {
        $this->load->view('Dashboard/header');
        $this->load->view('Shop/addproduct');
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Adding New Shop **** */
    /*     * ************************** */

    public function addnewproduct()
    {

        $userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
            $this->session->set_flashdata('notsuccess', 'You are not eligible');
			redirect('dashboard', 'refresh');
        }
        
        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('title', 'Product Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Product Price', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['title'] = $this->input->post('title');
            $data['price'] = $this->input->post('price');
            $data['category'] = $this->input->post('category');
            $data['tag'] = $this->input->post('tag');
            $data['sale'] = $this->input->post('sale');
            $data['description'] = $this->input->post('description');
            $data['cdate'] = date("j F Y");

            /* Uploading Profile Images */
            $imagePath = realpath(APPPATH . '../assets/assets/images/product');
            $productimage = $_FILES['productimage']['tmp_name'];
            //If Profile Image $profileimage Has Anything Then Continue
            if ($productimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('productimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['image'] = $uploaded_data['file_name'];
                } else {
                    $data['image'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }

                if (round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['quality'] = '100%';
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = round($this->input->post('width'));
                    $config['height'] = round($this->input->post('height'));
                    $config['x_axis'] = $this->input->post('x');
                    $config['y_axis'] = $this->input->post('y');

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                    /* Resizing Uploaded Images */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/photo';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 650;
                    $config['height'] = 650;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                } else {
                    /** ****** Resizing Sermon Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/photo';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 650;
                    $config['height'] = 650;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }


                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                unlink($uploaded_data['full_path']);
            }

            $inserted = $this->db->insert('product', $data);
            if ($inserted == TRUE) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * *** Displaying All Shop **** */
    /*     * ************************** */

    public function allproducts()
    {       
		$userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
            $this->session->set_flashdata('notsuccess', 'You are not eligible');
			redirect('dashboard', 'refresh');
		}
        
        $data['products'] = $this->getTotal('product');
        $this->load->view('Dashboard/header');
        $this->load->view('Shop/allproducts', $data);
        $this->load->view('Dashboard/footer');
    }


    /*     * ************************** */
    /*     * *** Displaying All Shop **** */
    /*     * ************************** */

    public function allorders()
    {

        $userID = $this->session->user_id;
		$userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
			$data['orders'] = $this->db->get_where('orders', array('orderUserID' => $userID))->result();
		} else {
            $data['orders'] = $this->getOrders();
        } 
        $this->load->view('Dashboard/header');
        $this->load->view('Shop/allorders', $data);
        $this->load->view('Dashboard/footer');
    }


    /*     * ************************** */
    /*     * *** Editing Individual Shop **** */
    /*     * ************************** */

    public function edit()
    {
        $data['individual_product'] = $this->getIndividual();
        $this->load->view('Dashboard/header');
        $this->load->view('Shop/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Updating Individual Shop **** */
    /*     * ************************** */

    public function update()
    {

        $errors = array();
        $success = array();
        $data = array();

        $productID = $this->input->post('productID');

        $this->form_validation->set_rules('title', 'Product Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Product Price', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $data['title'] = $this->input->post('title');
            $data['price'] = $this->input->post('price');
            $data['category'] = $this->input->post('category');
            $data['tag'] = $this->input->post('tag');
            $data['sale'] = $this->input->post('sale');
            $data['description'] = $this->input->post('description');
            $data['cdate'] = date("j F Y");

            /* Uploading Profile Images */
            $imagePath = realpath(APPPATH . '../assets/assets/images/product');
            $productimage = $_FILES['productimage']['tmp_name'];
            //If Profile Image $profileimage Has Anything Then Continue
            if ($productimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('productimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['image'] = $uploaded_data['file_name'];
                } else {
                    $data['image'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }

                if (round($this->input->post('width')) > 0 && round($this->input->post('height')) > 0) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/crop';
                    $config['quality'] = '100%';
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = round($this->input->post('width'));
                    $config['height'] = round($this->input->post('height'));
                    $config['x_axis'] = $this->input->post('x');
                    $config['y_axis'] = $this->input->post('y');

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                    /* Resizing Uploaded Images */
                    $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                    $config['new_image'] = $imagePath . '/photo';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 650;
                    $config['height'] = 650;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                } else {
                    /** ****** Resizing Shop Banner ****** */
                    /** ************************************** */
                    $config['source_image'] = $uploaded_data['full_path'];
                    $config['new_image'] = $imagePath . '/photo';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 650;
                    $config['height'] = 650;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }


                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                unlink($uploaded_data['full_path']);
            }

            $this->db->where('productID', $productID);
            $inserted = $this->db->update('product', $data);
            if ($inserted == TRUE) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************** */
    /*     * *** Deleting Individual Shop **** */
    /*     * ************************** */

    public function delete($productID)
    {
        $this->db->where('productID', $productID);
        $this->db->delete('product');
        redirect('dashboard/shop/allproducts', 'refresh');
    }


    /*     * ************************** */
    /*     * *** Getting Shop By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start)
    {
        $this->db->order_by("productID", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('product');
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
    /*     * ********** Get Total ********** */
    /*     * ************************************* */

    public function getOrders()
    {
        $this->db->order_by('orderID', 'DESC');
        //$this->db->join('product', 'product.productID = cart.cartProductID', 'left');
        $query = $this->db->get('orders');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Getting Individual Shop **** */
    /*     * ************************** */

    public function getIndividual()
    {
        $productid = $this->uri->segment(4);
        $query = $this->db->get_where('product', array('productID' => $productid));
        return $query->result();
    }


    /*     * ************************** */
    /*     * *** Mark As Delivered **** */
    /*     * ************************** */

    public function delivered($orderID)
    {

        $userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
            $this->session->set_flashdata('notsuccess', 'You are not eligible');
			redirect('dashboard', 'refresh');
        }
        
        $data['orderDeliver'] = "Delivered";
        $this->db->where('orderID', $orderID);
        $updated = $this->db->update('orders', $data);
        if ($updated == TRUE) {
            $this->session->set_flashdata('success', 'Successfully, Mark as Delivered');
            redirect('dashboard/shop/allorders/', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/shop/allorders/', 'refresh');
        }
    }


    /*     * ************************** */
    /*     * *** Deleting Individual Order **** */
    /*     * ************************** */

    public function deleteorder($orderID)
    {

        $userPosition = $this->session->user_position;
		if ($userPosition == 'Contributor' || $userPosition == 'Subscriber') {
            $this->session->set_flashdata('notsuccess', 'You are not eligible');
			redirect('dashboard', 'refresh');
        }
        
        $this->db->where('orderID', $orderID);
        $this->db->delete('orders');
        redirect('dashboard/shop/allorders', 'refresh');
    }
}
