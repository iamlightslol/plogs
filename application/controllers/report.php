<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Report extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		 $this->load->library('session');  //Load the Session 
		
		$this->load->model('report_model');

	}
	
	public function index()
    {
		$this->load->view("reports.php"); 
	}
	
	
	
	public function getsearchdata()
	{
		 $rid=$this->input->post("rid");
		 $type=$this->input->post("type");
		 $value=$this->input->post("value");
		 $res_year=$this->input->post("res_year");
		 $org_id=$this->input->post("org_id");
		 $data["rid"]=$rid;
		 $data["org_id"]=$org_id;
		 $data["res_year"]=$res_year;
		 $data["type"]=$type;
		 $data["value"]=$value;
		 $data["sdiagnossis_for_report"]=$this->report_model->scndary_diagnosis_for_report($rid,$org_id,$res_year,$type,$value);
		 $data["resident_info"]=$this->report_model->get_resident_data($rid);
		 $data["total_patient"]=$this->report_model->total_roation_patient($rid,$type,$value,$res_year);
		 $data['total__distinct_patient']=$this->report_model->total__distinct_patient($rid,$type,$value,$res_year);
		 $data["dgns"]=$this->report_model->get_dignosis_list_for_report($rid,$type,$value,$res_year);
		 $data["min_date"]=$this->report_model->min_date($rid,$type,$value,$res_year);
		 $data["max_date"]=$this->report_model->max_date($rid,$type,$value,$res_year);
		 $data["total_male"]=$this->report_model->total_male($rid,$type,$value,$res_year);
		 $data["total_female"]=$this->report_model->total_female($rid,$type,$value,$res_year);
		 return $this->load->view("ajax_search",$data);

	}
	
	public function getgraphdata()
	{
		
		$data["rid"]=$this->input->post("rid");
		$data["type"]=$this->input->post("type");
		$data["res_year"]=$this->input->post("res_year");
		if($this->input->post("type")=='Age'){
		return $this->load->view("reports",$data);
		}
		else if($this->input->post("type")=='Gender'){
		return $this->load->view("reports1",$data);
		}
		else if($this->input->post("type")=='Rotation'){
		return $this->load->view("reports2",$data);
		}
		else if($this->input->post("type")=='Primary Diagnosis'){
		return $this->load->view("reports3",$data);
		}
	}
	
	
	
}