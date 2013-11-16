<?php

class contact_model extends CI_Model 
{
   function get_categories($user)
    {
        $query = $this->db->get_where('category', array("user" => $user));
        return $query->result();
    }
    
    function get_category($data){
        $query = $this->db->get_where('category', $data);
        return $query->result();
    }
    
    function get_contactCategories($contact){
        $query = $this->db->get_where('contact_category', array("contact" => $contact));
        return $query->result();
    }

    function get_contacts($user,$category)
    {
        if($category!=0){
            $this->db->join('contact_category', 'contact_category.contact = contact.id', 'left');
            $query = $this->db->where("contact_category.category",$category);
        }
        $this->db->order_by('name',"asc");
        $query = $this->db->get_where('contact', array('user' => $user));
        return $query->result();
    }
    
    function get_contact($id)
    {
        $query = $this->db->get_where('contact', array('id' => $id));
        return $query->result();
    }
    
    function insert_contact($data){
        return $this->db->insert('contact', $data);
    }
    
    function insert_category($data){
        return $this->db->insert('category', $data);
    }
    
    function update_contact($id,$data){
        return $this->db->update('contact', $data, array('id' => $id));
    }
    
    function delete_contact($id){
        return $this->db->delete('contact', array('id' => $id));
    }
    
    function delete_category($id){
        return $this->db->delete('category', array('id' => $id));
    }
    
    function delete_contactCategories($contact){
        return $this->db->delete('contact_category', array('contact' => $contact));
    }
    
    function insert_contactCategories($data){
        return $this->db->insert('contact_category', $data);
    }
    
}

?>
