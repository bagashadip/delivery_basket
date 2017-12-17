<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_folder extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("model_client");
        $this->load->model("model_shop");
        $this->load->model("model_folder");
        $this->load->model("model_plugin");
        $this->load->model("model_user");
        $this->load->library('session');
        date_default_timezone_set("Asia/Bangkok");
    }

	public function index() {
		if(!$this->session->userdata("login")){
            redirect("Not_found404");
        }else{
        	$data['clients'] = $this->model_client->get_clients();
			$data['shops'] = $this->model_shop->get_shops();
			$data['folders'] = $this->model_folder->get_folder();
			$data['plugins'] = $this->model_plugin->get_plugins();
			$data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));
			$this->load->view('header', $data);
			$this->load->view('view_add_folder', $data);
			$this->load->view('footer');
        }	
	}

	public function add_data_folder(){
		$str= null;
		if($this->input->post('save')){
			$path = "plugins/cardprocess";
		    // if(!is_dir($path))
		    // {
		    //   mkdir($path,0777,TRUE);
		    // }
			$date = date("Y-m-d H:i:s");
			$client_id = $this->input->post('c_client');
			if(!empty($this->input->post('shops'))){
				foreach ($this->input->post('shops') as $row) {
					$str .= $row.",";
				}
				$data = array(
					'shop_id' => rtrim($str,',')
				);
				$this->model_folder->update_folder($client_id, $data);
			}else{
				$data = array(
					'shop_id' => $str
				);
				$this->model_folder->update_folder($client_id, $data);
			}
			$alert = array(
				'msg' => 'Folder successfully added',
				'cls' => 'alert alert-info',
				'status' => 'Success!'
			);
			$this->session->set_flashdata('alert', $alert);
		}else{
			$alert = array(
				'msg' => 'Failed to add data',
				'cls' => 'alert alert-danger',
				'status' => 'Error!'
			);
			$this->session->set_flashdata('alert', $alert);
		}
		redirect('add_folder');
	}

	public function get_checked_folder(){
		$client_id = $this->input->post("id");
        
        $data = $this->model_folder->get_checked_folder($client_id);
        
        $x = json_encode($data);
        
        $data = str_replace("[", "", $x);
        $data = str_replace("]", "", $data);

        echo $data;
	}

	public function change_status($id=null) {
		$status = $this->model_folder->get_folder_status($id);
		$st = null;
		if($status[0]->status == 0){
			$st = 1;
		}else{
			$st = 0;
		}
		$data = array(
			'status' => $st
		);
		$this->model_folder->change_status($id,$data);
		redirect("add_folder");
	}
}