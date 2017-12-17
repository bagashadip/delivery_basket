<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_shop extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("model_shop");
        $this->load->model("model_client");
        $this->load->model("model_folder");
        $this->load->model("model_plugin");
        $this->load->model("model_user");
        $this->load->library('session');
        date_default_timezone_set("Asia/Bangkok");
    }

	public function index()
	{	
		if(!$this->session->userdata("login")){
            redirect("Not_found404");
        }else{
        	$data['shops'] = $this->model_shop->get_shops();
			$data['last_id'] = $this->model_shop->get_last_shop_id();
			$data['folders'] = $this->model_folder->get_folder();
			$data['clients'] = $this->model_client->get_clients();
			$data['plugins'] = $this->model_plugin->get_plugins();
			$data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));
			$this->load->view('header', $data);
			$this->load->view('view_add_shop', $data);
			$this->load->view('footer');
        }
	}

	public function add_data_shop() {

		if($this->input->post('save')){
			$date = date("Y-m-d H:i:s");
			$shop = $this->input->post('shop_name');
			$data = array(
				'shop_name' => $shop,
				'shop_create_date' => $date
			);
			$this->model_shop->add_data_shop($data);
			$alert = array(
				'msg' => 'New shop successfully added',
				'cls' => 'alert alert-success',
				'status' => 'Success!'
			);
			$this->session->set_flashdata('alert', $alert);
		} else if($this->input->post('update')){
			$id = $this->input->post('shop_id');
			$client = $this->input->post('shop_name');
			$data = array(
				'shop_name' => $client
			);
			$this->model_shop->update_shop($id,$data);
			$alert = array(
				'msg' => 'Shop data has been changed',
				'cls' => 'alert alert-info',
				'status' => 'Updated!'
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
		redirect("add_shop");
	}

	public function delete_shop($id=null) {
		$this->model_shop->delete_shop($id);
		$alert = array(
			'msg' => 'Shop has been removed',
			'cls' => 'alert alert-warning',
			'status' => 'Deleted!'
		);
		$this->session->set_flashdata('alert', $alert);
		redirect("add_shop");
	}
}