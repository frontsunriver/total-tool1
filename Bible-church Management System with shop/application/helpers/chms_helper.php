<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

if (!function_exists('getBasic')) {

    /*     * ************************** */
    /*     * **** Get Basic ***** */
    /*     * ************************** */

    function getBasic() {
        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library
        $query = $ci->db->get('websitebasic');
        if ($query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            //Default Currency USD Because No Row Founds In Table
            return false;
        }
    }

}


if (!function_exists('globalCurrency')) {

    /*     * ************************** */
    /*     * **** Global Currency ***** */
    /*     * ************************** */

    function globalCurrency() {
        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library
        $query = $ci->db->get('websitebasic');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach ($result as $row) {
                $currency = $row->currency . " ";
            }
            return $currency;
        } else {
            //Default Currency USD Because No Row Founds In Table
            return false;
        }
    }

}


if (!function_exists('getUserByID')) {

    /*     * ************************** */
    /*     * **** Global Currency ***** */
    /*     * ************************** */

    function getUserByID($userid) {
        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library
        $query = $ci->db->get_where('users', array('userid' => $userid));
        if ($query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            //Default Currency USD Because No Row Founds In Table
            return false;
        }
    }

}


if (!function_exists('getCreateDate')) {

    /*     * ************************** */
    /*     * **** Get Table Create Date ***** */
    /*     * ************************** */

    function getCreateDate($orderby, $table) {
        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library
        $ci->db->order_by($orderby, "desc");
        $ci->db->limit(1);
        $query = $ci->db->get($table);

//                $result = $query;
//                return $result;

        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach ($result as $row) {
                $cdate = $row->cdate;
            }
            return $cdate;
        } else {
            //Default Currency USD Because No Row Founds In Table
            return false;
        }
    }

}


if (!function_exists('getProductByCartID')) {

    function getProductByCartID($cartID) {

        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library

        $cartQuery = $ci->db->get_where('cart', array('cartID' => $cartID));
        if ($cartQuery->num_rows() > 0) {
            $productID = $cartQuery->result()[0]->cartProductID;
            $ci->db->join('cart', 'cart.cartProductID = product.productID', 'left');
            $productQuery = $ci->db->get_where('product', array('productID' => $productID));
            if ($productQuery->num_rows() > 0) {
                return $productQuery->result()[0];
            }
        } else {
            return false;
        }
    }
}



if (!function_exists('validPurchase')) {

    /*     * ************************** */
    /*     * **** Item Purchase Validation ***** */
    /*     * ************************** */

    function validPurchase($purchase_key) {
        $username = 'princejohn25';
        $api_key = '9qzsnpfp5lqjy8k5qx84nheghq2pz24j';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://marketplace.envato.com/api/edge/" . $username . "/" . $api_key . "/verify-purchase:" . $purchase_key . ".json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        $purchase_data = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $purchase_data;
    }

}


