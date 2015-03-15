<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Patients extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		 //$this->load->library('session');  //Load the Session 
		
		$this->load->model('org_model');
		$this->load->model('user_model');
		$this->load->model('report_model');
		$this->load->library('pagination');

	}
	
	public function index(){
		$this->load->view("patient_logs");
		
		
	}
	public function addpatientdata()
	{
			if($this->input->post('submit'))
			{
			$features = $this->input->post('features');
			$required_data = implode(',', $features);
			$data=array(
			'p_user'=>$this->input->post('resident_name'),
			'p_password'=>$this->input->post('password'),
			'year'=>$this->input->post('year'),
			'patient_logs_data'=>$required_data,
			'status'=>'2'
			);
			
			$this->db->insert('patient_admin', $data);
			$test['info']="<font color=red>Resident information successfully added.</font>";
			$this->load->view("orgnization",$test);
		
		 
			}
			else
			{
				$this->load->view("orgnization");
			}
	}
	
	
	 
	public function setting()
	{
		
		$this->load->view("change_password");
	}
	
	public function addnewentry()
	{
		$this->load->view("resident_add_entry");
	}
	
	public function patientlogs()
	{
		$this->load->view("patient_logs");
	}
	
	public function report()
	{
		$this->load->view("rotation_report");
	}
	
	public function rotation_list()
	{
		$this->load->view("rotation_list");
	}
	public function rotation_report()
	{
		 
		$this->load->view("rotation_report");
	}
	
	public function graphreport()
	{
		 
		$this->load->view("graph_report");
	}
}