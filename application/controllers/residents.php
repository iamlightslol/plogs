<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Residents extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		 //$this->load->library('session');  //Load the Session 
		
		$this->load->model('org_model');

	}
	
	public function index()
    {
		$this->load->view("resident_add_entry"); 
	}
	
	
	function register()
        {
			$this->load->library('form_validation');
			// field name, error message, validation rules
			$this->form_validation->set_rules('org_name', 'Organization Name', 'trim|required|min_length[4]|xss_clean');
			$this->form_validation->set_rules('org_user_username', 'User Name', 'trim|required|min_length[4]|xss_clean');
			$this->form_validation->set_rules('org_password', 'Password', 'trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('org_repassword', 'Password Confirmation', 'trim|required|matches[org_password]');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
	
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view("login");
			}
			else
			{
				
				if($this->input->post('Register'))
				{
				  $result =$this->org_model->signup();
				  if($result){
					  $data['org']="Your Registration is Successfull";
					  $this->load->view("login",$data); 
					  } 
				}
			}
            
            
        }
	
	}