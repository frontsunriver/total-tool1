<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends MX_Controller {

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

	/**********************************/
	/***** Financial > Fund Index *****/
	/**********************************/
	public function index(){
		$this->load->view('Dashboard/header');
		$this->load->view('Funds/funds');
		$this->load->view('Dashboard/footer');
	}

	/*******************************************/
	/***** Financial > Add New Fund Record *****/
	/*******************************************/
	public function addnewfunds(){

		$curtrtnamount = $this->get_current_balance();
		if($curtrtnamount){
			foreach($curtrtnamount as $row){
				$currentbalance = $row->fundsbalance;
			}
			$entrytype = $this->input->post('amounttype');
			$entryamount = $this->input->post('amount');
			if($entrytype == "Collect"){
				$totalbalance = (int)$currentbalance + $entryamount;
			}else{
				$totalbalance = (int)$currentbalance - $entryamount;
			}
		}else{
			$totalbalance = '';
		}
		$data = array();
		$fdate = $this->input->post('fdate');
		$fdate = str_replace('/', '.', $fdate);
		$data['fundsdate'] = $this->input->post('fdate');
		$data['fundsamount'] = $this->input->post('amount');
		$data['fundstype'] = $this->input->post('amounttype');
		$data['receivedby'] = $this->input->post('receivedby');
		$data['fundssource'] = $this->input->post('source');
		$data['fundsnote'] = $this->input->post('description');
		if($totalbalance != ""){
			$data['fundsbalance'] = $totalbalance;
		}else{
			$data['fundsbalance'] = $this->input->post('amount');
		}
		$data['fundsmonth'] = date('F', strtotime($fdate));
		$data['fundsyear'] = date('Y', strtotime($fdate));
                $data['cdate'] = date("j F Y");
		if($data){
			$inserted = $this->db->insert('funds', $data);
			if($inserted == TRUE){
			$this->session->set_flashdata('success', 'Successfully New Record Added');
			redirect('dashboard/financial/funds/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/funds/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/funds/', 'refresh');
		}
	}


	/****************************************/
	/***** Financial > All Fund Records *****/
	/****************************************/
	public function funds(){

		$baselink = "financial/funds";
		$database = "funds";
		$perpage = 10;
		$limit = iniPagination($baselink, $database, $perpage);
		$start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['funds'] = $this->get_funds_pagi_data($limit, $start);
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('Dashboard/header');
		$this->load->view('Funds/funds', $data);
		$this->load->view('Dashboard/footer');
	}


	/*************************************************/
	/***** Financial > Fund Records Pagination  *****/
	/*************************************************/
	public function get_funds_pagi_data($limit, $start){

		$this->db->order_by("fundsid", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	/**************************************************/
	/***** Financial > Editing Individual Record *****/
	/*************************************************/
	public function edit(){

		$fundsid = $this->uri->segment(4);
		$data['funds'] = $this->getIndiFund($fundsid);
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$data['sum_balance'] = $this->get_sum_current_balance();
		$this->load->view('Dashboard/header');
		$this->load->view('Funds/edit', $data);
		$this->load->view('Dashboard/footer');
	}

	/************************************************/
	/***** Financial > Update Individual Record *****/
	/************************************************/
	public function update(){

		$fundsid = $this->input->post('fundsid');
		$data = array();
		$fdate = $this->input->post('fdate');
		$fdate = str_replace('/', '.', $fdate);
		$data['fundsdate'] = $this->input->post('fdate');
		$data['fundsamount'] = $this->input->post('amount');
		$data['fundstype'] = $this->input->post('amounttype');
		$data['receivedby'] = $this->input->post('receivedby');
		$data['fundssource'] = $this->input->post('source');
		$data['fundsnote'] = $this->input->post('description');
		$data['fundsmonth'] = date('F', strtotime($fdate));
		$data['fundsyear'] = date('Y', strtotime($fdate));
                $data['cdate'] = date("j F Y");

		if($data){
			$this->db->where('fundsid', $fundsid);
			$updated = $this->db->update('funds', $data);
			if($updated == TRUE){
				$this->session->set_flashdata('success', 'Successfully Updated');
				redirect('dashboard/financial/funds/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/funds/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/funds/', 'refresh');
		}


	}

	/************************************************/
	/***** Financial > Delete Individual Record *****/
	/************************************************/
	public function delete(){
		$fundsid = $this->uri->segment(4);
		$deleted = $this->db->delete('funds', array('fundsid' => $fundsid));
		if($deleted == TRUE){
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('dashboard/financial/funds/', 'refresh');
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/funds/', 'refresh');
		}
	}


	/*****************************************************/
	/*****************************************************/

	/*****************************************************/
	/*************** Fund Browse Start Here ***************/
	/*****************************************************/

	/*****************************************************/
	/*************** Fund Browsing **********************/
	/*****************************************************/
	public function browse(){

		$month = $this->input->post('month');
		$year = $this->input->post('year');

		//Queering Monthly Browse
		if($month && $year){

			$this->db->order_by("fundsid", "desc");
			$query = $this->db->get_where('funds', array('fundsmonth' => $month, 'fundsyear' => $year));

			$data['month'] = $month;
			$data['year'] = $year;
			$data['funds_browse'] = $query->result();
			$data['funds_browse_year'] = ''; //funds_browse_year submitting empty so that in fundsbrowse it do not show any error

			$data['sum_collect'] = $this->get_sum_collect_data();
			$data['sum_spend'] = $this->get_sum_spend_data();
			$data['sum_balance'] = $this->get_sum_current_balance();

			$data['browse_collect'] = $this->get_sum_browse_collect($month, $year);
			$data['browse_spend'] = $this->get_sum_browse_spend($month, $year);
			$data['browse_balance'] = $this->get_sum_browse_balance($month, $year);

			$data['browse_collect_year'] = ''; //Total Sum Of Collect Of Year
			$data['browse_spend_year'] = ''; //Total Sum Of Spend Of Year

			$data['browse_collect_jan'] = '';
			$data['browse_spend_jan'] = '';

			$data['browse_collect_feb'] = '';
			$data['browse_spend_feb'] = '';

			$data['browse_collect_feb'] = '';
			$data['browse_spend_feb'] = '';

			$data['browse_collect_mar'] = '';
			$data['browse_spend_mar'] = '';

			$data['browse_collect_apr'] = '';
			$data['browse_spend_apr'] = '';

			$data['browse_collect_may'] = '';
			$data['browse_spend_may'] = '';

			$data['browse_collect_jun'] = '';
			$data['browse_spend_jun'] = '';

			$data['browse_collect_jul'] = '';
			$data['browse_spend_jul'] = '';

			$data['browse_collect_aug'] = '';
			$data['browse_spend_aug'] = '';

			$data['browse_collect_sep'] = '';
			$data['browse_spend_sep'] = '';

			$data['browse_collect_oct'] = '';
			$data['browse_spend_oct'] = '';

			$data['browse_collect_nov'] = '';
			$data['browse_spend_nov'] = '';

			$data['browse_collect_dec'] = '';
			$data['browse_spend_dec'] = '';

			$this->load->view('Dashboard/header');
			$this->load->view('Funds/fundsbrowse', $data);
			$this->load->view('Dashboard/footer');

		}elseif(!$month && $year){

			$data['month'] = $month;
			$data['year'] = $year;
			$data['funds_browse'] = ''; //funds_browse submitting empty so that in fundsbrowse it do not show any error
			$data['funds_browse_year'] = "Year";
			$data['sum_collect'] = $this->get_sum_collect_data(); //Total Sum Of Collect
			$data['sum_spend'] = $this->get_sum_spend_data(); //Total Sum Of Spend
			$data['browse_collect_year'] = $this->get_sum_browse_collect_year($year); //Total Sum Of Collect Of Year
			$data['browse_spend_year'] = $this->get_sum_browse_spend_year($year); //Total Sum Of Spend Of Year
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
			$this->load->view('Dashboard/header');
			$this->load->view('Funds/fundsbrowse', $data);
			$this->load->view('Dashboard/footer');
		}else{
			redirect('dashboard/financial/funds/', 'refresh');
		}
	}


	/////////////////////////////////////////////////////
	/////////////////////////////////////////////////////

	///////////////////////////////////////////////////
	////////////////// Donation    ////////////////////
	///////////////////////////////////////////////////

	//Donation Index Page
	public function donation(){

		$data['donations'] = $this->get_donations();
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$data['sum_donation'] = $this->get_sum_donation();

		$this->load->view('Dashboard/header');
		$this->load->view('Funds/donation', $data);
		$this->load->view('Dashboard/footer');
	}


	//Adding New Donation Data Into Database
	public function addnewdonation(){

		///$errors=array();
		$data = array();
		$ddate = $this->input->post('donationdate');
		$ddate = str_replace('/', '.', $ddate);
		$data['donationdate'] = $this->input->post('donationdate');
		$data['donationamount'] = $this->input->post('donationamount');
		$data['donationsource'] = $this->input->post('donationsource');
		$data['donationby'] = $this->input->post('donationby');
		$data['donationinfo'] = $this->input->post('donationinfo');
		$data['donationreceivedby'] = $this->input->post('donationreceivedby');
		$data['donationnote'] = $this->input->post('donationnote');
		$data['donationmonth'] = date('F', strtotime($ddate));
		$data['donationyear'] = date('Y', strtotime($ddate));
                $data['cdate'] = date("j F Y");

		if($data){
			$inserted = $this->db->insert('donation', $data);
			if($inserted == TRUE){
			$this->session->set_flashdata('success', 'Successfully New Record Added');
			redirect('dashboard/financial/donation/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/donation/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/donation/', 'refresh');
		}
	}


	//Getting Donations Data
	public function get_donations(){

		$this->db->order_by("donationid", "desc");
		$query = $this->db->get('donation');

		if($query->num_rows() > 0){
			return $query->result();
		}
	}


	//Editing Individual Funds
	public function editdonation(){

		$donationid = $this->uri->segment(4);
		$data['donation'] = $this->getIndiDonation($donationid);
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$this->load->view('Dashboard/header');
		$this->load->view('Funds/editdonation', $data);
		$this->load->view('Dashboard/footer');
	}

	//Adding New Funds Data Into Database
	public function updatedonation(){

		$donationid = $this->input->post('donationid');

		///$errors=array();
		$data = array();

		$ddate = $this->input->post('donationdate');
		$ddate = str_replace('/', '.', $ddate);
		$data['donationdate'] = $this->input->post('donationdate');
		$data['donationamount'] = $this->input->post('donationamount');
		$data['donationsource'] = $this->input->post('donationsource');
		$data['donationby'] = $this->input->post('donationby');
		$data['donationinfo'] = $this->input->post('donationinfo');
		$data['donationreceivedby'] = $this->input->post('donationreceivedby');
		$data['donationnote'] = $this->input->post('donationnote');
		$data['donationmonth'] = date('F', strtotime($ddate));
		$data['donationyear'] = date('Y', strtotime($ddate));
                $data['cdate'] = date("j F Y");

		if($data){
			$this->db->where('donationid', $donationid);
			$updated = $this->db->update('donation', $data);
			if($updated == TRUE){
				$this->session->set_flashdata('success', 'Successfully Updated');
				redirect('dashboard/financial/donation/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/donation/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/donation/', 'refresh');
		}



	}

	public function deletedonation(){

		$donationid = $this->uri->segment(4);
		$deleted = $this->db->delete('donation', array('donationid' => $donationid));
		if($deleted == TRUE){
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('dashboard/financial/donation/', 'refresh');
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/donation/', 'refresh');
		}
	}

	/////////////////////////////////////////////////////
	/////////////////////////////////////////////////////

	///////////////////////////////////////////////////
	////////////////// Assets  ////////////////////////
	///////////////////////////////////////////////////

	//Donation Index Page
	public function assets(){

		$data['assets'] = $this->get_assets();
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$data['sum_assets'] = $this->get_sum_assets();

		$this->load->view('Dashboard/header');
		$this->load->view('Funds/assets', $data);
		$this->load->view('Dashboard/footer');
	}


	//Adding New Assets Data Into Database
	public function addnewassets(){

		///$errors=array();
		$data = array();
		$ddate = $this->input->post('assetsdate');
		$ddate = str_replace('/', '.', $ddate);
		$data['assetsdate'] = $this->input->post('assetsdate');
		$data['assetsitem'] = $this->input->post('assetsitem');
		$data['assetsamount'] = $this->input->post('assetsamount');
		$data['assetsverifiedby'] = $this->input->post('assetsverifiedby');
		$data['assetsnote'] = $this->input->post('assetsnote');
		$data['assetsmonth'] = date('F', strtotime($ddate));
		$data['assetsyear'] = date('Y', strtotime($ddate));
                $data['cdate'] = date("j F Y");

		if($data){
			$inserted = $this->db->insert('assets', $data);
			if($inserted == TRUE){
			$this->session->set_flashdata('success', 'Successfully New Record Added');
			redirect('dashboard/financial/assets/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/assets/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/assets/', 'refresh');
		}
	}


	//Getting Donations Data
	public function get_assets(){

		$this->db->order_by("assetsid", "desc");
		$query = $this->db->get('assets');

		if($query->num_rows() > 0){
			return $query->result();
		}
	}


	//Editing Individual Funds
	public function editassets(){

		$assetsid = $this->uri->segment(4);
		$data['assets'] = $this->getIndiAssets($assetsid);
		$data['sum_collect'] = $this->get_sum_collect_data();
		$data['sum_spend'] = $this->get_sum_spend_data();
		$this->load->view('Dashboard/header');
		$this->load->view('Funds/editassets', $data);
		$this->load->view('Dashboard/footer');
	}

	//Adding New Funds Data Into Database
	public function updateassets(){

		$assetsid = $this->input->post('assetsid');

		///$errors=array();
		$data = array();
		$ddate = $this->input->post('assetsdate');
		$ddate = str_replace('/', '.', $ddate);
		$data['assetsdate'] = $this->input->post('assetsdate');
		$data['assetsitem'] = $this->input->post('assetsitem');
		$data['assetsamount'] = $this->input->post('assetsamount');
		$data['assetsverifiedby'] = $this->input->post('assetsverifiedby');
		$data['assetsnote'] = $this->input->post('assetsnote');
		$data['assetsmonth'] = date('F', strtotime($ddate));
		$data['assetsyear'] = date('Y', strtotime($ddate));
                $data['cdate'] = date("j F Y");

		if($data){
			$this->db->where('assetsid', $assetsid);
			$updated = $this->db->update('assets', $data);
			if($updated == TRUE){
				$this->session->set_flashdata('success', 'Successfully Updated');
				redirect('dashboard/financial/assets/', 'refresh');
			}else{
				$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
				redirect('dashboard/financial/assets/', 'refresh');
			}
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/assets/', 'refresh');
		}


	}

	public function deleteassets(){
		$assetsid = $this->uri->segment(4);
		$deleted = $this->db->delete('assets', array('assetsid' => $assetsid));
		if($deleted == TRUE){
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('dashboard/financial/assets/', 'refresh');
		}else{
			$this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
			redirect('dashboard/financial/assets/', 'refresh');
		}
	}

	/////////////////////////////////////////////////////
	/////////////////////////////////////////////////////

	///////////////////////////////////////////////////
	////////////////// Individual ////////////////////
	///////////////////////////////////////////////////

	//Getting Individual Funds Data
	public function getIndiFund($fundsid){
		$query = $this->db->get_where('funds', array('fundsid' => $fundsid));

		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	//Getting Individual Donation Data
	public function getIndiDonation($donationid){
		$query = $this->db->get_where('donation', array('donationid' => $donationid));

		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	//Getting Individual Assets Data
	public function getIndiAssets($assetsid){
		$query = $this->db->get_where('assets', array('assetsid' => $assetsid));

		if($query->num_rows() > 0){
			return $query->result();
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


	//Getting Current Balance Data Or The Last Row For Last row balance
	public function get_current_balance(){
		$this->db->order_by("fundsid", "desc");
		$this->db->limit(1);
		$query = $this->db->get('funds');

		if($query->num_rows() > 0){
			return $query->result();
		}
	}
}