if (!function_exists('shortCode')) {

    /*     * ************************** */
    /*     * **** ShortCode Pastor ***** */
    /*     * ************************** */

    function shortCode($type, $table, $sort, $sortby, $quantity) {
        $table = str_replace(' ', '', $table);

        $ci = & get_instance(); //get main CodeIgniter object
        $ci->load->database(); //load databse library

        if ($sort && $sortby) {
            $ci->db->order_by($sortby, $sort);
        }
        if ($quantity) {
            $ci->db->limit($quantity);
        }

        $query = $ci->db->get($table);

        if ($query->num_rows() > 0) {
            $result = $query->result();

            $resultHtml = "";

            if ($type == "speech") {
                $resultHtml = "<div class='owl-carousel'>";
            } else if ($type == "event" && $table == "seminar") {
                $resultHtml = "<div class='row'>";
            } else if ($type == "event" && $table == "blog") {
                $resultHtml = "<div class='row'>";
            } else if ($type == "event" && $table == "sermon") {
                $resultHtml = "<div class='row'>";
            } else if ($type == "shop" && $table == "product") {
                $resultHtml = "<div class='row'>";
            }

            $i = 0;
            foreach ($result as $row) {
                $i++;

                if ($table == "pastor") {
                    $peopleid = $row->pastorid;
                } elseif ($table == "committee") {
                    $peopleid = $row->committeeid;
                } elseif ($table == "member") {
                    $peopleid = $row->memberid;
                } elseif ($table == "chorus") {
                    $peopleid = $row->chorusid;
                } elseif ($table == "clan") {
                    $peopleid = $row->clanid;
                } elseif ($table == "student") {
                    $peopleid = $row->studentid;
                } elseif ($table == "staff") {
                    $peopleid = $row->staffid;
                } elseif ($table == "sundayschool") {
                    $peopleid = $row->sschoolid;
                } elseif ($table == "speech") {
                    $peopleid = $row->speechid;
                } else {
                    $peopleid = "";
                }

                if ($type == "group") {
                    $resultHtml .= "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-12'>
                                <div class='pastors'>
                                    <img src='" . base_url() . "assets/assets/images/$table/profile/$row->profileimage' alt='$row->fname'></img>
                                    <h5>$row->position</h5>
                                    <h4><a target='_blank' href='" . base_url() . "home/$table/view/$peopleid'>$row->fname $row->lname</a></h4>
                                </div>
                            </div>";
                } else if ($type == "speech") {
                    $resultHtml .= "<div class='col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                    <div class='pastors'>
                                            <img src='" . base_url() . "assets/assets/images/" . $table . "/profile/$row->profileimage' alt='$row->fname'></img>
                                            <h4>$row->fname $row->lname</h4>
                                            <h5>$row->position</h5>
                                            <p>" . word_limiter(strip_tags($row->speech), 100) . "</p><a class='read_more' href='" . base_url() . "home/speech/view/" . $row->speechid . "' data-toggle='modal' data-target='" . base_url() . "home/speech/view/" . $row->speechid . "'>Read More...</a>
                                    </div>
                            </div>";
                } else if ($type == "event" && $table == "seminar") {

                    if ($i % 4 == 0 && $i != 0) {
                        $resultHtml .= '</div><div class="row">';
                    }
                    $resultHtml .= "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
                                <div class='seminar blog'>
                                    <img src=' " . base_url() . "assets/assets/images/$table/banner/$row->seminarbanner' alt='$table'></img>
                                    <h4><a target='_blank' href=' " . base_url() . "home/$table/view/$row->seminarid'>$row->seminartitle</a></h4>
                                    <span class='elements'>Start - " . $row->seminarstart . " | End - " . $row->seminarend . " | Location - " . $row->seminarlocation  . "</span>
                                    <span class='elements description'>" . character_limiter(strip_tags($row->seminardescription), 150) . "</span>
                                </div>
                            </div>";

                } else if ($type == "event" && $table == "sermon") {


                    if ($i % 4 == 0 && $i != 0) {
                        $resultHtml .= '</div><div class="row">';
                    }

                    $resultHtml .= "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
                        <div class='seminar blog'>";

                            if($row->sermonbanner){
                                $resultHtml .= "<img src='" . base_url() . "assets/assets/images/sermon/feature/" . $row->sermonbanner .  "' alt='" . $row->sermontitle . "'>";
                            }else{
                                $resultHtml .= "<img src='" . base_url() . "assets/assets/images/no-preview.png' alt='" . $row->sermontitle . "'>";
                            }

                            $resultHtml .="<h4><a target='_blank' href=' " . base_url() . "home/sermon/view/" . $row->sermonid . " '> " . $row->sermontitle . "</a></h4>";
                            $resultHtml .="<span class='elements'>Published - " . $row->sermondate . " | Author - " . $row->sermonauthor  . "</span>";
                            $resultHtml .="<span class='elements description'>" . character_limiter(strip_tags($row->sermondescription), 150) . "</span>

                        </div>
                    </div>";


                } else if ($type == "event" && $table == "blog") {

                    if ($i % 4 == 0 && $i != 0) {
                        $resultHtml .= '</div><div class="row">';
                    }

                    $resultHtml .= "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
                        <div class='seminar blog'>";
                            if($row->image){
                                $resultHtml .= "<img src='" . base_url() . "assets/assets/images/blog/" . $row->image .  "' alt='" . $row->title . "'>";
                            }else{
                                $resultHtml .= "<img src='" . base_url() . "assets/assets/images/no-preview.png" . $row->image .  "' alt='" . $row->title . "'>";
                            }
                            $resultHtml .="<h4><a target='_blank' href=' " . base_url() . "home/blog/view/$row->postID'>$row->title</a></h4>";
                            if(getUserByID($row->author)){
                                $resultHtml .="<span class='elements'>Published - " . $row->cdate . " | Author - " . getUserByID($row->author)->username  . "</span>";
                            }else{
                                $resultHtml .="<span class='elements'>Published - " . $row->cdate . "</span>";
                            }

                            $resultHtml .="<span class='elements description'>" . character_limiter(strip_tags($row->content), 150) . "</span>
                        </div>
                    </div>";
                } else if ($type == "shop" && $table == "product") {

                    if ($i % 4 == 0 && $i != 0) {
                        $resultHtml .= '</div><div class="row">';
                    }

                    $resultHtml .= "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
                        <div class='seminar product'>
                    <span class='price'>" . getBasic()->currency . " " . number_format($row->price, 0) . "</span>";

                    if($row->sale){
                        $resultHtml .= "<span class='sale'>Sale</span>";
                    }

                   if($row->image){
                        $resultHtml .= "<img src='" . base_url() . "assets/assets/images/product/photo/" . $row->image . "' alt='" . $row->title . "'></img>";
                    }else{
                        $resultHtml .= "<img src='" . base_url() . "assets/assets/images/no-preview.png' alt='" . $row->title . "'></img>";
                    }

                    $resultHtml .= "<h4><a   href='" . base_url() . "home/shop/view/" . $row->productID . "'>" . $row->title . "</a></h4>
                    <h5><span>" . $row->category . "</span></h5>
                </div>
                    </div>";
                }
            }

            if ($type == "event" && $table == "seminar") {
                $resultHtml .= '</div>';
            } else if ($type == "speech") {
                $resultHtml .= "</div>";
            }

            return $resultHtml;
        } else {
            //Default Currency USD Because No Row Founds In Table
            return false;
        }
    }

}


