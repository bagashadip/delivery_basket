<?php

class Model_folder extends CI_Model{

    function add_data_folder($data){
        $this->db->insert('folders', $data);
    }

    function get_folder(){
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->join('client', 'folders.client_id = client.client_id');
        $query = $this->db->get();
        return $query->result();
    }


    function get_checked_folder($client_id){
        $query = $this->db->get_where('folders', array('client_id' => $client_id));
        return $query->result();
    }

    function get_complain(){
        $this->db->select('*'); // <-- There is never any reason to write this line!
        $this->db->from('complain_ticket');
        $this->db->join('pelanggan', 'complain_ticket.no_pel = pelanggan.no_pel');
        $this->db->join('complain_level', 'complain_ticket.complain_level_id=complain_level.complain_level_id');
        $this->db->join('complain_sla', 'complain_ticket.complain_sla_id=complain_sla.complain_sla_id');

        $query = $this->db->get();
        return $query->result();
    }

    function update_folder($id,$data){
        $this->db->where('client_id', $id);
        $this->db->update('folders', $data);
    }

    function change_status($id,$data){
        $this->db->where('client_id', $id);
        $this->db->update('folders', $data);
    }

    function get_folder_status($id){
        $query = $this->db->get_where('folders', array('client_id' => $id));
        return $query->result();
    }

    function delete_folder($id){
        $this->db->where('client_id', $id);
        $this->db->delete('folders');
    }

    function get_last_folder_id(){
        $this->db->order_by('client_id', 'DESC');
        $this->db->select('client_id');
        $this->db->limit(1);
        $query = $this->db->get_where('folders');
        return $query->result();
    }

}
