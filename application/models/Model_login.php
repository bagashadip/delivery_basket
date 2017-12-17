<?php

class Model_login extends CI_Model{


	function check_login($email,$password){
        $query = $this->db->get_where('users', array('user_email' => $email, 'user_password' => $password));
        return $query->num_rows();
    }

    function get_user($email,$password){
    	$query = $this->db->get_where('users', array('user_email' => $email, 'user_password' => $password));
        return $query->result();	
    }


}