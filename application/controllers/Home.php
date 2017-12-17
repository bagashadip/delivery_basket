<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
            $data['error'] = '';
            $data['shops'] = $this->model_shop->get_shops();
            $data['folders'] = $this->model_folder->get_folder();
            $data['clients'] = $this->model_client->get_clients();
            $data['plugins'] = $this->model_plugin->get_plugins();
            $data['last_id'] = $this->model_plugin->get_last_plugin_id();
            $data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));
            $this->load->view('header', $data);
            $this->load->view('footer');
        }
		
	}

}