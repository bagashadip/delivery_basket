<?php

class Model_shop extends CI_Model{

    function add_data_shop($data){
        $this->db->insert('shop', $data);
    }

    function get_shops(){
        $query = $this->db->get_where('shop');
        return $query->result();
    }

    function update_shop($id,$data){
        $this->db->where('shop_id', $id);
        $this->db->update('shop', $data);
    }

    function delete_shop($id){
        $this->db->where('shop_id', $id);
        $this->db->delete('shop');
    }

    function get_last_shop_id(){
        $this->db->order_by('shop_id', 'DESC');
        $this->db->select('shop_id');
        $this->db->limit(1);
        $query = $this->db->get_where('shop');
        return $query->result();
    }

}
