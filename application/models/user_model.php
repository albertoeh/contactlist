<?php

class user_model extends CI_Model {

    function get_user($data)
    {
        $query = $this->db->get_where('user', $data);
        return $query->result();
    }
    
    function insert_user($data){
        return $this->db->insert('user', $data);
    }
    
    function delete_user($id){
        return $this->db->delete('user', array("id" => $id));
    }
 
    function last_id(){
        return $this->db->insert_id();
    }
}

?>
