<?php

class Model_user extends CI_Model{

    function add_data_user($data){
        $this->db->insert('users', $data);
    }

    // function get_users(){
    //     $this->db->select('*');
    //     $this->db->from('folders');
    //     $this->db->join('plugin', 'folders.plugin_id = plugin.plugin_id');
    //     $this->db->join('shop', 'folders.shop_id = shop.shop_id');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function get_users(){
        $query = $this->db->get_where('users');
        return $query->result();
    }

    function get_user($user_id){
        $query = $this->db->get_where('users', array('user_id' => $user_id));
        return $query->result();
    }

    function update_user($id,$data){
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }

    function delete_user($id){
        $this->db->where('user_id', $id);
        $this->db->delete('users');
    }

    function get_last_user_id(){
        $this->db->order_by('user_id', 'DESC');
        $this->db->select('user_id');
        $this->db->limit(1);
        $query = $this->db->get_where('users');
        return $query->result();
    }

}
