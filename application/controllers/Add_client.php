<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_client extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("model_client");
        $this->load->model("model_folder");
        $this->load->model("model_plugin");
        $this->load->model("model_shop");
        $this->load->model("model_user");
        $this->load->library('session');
        date_default_timezone_set("Asia/Bangkok");
    }

	public function index() {
		if(!$this->session->userdata("login")){
            redirect("Not_found404");
        }else{
        	$data['last_id'] = $this->model_client->get_last_client_id();
			$data['clients'] = $this->model_client->get_clients();
			$data['folders'] = $this->model_folder->get_folder();
			$data['plugins'] = $this->model_plugin->get_plugins();
			$data['shops'] = $this->model_shop->get_shops();
			$data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));
			$this->load->view('header', $data);
			$this->load->view('view_add_client', $data);
			$this->load->view('footer');
        }	
		
	}

	public function add_data_client() {
		if($this->input->post('save')){
			$date = date("Y-m-d H:i:s");
			$client_id = $this->input->post('client_id');
			$client = $this->input->post('client_name');
			$data = array(
				'client_name' => $client,
				'client_create_date' => $date
			);
			$data_folder = array(
				'client_id' => $client_id,
				'status' => 0,
				'create_date' => $date
			);
			$this->model_client->add_data_client($data);
			$this->model_folder->add_data_folder($data_folder);
			$alert = array(
				'msg' => 'New client successfully added',
				'cls' => 'alert alert-success',
				'status' => 'Success!'
			);
			$this->session->set_flashdata('alert', $alert);
		} else if($this->input->post('update')){
			$id = $this->input->post('client_id');
			$client = $this->input->post('client_name');
			$data = array(
				'client_name' => $client
			);
			$this->model_client->update_client($id,$data);
			$alert = array(
				'msg' => 'Client data has been changed',
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
		redirect("add_client");
	}

	public function delete_client($id=null) {
		$this->model_client->delete_client($id);
		$alert = array(
			'msg' => 'Client has been removed',
			'cls' => 'alert alert-warning',
			'status' => 'Deleted!'
		);
		$this->session->set_flashdata('alert', $alert);
		redirect("add_client");
	}
}