<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
            $this->load->view('login_view',null);
	}
       
        public function logout()
	{
            $this->session->sess_destroy();
            $this->load->view('login_view',null);
	}
        
        public function delete()
	{
            $this->load->model('user_model');
            $this->user_model->delete_user($this->session->userdata("idUser"));
            $this->session->sess_destroy();
            $this->load->view('login_view',null);
	}
        
        public function ajax()
	{
            $this->load->model('user_model');
            switch($this->input->post("method"))
            {
                case "login": 
                    $user = $this->user_model->get_user(array('email' => $this->input->post("email"), 'password' => md5($this->input->post("password"))));
                    if(isset($user[0])) {
                        $this->session->set_userdata(array(
                            "idUser" => $user[0]->id,
                            "userName" => $user[0]->name)
                        );
                        echo json_encode(array("state" => "ok"));
                    }
                    else echo json_encode(array("state" => "error"));
                break;
                case "signin": 
                    $user = $this->user_model->get_user(array('email' => $this->input->post("email")));
                    if(!isset($user[0])) {
                        $this->user_model->insert_user(array(
                            "name" => $this->input->post("name"), 
                            "email" => $this->input->post("email"),
                            "password" => md5($this->input->post("password"))));
                        $this->session->set_userdata(array(
                            "idUser" => $this->user_model->last_id(),
                            "userName" => $this->input->post("name"))
                        );
                        echo json_encode(array("state" => "ok"));
                    }
                    else echo json_encode(array("state" => "error"));
                break;

            }
        }
}