if (!function_exists('getEventByID')){

	/*****************************/
	/****** Global Pagination Initialization ******/
	/*****************************/
	function getEventByID($eventid){

		$ci =& get_instance(); //get main CodeIgniter object
		$ci->load->database(); //load databse library

        $query = $ci->db->get_where('event', array('eventid' => $eventid));
        if($query->num_rows() > 0){
            return $query->result()[0];
        }else{
            return false;
        }

	}

}



if (!function_exists('chkpms')){

	/*****************************/
	/****** Get Rolet By Chaking Permisson ******/
	/*****************************/
	function chkpms(){ 

		$ci =& get_instance(); //get main CodeIgniter object
		$ci->load->database(); //load databse library
        $position = $ci->session->userdata('user_position');
        if($position == "Superadmin"){
            $role = 1;
        }else if($position == "Admin"){
            $role = 2;
        }else if($position == "Contributor"){
            $role = 3;
        }else if($position == "Subscriber"){
            $role = 4;
        }else if($position == "Manager"){
            $role = 5;
        }else if($position == "Commissioner"){
            $role = 6;
        }else if($position == "Coordinator"){
            $role = 7;
        }else if($position == "Others"){
            $role = 8;
        }

        $query = $ci->db->get_where('role', array('roletype' => $role));
        if($query->num_rows() > 0){
            return $query->result()[0];
        }else{
            return false;
        }

	}

}



if (!function_exists('isLogin')){
	function isLogin(){
        $ci =& get_instance(); //get main CodeIgniter object
        $loginStatus = $ci->session->userdata('logged_in');
        if(isset($loginStatus) && $loginStatus == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
	}
}


if (!function_exists('isLoginRedirect')){
	function isLoginRedirect(){
        if(isLogin() == FALSE){
            redirect('access/login', 'refresh');
        }
	}
}



if (!function_exists('isKena')){
	function isKena(){
        $ci =& get_instance(); //get main CodeIgniter object
        $licenseStatus = $ci->session->userdata('license_status');
        if(isset($licenseStatus) && $licenseStatus == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
	}
}

if (!function_exists('isKenaRedirect')){
	function isKenaRedirect(){
        if(isKena() == FALSE){
            redirect('access/license', 'refresh');
        }
	}
}


