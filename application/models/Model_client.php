<?php

class Model_client extends CI_Model{

    function add_data_client($data){
        $this->db->insert('client', $data);
    }

    function get_clients(){
        $query = $this->db->get_where('client');
        return $query->result();
    }

    function update_client($id,$data){
        $this->db->where('client_id', $id);
        $this->db->update('client', $data);
    }

    function delete_client($id){
        $this->db->where('client_id', $id);
        $this->db->delete('client');
    }

    function get_last_client_id(){
        $this->db->order_by('client_id', 'DESC');
        $this->db->select('client_id');
        $this->db->limit(1);
        $query = $this->db->get_where('client');
        return $query->result();
    }

}
