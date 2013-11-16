<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function init($ajax=false)
    {
        if(!$this->session->userdata("userName")) {
            if($ajax) die("expired");
            else redirect("login"); 
        }
        $this->load->model('contact_model');        
    }    

    public function index($msg ="")
    {
        $this->init();
        $this->load->view('main_view',null);
    }
    
    public function ajax()
    {
        $this->init(true);
        switch($this->input->post("method"))
        {
            case "updateFilter": 
                $categories = $this->contact_model->get_categories($this->session->userdata("idUser"));
                echo json_encode(array("categories" => $categories));
            break;
            case "updateTable": 
                $contacts = $this->contact_model->get_contacts($this->session->userdata("idUser"),$this->input->post("category"));
                echo json_encode(array("contacts" => $contacts));
            break;
            case "addContact": 
                if($this->contact_model->insert_contact(array(
                    "user" => $this->session->userdata("idUser"),
                    "name" => $this->input->post("name"),
                    "telephone" => $this->input->post("telephone"))))
                {
                    echo json_encode(array("state" => "ok"));
                }
                else echo json_encode(array("state" => "error"));
            break;
            case "deleteContact": 
                if($this->contact_model->delete_contact($this->input->post("id"))){
                    echo json_encode(array("state" => "ok"));
                }
                else echo json_encode(array("state" => "error"));
            break;
            case "addCategory": 
                $category = $this->contact_model->get_category(array(
                    "name" => $this->input->post("name"),
                    "user" => $this->session->userdata("idUser"))
                );
                if(isset($category[0])) echo json_encode(array("state" => "repeated"));
                else{
                    if($this->contact_model->insert_category(array(
                        "name" => $this->input->post("name"),
                        "user" => $this->session->userdata("idUser"))))
                    {
                        echo json_encode(array("state" => "ok"));
                    }
                    else echo json_encode(array("state" => "error"));
                }
            break;
            case "deleteCategory": 
                if($this->contact_model->delete_category($this->input->post("id"))){
                    echo json_encode(array("state" => "ok"));
                }
                else echo json_encode(array("state" => "error"));
            break;
            case "getContactData": 
                $contact = $this->contact_model->get_contact($this->input->post("id"));
                $userCategories = $this->contact_model->get_categories($this->session->userdata("idUser"));
                $contactCategories = $this->contact_model->get_contactCategories($this->input->post("id"));
                if(isset($contact[0])){
                    echo json_encode(array("state" => "ok", 
                                           "contact" => $contact[0], 
                                           "userCategories" => $userCategories,
                                           "contactCategories" => $contactCategories));
                }
                else echo json_encode(array("state" => "error"));
            break;
            case "updateContact": 
                //First we update de contact data
                $result = $this->contact_model->update_contact($this->input->post("idContact"),array(
                        "name" => $this->input->post("contactName"),
                        "telephone" => $this->input->post("contactTelephone"),
                    ));
                //Later we reset all the categories for this contact
                $result = $result && $this->contact_model->delete_contactCategories($this->input->post("idContact"));
                //Finally we insert the new categories for this contact
                foreach($_POST as $i => $value){ 
                    if(substr($i,0,8)=="category"){
                        $result = $result && $this->contact_model->insert_contactCategories(array(
                            "contact" => $this->input->post("idContact"),
                            "category" => substr($i,8)
                        ));                        
                    } 
                 }
                
                if($result) echo json_encode(array("state" => "ok"));
                else echo json_encode(array("state" => "error"));
            break;

        }
    }

        

}
