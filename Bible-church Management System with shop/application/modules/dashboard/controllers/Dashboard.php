<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

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

    public function index() {
        $month = date('F');
        $year = date('Y');
        $data['user'] = $this->countAllRows('users');
        $data['committee'] = $this->countAllRows('committee');
        $data['pastor'] = $this->countAllRows('pastor');
        $data['clan'] = $this->countAllRows('clan');
        $data['chorus'] = $this->countAllRows('chorus');
        $data['staff'] = $this->countAllRows('staff');
        $data['member'] = $this->countAllRows('member');
        $data['student'] = $this->countAllRows('sundayschool');
        $data['mFundsCollect'] = $this->getMonthFundsData("Collect", $month, $year);
        $data['mFundsSpend'] = $this->getMonthFundsData("Spend", $month, $year);
        $data['fundsCollect'] = $this->getTotalFundsData("Collect");
        $data['fundsSpend'] = $this->getTotalFundsData("Spend");
        $data['totalAssets'] = $this->getTotalAssetsData();
        $data['totalDonation'] = $this->getTotalDonatinData();
        $data['mDonation'] = $this->getMonthDonationData($month, $year);
        $data['mAssets'] = $this->getMonthAssetsData($month, $year);
        $data['browse_collect_year'] = $this->get_sum_browse_collect_year($year);
        $data['browse_spend_year'] = $this->get_sum_browse_spend_year($year);
        $data['browse_collect_jan'] = $this->get_sum_collect_jan($year);
        $data['browse_spend_jan'] = $this->get_sum_spend_jan($year);
        $data['browse_collect_feb'] = $this->get_sum_collect_feb($year);
        $data['browse_spend_feb'] = $this->get_sum_spend_feb($year);
        $data['browse_collect_feb'] = $this->get_sum_collect_feb($year);
        $data['browse_spend_feb'] = $this->get_sum_spend_feb($year);
        $data['browse_collect_mar'] = $this->get_sum_collect_mar($year);
        $data['browse_spend_mar'] = $this->get_sum_spend_mar($year);
        $data['browse_collect_apr'] = $this->get_sum_collect_apr($year);
        $data['browse_spend_apr'] = $this->get_sum_spend_apr($year);
        $data['browse_collect_may'] = $this->get_sum_collect_may($year);
        $data['browse_spend_may'] = $this->get_sum_spend_may($year);
        $data['browse_collect_jun'] = $this->get_sum_collect_jun($year);
        $data['browse_spend_jun'] = $this->get_sum_spend_jun($year);
        $data['browse_collect_jul'] = $this->get_sum_collect_jul($year);
        $data['browse_spend_jul'] = $this->get_sum_spend_jul($year);
        $data['browse_collect_aug'] = $this->get_sum_collect_aug($year);
        $data['browse_spend_aug'] = $this->get_sum_spend_aug($year);
        $data['browse_collect_sep'] = $this->get_sum_collect_sep($year);
        $data['browse_spend_sep'] = $this->get_sum_spend_sep($year);
        $data['browse_collect_oct'] = $this->get_sum_collect_oct($year);
        $data['browse_spend_oct'] = $this->get_sum_spend_oct($year);
        $data['browse_collect_nov'] = $this->get_sum_collect_nov($year);
        $data['browse_spend_nov'] = $this->get_sum_spend_nov($year);
        $data['browse_collect_dec'] = $this->get_sum_collect_dec($year);
        $data['browse_spend_dec'] = $this->get_sum_spend_dec($year);
		$data['siteinfo'] = $this->getBasicInfo();		
		$data['purchase'] = isKena();		
        $this->load->view('Dashboard/header', $data);
        $this->load->view('Dashboard/dashboard', $data);
        $this->load->view('Dashboard/footer', $data);
    }


    public function getBasicInfo(){
        $query = $this->db->get('websitebasic');
        return $query->result();
    }


    public function countAllRows($table) {
        return $this->db->count_all_results($table);
    }

    public function countFieldRows($table, $field, $gender) {
        $this->db->where($field, $gender);
        return $this->db->count_all_results($table);
    }

    //Getting Sum Of Collected Data
    public function getMonthFundsData($type, $month, $year) {
        $this->db->select_sum('fundsamount');
        $this->db->where('fundstype', $type);
        $this->db->where('fundsmonth', $month);
        $this->db->where('fundsyear', $year);
        $query = $this->db->get('funds');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->fundsamount;
            }
            return $row->fundsamount;
        }
    }


    //Getting Sum Of Collected Data
    public function getTotalFundsData($type) {
        $this->db->select_sum('fundsamount');
        $this->db->where('fundstype', $type);
        $query = $this->db->get('funds');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->fundsamount;
            }
            return $row->fundsamount;
        }
    }

    //Getting Sum Of Collected Data
    public function getTotalDonatinData() {
        $this->db->select_sum('donationamount');
        $query = $this->db->get('donation');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->donationamount;
            }
            return $row->donationamount;
        }
    }


    //Getting Sum Of Collected Data
    public function getTotalAssetsData() {
        $this->db->select_sum('assetsamount');
        $query = $this->db->get('assets');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->assetsamount;
            }
            return $row->assetsamount;
        }
    }

    //Getting Sum Of Collected Data
    public function getMonthDonationData($month, $year) {
        $this->db->select_sum('donationamount');
        $this->db->where('donationmonth', $month);
        $this->db->where('donationyear', $year);
        $query = $this->db->get('donation');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->donationamount;
            }
            return $row->donationamount;
        }
    }

    //Getting Sum Of Collected Data
    public function getMonthAssetsData($month, $year) {
        $this->db->select_sum('assetsamount');
        $this->db->where('assetsmonth', $month);
        $this->db->where('assetsyear', $year);
        $query = $this->db->get('assets');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->assetsamount;
            }
            return $row->assetsamount;
        }
    }


    /////////////////////////////////////////////////
	//////////////////// Sum ////////////////////////
	/////////////////////////////////////////////////

	//Getting Sum Of Collected Data
	public function get_sum_collect_data(){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Data
	public function get_sum_spend_data(){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Current Balance Data
	public function get_sum_current_balance(){
		$this->db->order_by("fundsid", "desc");
		$this->db->limit(1);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsbalance;
			}
			return $row->fundsbalance;
		}
	}


	//Getting Sum Of Collect Of Jan
	public function get_sum_collect_jan($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'January');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of Jan
	public function get_sum_spend_jan($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'January');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Sum Of Collect Of February
	public function get_sum_collect_feb($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'February');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of Jan
	public function get_sum_spend_feb($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'February');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of March
	public function get_sum_collect_mar($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'March');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of Jan
	public function get_sum_spend_mar($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'March');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of April
	public function get_sum_collect_apr($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'April');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of Jan
	public function get_sum_spend_apr($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'April');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of May
	public function get_sum_collect_may($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'May');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of Jan
	public function get_sum_spend_may($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'May');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of June
	public function get_sum_collect_jun($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'June');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of June
	public function get_sum_spend_jun($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'June');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of July
	public function get_sum_collect_jul($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'July');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of July
	public function get_sum_spend_jul($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'July');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of August
	public function get_sum_collect_aug($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'August');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of August
	public function get_sum_spend_aug($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'August');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Sum Of Collect Of September
	public function get_sum_collect_sep($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'September');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of September
	public function get_sum_spend_sep($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'September');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Sum Of Collect Of October
	public function get_sum_collect_oct($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'October');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of August
	public function get_sum_spend_oct($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'October');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of November
	public function get_sum_collect_nov($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'November');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of November
	public function get_sum_spend_nov($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'November');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Collect Of December
	public function get_sum_collect_dec($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', 'December');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Spend Of December
	public function get_sum_spend_dec($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', 'December');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}


	//Getting Sum Of Donation
	public function get_sum_donation(){

		$query = $this->db->select_sum('donationamount');
		$query = $this->db->get('donation');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->donationamount;
			}
			return $row->donationamount;
		}
	}


	//Getting Sum Of Donation
	public function get_sum_assets(){

		$query = $this->db->select_sum('assetsamount');
		$query = $this->db->get('assets');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->assetsamount;
			}
			return $row->assetsamount;
		}
	}



	/////////////////////////////////////////////////
	//////////////////// Browse ///////////////////
	/////////////////////////////////////////////////

	//Getting Browse Sum Of Collected Data by Monthly
	public function get_sum_browse_collect($month, $year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsmonth', $month);
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Browse Sum Of Spend Data by Monthly
	public function get_sum_browse_spend($month, $year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsmonth', $month);
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Browse Sum Of Balance Data by Monthly
	public function get_sum_browse_balance($month, $year){

		$this->db->order_by("fundsid", "desc");
		$this->db->limit(1);
		$query = $this->db->get_where('funds', array('fundsmonth' => $month, 'fundsyear' => $year));

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsbalance;
			}
			return $row->fundsbalance;
		}
	}


	//Getting Browse Sum Of Collected Data by Year
	public function get_sum_browse_collect_year($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Collect');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}

	//Getting Browse Sum Of Spend Data by Monthly
	public function get_sum_browse_spend_year($year){

		$query = $this->db->select_sum('fundsamount');
		$query = $this->db->where('fundstype', 'Spend');
		$query = $this->db->where('fundsyear', $year);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->fundsamount;
			}
			return $row->fundsamount;
		}
	}



    public function switchLang($language = "") {
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('lang', $language);
        //redirect('dashboard/dashboard', 'refresh');
        redirect($_SERVER['HTTP_REFERER']); // Reload to same URL
    }


    // public function evnatoVerify(){

    //     $purchaseCode = $this->getBasicInfo()[0]->verify;
    //     $o = $this->envatoapi->verifyPurchase($purchaseCode);

    //     if(  isset($o['item']['id']) && $o['item']['id'] == "20615578"  ){
    //         return true;
    //     }else {
    //         return false;
    //     }

    //     //echo "<pre>"; var_dump($o['item']['id']); echo "</pre>";


    // }

    public function verifyPurchase() {

        $data['verify'] = $this->input->post('purchasecode');
        $this->db->where('basicid', 1);
        $this->db->update('websitebasic', $data);
        redirect('dashboard', 'refresh');
        
    }

}
