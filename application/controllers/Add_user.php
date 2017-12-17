<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_user extends CI_Controller {

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

    public function index(){
    	if(!$this->session->userdata("login")){
            redirect("Not_found404");
        }else{
        	$data['last_id'] = $this->model_user->get_last_user_id();
			$data['clients'] = $this->model_client->get_clients();
			$data['folders'] = $this->model_folder->get_folder();
			$data['shops'] = $this->model_shop->get_shops();
			$data['plugins'] = $this->model_plugin->get_plugins();
			$data['users'] = $this->model_user->get_users();
			$data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));
			$this->load->view('header', $data);
	    	$this->load->view('view_add_user', $data);
	    	$this->load->view('footer');
        }
    }

    public function add_data_user(){
    	$str=null;
    	if($this->input->post('save')){
			$date = date("Y-m-d H:i:s");
			$name = $this->input->post('full_name');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$lvl = $this->input->post('level');
			foreach ($this->input->post('clients') as $row) {
				$str .= $row.",";
			}
			$data_user = array(
				'user_full_name' => $name,
				'user_email' => $username,
				'user_password' => $password,
				'user_lvl' => $lvl,
				'assigned_folders' => rtrim($str,','),
				'user_create_date' => $date
			);
			$this->model_user->add_data_user($data_user);
			$alert = array(
				'msg' => 'New user successfully added',
				'cls' => 'alert alert-success',
				'status' => 'Success!'
			);
			$this->session->set_flashdata('alert', $alert);
		}else if($this->input->post('update')){
			$user_id = $this->input->post('user_id');
			$name = $this->input->post('full_name');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$lvl = $this->input->post('level');
			foreach ($this->input->post('clients') as $row) {
				$str .= $row.",";
			}
			$data_user = array();
			if(!empty($this->input->post('password'))){
				$data_user = array(
					'user_full_name' => $name,
					'user_email' => $username,
					'user_password' => $password,
					'user_lvl' => $lvl,
					'assigned_folders' => rtrim($str,',')
				);
			}else{
				$data_user = array(
					'user_full_name' => $name,
					'user_email' => $username,
					'user_lvl' => $lvl,
					'assigned_folders' => rtrim($str,',')
				);
			}
			
			$this->model_user->update_user($user_id,$data_user);
			$alert = array(
				'msg' => 'User data has been changed',
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
		redirect('add_user');
    }

    public function get_user(){
    	$user_id = $this->input->post("id");
        
        $data = $this->model_user->get_user($user_id);
        
        $x = json_encode($data);
        
        $data = str_replace("[", "", $x);
        $data = str_replace("]", "", $data);

        echo $data;
    }

    public function delete_user($id=null){
    	$this->model_user->delete_user($id);
    	$alert = array(
			'msg' => 'User has been removed',
			'cls' => 'alert alert-warning',
			'status' => 'Deleted!'
		);
		$this->session->set_flashdata('alert', $alert);
		redirect("add_user");
    }

    public function test(){
    	var_dump($this->session->userdata());
    }

}