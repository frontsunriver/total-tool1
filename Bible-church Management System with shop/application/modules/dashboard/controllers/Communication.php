<?php

use Mailgun\Mailgun;

defined('BASEPATH') OR exit('No direct script access allowed');

class Communication extends MX_Controller {

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
    /*     * ******* Index Of Event ************ */
    /*     * ************************************* */

    public function index() {
        $data['smss'] = $this->getSMSs();
        $this->load->view('Dashboard/header');
        $this->load->view('Communication/sms', $data);
        $this->load->view('Dashboard/footer');
    }

    public function sms() {
        $data['smss'] = $this->getSMSs();
        $this->load->view('Dashboard/header');
        $this->load->view('Communication/sms', $data);
        $this->load->view('Dashboard/footer');
    }

    public function email() {
        $data['emails'] = $this->getEmails();
        $this->load->view('Dashboard/header');
        $this->load->view('Communication/email', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * *********** Add Event **************** */
    /*     * ************************************* */

    public function sendsms() {

        $numbers = $this->input->post('numbers');
        $textMessage =  $this->input->post('description');
        $numsArray = explode(',', $numbers);
        $i=0;
        $j=0;
        $error = '';
        for($x=0; $x < count($numsArray); $x++){

            if(getBasic()->smsapi == 1){

                //Nexmo API
                $client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic($this->config->item('nexmo_api'), $this->config->item('nexmo_secret')));
                try{

                    $message = $client->message()->send([
                        'to' => $numsArray[$x],
                        'from' => $this->config->item('nexmo_from'),
                        'text' => character_limiter(strip_tags($textMessage), 160)
                    ]);

                    $data = array();
                    $data['time'] = date('d-m-Y H:i:s');
                    $data['to'] = $message['to'];
                    $data['message'] = character_limiter(strip_tags($textMessage), 160);
                    $data['messageid'] = $message['message-id'];
                    $data['remainingbalance'] = $message['remaining-balance'];
                    $data['messageprice'] = $message['message-price'];
                    $data['network'] = $message['network'];
                    $insert = $this->db->insert('sms', $data);
                    if($insert == True){
                        $i++;
                    }

                }catch(\Exception $e){
                    $error =  $e->getMessage();
                    $j++;
                }
                //End of Nexmo

            }else if(getBasic()->smsapi == 2){

                // Your Account SID and Auth Token from twilio.com/console
                $account_sid = $this->config->item('twilio_sid');
                $auth_token = $this->config->item('twilio_token');
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

                // A Twilio number you own with SMS capabilities
                $twilio_number = $this->config->item('twilio_sender');
                $client = new Twilio\Rest\Client($account_sid, $auth_token);

                try{

                    $message = $client->messages->create(
                        $numsArray[$x], //To Number
                        array(
                            'from' => $twilio_number,
                            'body' => character_limiter(strip_tags($textMessage), 160)
                        )
                    );

                    $data = array();
                    $data['time'] = date('d-m-Y H:i:s');
                    $data['to'] = $numsArray[$x];
                    $data['message'] = character_limiter(strip_tags($textMessage), 160);
                    $data['messageid'] = 'N/A';
                    $data['remainingbalance'] = 'N/A';
                    $data['messageprice'] = 'N/A';
                    $data['network'] = 'N/A';
                    $insert = $this->db->insert('sms', $data);
                    if($insert == True){
                        $i++;
                    }

                }catch(\Exception $e){
                    $error = $e->getMessage();
                    $j++;
                }

            }

        }

        $this->session->set_flashdata('success', $i . ' SMSs Successfully Delivered & ' . $j . ' Failed. Error :' . $error);
        redirect('dashboard/communication/sms', 'refresh');

    }



    public function sendemail() {

        $emails = $this->input->post('emails');
        $textMessage =  $this->input->post('description');
        $emailsubject =  $this->input->post('subject');
        $mailArray = explode(',', $emails);
        $i=0;
        $j=0;
        $error = '';
        for($x=0; $x < count($mailArray); $x++){

            $mg = Mailgun::create($this->config->item('mailgun_api'));

            try{


                $mg->messages()->send($this->config->item('mailgun_domain'), [
                  'from'    => $this->config->item('mailgun_from'),
                  'to'      => $mailArray[$x],
                  'subject' => character_limiter(strip_tags($emailsubject), 50),
                  'text'    => strip_tags($textMessage),
                  'html'    => $textMessage
                ]);

                $data = array();
                $data['time'] = date('d-m-Y H:i:s');
                $data['emailTo'] = $mailArray[$x];
                $data['emailSubject'] = character_limiter(strip_tags($emailsubject), 50);
                $data['message'] = character_limiter(strip_tags($textMessage), 300);
                $data['network'] = 'Mailgun';
                $insert = $this->db->insert('email', $data);

                $i++;

            }catch(\Exception $e){
                $j++;
                $error = $e->getMessage();
            }

        }

        $this->session->set_flashdata('success', $i . ' Emails Successfully Delivered & ' . $j . ' Failed. Error :' . $error);
        redirect('dashboard/communication/email', 'refresh');

    }

    /*     * ************************************* */
    /*     * ******* Get Individual Event ******* */
    /*     * ************************************* */

    public function getIndividual() {
        $eventid = $this->uri->segment(4);
        $query = $this->db->get_where('event', array('eventid' => $eventid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get SMS ********************* */
    /*     * ************************************* */

    public function getSMSs() {
        $this->db->order_by("smsID", "desc");
        $query = $this->db->get('sms');
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Delete SMS ******* */
    /*     * ************************************* */

    public function deletesms($smsID) {
        $this->db->where('smsID', $smsID);
        $deleted = $this->db->delete('sms');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/communication/sms', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/communiction/sms', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ******* Get Email ********************* */
    /*     * ************************************* */

    public function getEmails() {
        $this->db->order_by("emailID", "desc");
        $query = $this->db->get('email');
        return $query->result();
    }


    /*     * ************************************* */
    /*     * ******* Delete Emails ******* */
    /*     * ************************************* */

    public function deleteemail($emailID) {
        $this->db->where('emailID', $emailID);
        $deleted = $this->db->delete('email');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/communication/email', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/communiction/email', 'refresh');
        }
    }


    /*     * ************************************* */
    /*     * ******* Get Pagination Events ************ */
    /*     * ************************************* */
    public function getTotal($table) {
        $query = $this->db->get($table);
        return $query->result();
    }

}
