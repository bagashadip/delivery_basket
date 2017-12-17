<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("model_login");
        $this->load->library('session');
    }

	public function index()
	{
		$this->load->view('view_login');
	}

	public function login_process(){
    	$username = $this->input->post('login_username');
        $password = md5($this->input->post('login_pass'));

        $data = $this->model_login->check_login($username, $password);
        $user = $this->model_login->get_user($username, $password);

        if($this->input->post('login')){

        	if($data > 0){
		    	foreach ($user as $row) {
                    $session = array("login" => true, "user_id" => $row->user_id, "email" => $row->user_email, "password" => $row->user_password, "fullname" => $row->user_full_name, "level" => $row->user_lvl);
                    $this->session->set_userdata($session);
                }

                if($this->session->userdata("level") == 1){
                    redirect("add_plugin");
                } else {
                    redirect("home");
                }
        	} else {
                $this->session->set_flashdata('alert', 'Username or password is incorrect');
                redirect("login");
            }


        }
    }

    function logout(){
		session_destroy();
		redirect("login");
	}
}