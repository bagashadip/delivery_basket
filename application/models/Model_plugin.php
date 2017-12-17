<?php

class Model_plugin extends CI_Model{

    function add_data_plugin($data){
        $this->db->insert('plugin', $data);
    }

    function get_plugins(){
        $this->db->select('*');
        $this->db->from('plugin');
        $this->db->join('client', 'plugin.client_id = client.client_id');
        $this->db->join('shop', 'plugin.shop_id = shop.shop_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_plugin_file($id){
        $query = $this->db->get_where('plugin', array('plugin_id' => $id));
        return $query->result();
    }

    function update_plugin($id,$data){
        $this->db->where('plugin_id', $id);
        $this->db->update('plugin', $data);
    }

    function delete_plugin($id){
        $this->db->where('plugin_id', $id);
        $this->db->delete('plugin');
    }

    function get_last_plugin_id(){
        $this->db->order_by('plugin_id', 'DESC');
        $this->db->select('plugin_id');
        $this->db->limit(1);
        $query = $this->db->get_where('plugin');
        return $query->result();
    }

}
