<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_plugin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("model_shop");
        $this->load->model("model_client");
        $this->load->model("model_folder");
        $this->load->model("model_plugin");
        $this->load->model("model_user");
        $this->load->library('session');
        $this->load->helper("file");
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
            $this->load->view('view_add_plugin', $data);
            $this->load->view('footer');
        }
		
	}

	public function add_data_plugin(){
        $plugin_id = $this->input->post('p_id');
		$plugin_name = $this->input->post('p_name');
        $ext = $this->input->post('ext');
		$client_id = $this->input->post('p_client');
		$shop_id = $this->input->post('p_shop');
        $plugin_ext = $plugin_name.$ext;
		$date = date("Y-m-d H:i:s");

		$data['shops'] = $this->model_shop->get_shops();
        $data['folders'] = $this->model_folder->get_folder();
		$data['clients'] = $this->model_client->get_clients();
		$data['plugins'] = $this->model_plugin->get_plugins();
		$data['last_id'] = $this->model_plugin->get_last_plugin_id();
        $data['user_login'] = $this->model_user->get_user($this->session->userdata("user_id"));

        if ($this->input->post('save')) {
            $config['upload_path'] = "./plugins";
            $config['allowed_types'] = 'zip';
            $config['max_size'] = '5000000';
            if($plugin_name != null){
            	$config['file_name'] = $plugin_id;
            }

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('header', $data);
				$this->load->view('view_add_plugin', $data);
				$this->load->view('footer');
            } else {
                $file_data = $this->upload->data();
                if($plugin_name == null){
                	$plugin_ext = $file_data['file_name'];
                }
                $data["file"] = base_url() . "/plugins" . $file_data['file_name'];

                $data = array(
                    'plugin_id' => $plugin_id,
                	'shop_id' => $shop_id,
                	'client_id' => $client_id,
                    'plugin_name' => $plugin_name,
                    'plugin_file' => $plugin_ext,
                    'plugin_status' => 0,
                    'plugin_create_date' => $date
                );
                $this->model_plugin->add_data_plugin($data);
                redirect('add_plugin');
            }
        } else if($this->input->post('update')){
            $config['upload_path'] = "./plugins";
            $config['allowed_types'] = 'zip';
            if($plugin_name != null){
                $config['file_name'] = $plugin_id;
            }

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('header', $data);
                $this->load->view('view_add_plugin', $data);
                $this->load->view('footer');
            } else {
                $file_data = $this->upload->data();
                if($plugin_name == null){
                    $plugin_ext = $file_data['file_name'];
                }
                $data["file"] = base_url() . "/plugins" . $file_data['file_name'];

                // Remove old file before adding a new file
                $data = $this->model_plugin->get_plugin_file($plugin_id);
                $file = "./plugins/" .$data[0]->plugin_id;
                unlink($file);

                $data = array(
                    'shop_id' => $shop_id,
                    'client_id' => $client_id,
                    'plugin_name' => $plugin_ext,
                    'plugin_file' => $plugin_ext
                );
                $this->model_plugin->update_plugin($plugin_id, $data);
                redirect('add_plugin');
            }
        } else if($this->input->post('cancel')) {
            redirect('add_plugin');
        }
	}

    public function delete_plugin($id=null) {
        $data = $this->model_plugin->get_plugin_file($id);
        $file = "./plugins/" .$id.".zip";
        
        unlink($file);
        $this->model_plugin->delete_plugin($id);
        redirect("add_plugin");
    }

	public function download_plugin($plugin){
		$data = $this->model_plugin->get_plugin_file($plugin);
  //       $plugin_name = str_replace("_",".",$plugin);
		// $data = file_get_contents("plugins/".$plugin."");
  //       header('Content-Disposition: attachment; filename="' . $plugin_name . '"');

		$filename = $plugin.".zip";
        $plugin_name = $data[0]->plugin_name;
        $filepath = "plugins/";

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"".$plugin_name."\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($filepath.$filename));
        ob_end_flush();

        @readfile($filepath.$filename);

        while (ob_get_level()) {
            ob_end_clean();
        }
	}
}