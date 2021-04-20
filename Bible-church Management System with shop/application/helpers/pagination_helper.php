<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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


if (!function_exists('iniPagination')){
	
	/*****************************/
	/****** Global Pagination Initialization ******/
	/*****************************/
	function iniPagination($baselink, $database, $perpage){
		
		$ci =& get_instance(); //get main CodeIgniter object		
		$ci->load->database(); //load databse library
		
                if(strpos($baselink, 'home') !== false){
                    $config["base_url"] = base_url() . $baselink;
                }else{
                    $config["base_url"] = base_url() . "dashboard/" . $baselink;
                }
                
                $config['total_rows'] = $ci->db->count_all($database);
		$limit = $config['per_page'] = $perpage;
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = $ci->lang->line('dash_gpanel_pre');
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = $ci->lang->line('dash_gpanel_next');
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$ci->pagination->initialize($config);
		return $limit;
		
	}
	
}