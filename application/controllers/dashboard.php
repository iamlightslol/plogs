<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Dashboard extends CI_Controller {
	
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
		$this->load->view("orgnization.php");
		
		
		}
	public function add(){
		$this->load->view("orgnization.php");
		
		
		}
		
public function residentinfo()
	{
		
		$this->load->view("resident_info");
	}
		
		
	 
	public function addresident()
	{
		$rid=$this->input->post('rid');
		if($rid!='')
		{
			if($this->input->post('submit'))
			{
				$data=array(
				'p_user'=>substr($this->input->post('first_name'), 0, 1).substr($this->input->post('last_name'), 0, 6),
				'p_first_name'=>$this->input->post('first_name'),
				'p_last_name'=>$this->input->post('last_name'),
				'p_password'=>$this->input->post('password'),
				'year'=>$this->input->post('resident_exp')
				);
				$this->db->where('p_id', $rid);
				$this->db->update('patient_admin', $data); 
				$test['info']="<font color=red>Resident information successfully Updated.</font>";
				$this->load->view("resident_info",$test);
			}
			else
			{
				redirect(base_url()."dashboard/addresident/".$rid);
			}
		}
		else
		{
			if($this->input->post('submit'))
			{
				$fname=$this->input->post('first_name');
				$lname=$this->input->post('last_name');
				$username=substr($fname, 0, 1).substr($lname, 0, 6);
				$i=$this->input->post('total');
				
				$features = $this->input->post('features');
				if(!empty($features))
				{
				$required_data = implode(',', $features);
				}
				else
				{
					$required_data='';
				}
				$data=array(
				'org_id'=>$this->input->post('id'),
				'p_user'=>$username,
				'p_first_name'=>$this->input->post('first_name'),
				'p_last_name'=>$this->input->post('last_name'),
				'p_password'=>$this->input->post('password'),
				'year'=>$this->input->post('resident_exp'),
				'patient_logs_data'=>$required_data,
				'status'=>'2'
				);
				$this->db->insert('patient_admin', $data);
				if($i!="0")
				{
					for($n=1;$n<=$i;$n++)
					{
						
						$first_name="first_name".$n;
						$last_name="last_name".$n;
						$password="password".$n;
						$resident_exp="resident_exp".$n;
						$newdata=array(
									'org_id'=>$this->input->post('id'),
									'p_user'=>substr($this->input->post($first_name), 0, 1).substr($this->input->post($last_name), 0, 6),
									'p_first_name'=>$this->input->post($first_name),
									'p_last_name'=>$this->input->post($last_name),
									'p_password'=>$this->input->post($password),
									'year'=>$this->input->post($resident_exp),
									'patient_logs_data'=>$required_data,
									'status'=>'2'
									);
						$this->db->insert('patient_admin', $newdata);
					}
				}
				$test['info']="<font color=red>Resident information successfully added.</font>";
				$this->load->view("orgnization",$test);
			
		 
			}
			else
			{
				$this->load->view("orgnization");
			}
		}
	}
	
	
	
	
	public function deleteresident()
	{
		
		if($this->input->post('delete'))
		{
			$result=$this->user_model->delete_resident();
			if($result)
			{
				$test['info']="<font color=red>Resident successfully deleted.</font>";
				$this->load->view("resident_info",$test);	
			}
			else
			{
				$test['info']="<font color=red>Error.</font>";
				$this->load->view("resident_info",$test);		
			}
		}
		else
		{
				$this->load->view("resident_info");
		}
		
	}
	
	public function logout(){
		
	   $newdata = array(
		'id'   =>'',
		'org_id'=>'',
		'userid'   =>'',
		'p_first_name'=>'',
		'p_last_name'=>'',
		'year'   =>'',
		'status'   =>'',
		'validated' => FALSE
		);
		 
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
   		header('Cache-Control: post-check=0, pre-check=0', FALSE); 
    	header('Pragma: no-cache');
		redirect(base_url());
	 }
	 
	public function check_name()
	{
		
		$name=$this->input->post('name');
		$result=$this->org_model->chk_user($name);
		echo $result;
	}
	
	public function setting()
	{
		$this->load->view("change_password");
	}
	
	public function addnewentry()
	{
		$this->load->view("orgnization");
	}
	
	
	
	public function report()
	{
		$this->load->view("rotation_report");
	}
	
	public function graphreport()
	{
		$this->load->view("graph_report");
	}
	
	public function location()
	{
		$this->load->view("location");
	}
	
	public function rotation()
	{
		$this->load->view("rotation");
	}
	
	public function diagnosis()
	{
		$this->load->view("diagnosis");
	}
	
	public function adddiagnosis()
	{
		if($this->input->post('submit'))
		{
			$dgns=$this->input->post('diagnosis');
			
			foreach($dgns as $v)
			{
			$data=array(
			'orgnization_id'=>$this->input->post('id'),
			'diagnosis_name'=>$v
			);
			
			$this->db->insert('table_diagnosis', $data);
			}
			$test['information']="<font color=red>Diagnosis data Successfully added.</font>";
			$this->load->view("change_password",$test);
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function addlocation()
	{
		if($this->input->post('submit'))
		{
			$dgns=$this->input->post('location');
			
			foreach($dgns as $v)
			{
			$data=array(
			'orgnization_id'=>$this->input->post('id'),
			'location_name'=>$v
			);
			
			$this->db->insert('table_location', $data);
			}
			$test['infos']="<font color=red>Location data Successfully added.</font>";
			$this->load->view("change_password",$test);
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function addrotation()
	{
		if($this->input->post('submit'))
		{
			
			$i=$this->input->post('total');
			$data=array(
			'orgnization_id'=>$this->input->post('id'),
			'rotation_name'=>$this->input->post('rotation'),
			'rotation_year'=>$this->input->post('rotation_year')
			);
			$this->db->insert('table_rotation', $data);
			
			if($i!="0")
			{
				for($n=1;$n<=$i;$n++)
				{
					$rotation="rotation".$n;
					$rotation_year="rotation_year".$n;
					$newdata=array(
					'orgnization_id'=>$this->input->post('id'),
					'rotation_name'=>$this->input->post($rotation),
					'rotation_year'=>$this->input->post($rotation_year),
					);
					$this->db->insert('table_rotation', $newdata);
					
				}
			}
			
			
			$test['info']="<font color=red>Rotation data Successfully added.</font>";
			$this->load->view("change_password",$test);
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function deletelocation()
	{
		if($this->input->post('delete'))
		{
			$data=$this->user_model->delete_location();
			$this->load->view("change_password");
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function deleterotation()
	{
		if($this->input->post('delete'))
		{
			$data=$this->user_model->delete_rotation();
			$this->load->view("change_password");
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function deletediagnosis()
	{
		if($this->input->post('delete'))
		{
			$data=$this->user_model->delete_diagnosis();
			$this->load->view("change_password");
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	public function rotation_list()
	{
		$this->load->view("rotation_list");
	}
	public function rotation_report()
	{
		$this->load->view("rotation_report");
	}
	
	public function getsearchdata()
	{
		 $data['rid']=$this->input->post("rid");
		 $data['type']=$this->input->post("type");
		 $data['value']=$this->input->post("value");
		 return $this->load->view("ajax_perform",$data);

	}
	
	public function addnewencounter()
	{
		if($this->input->post('addcomment'))
		{
			$data=$this->user_model->add_new_encounter();
			redirect(base_url()."patients/patientlogs");
		}
		else
		{
			redirect(base_url()."patients/patientlogs");
		}
	}
	
	public function addnewdatetime()
	{
		if($this->input->post('addcomment'))
		{
			$data=$this->user_model->add_new_datetime();
			redirect(base_url()."patients/patientlogs");
		}
		else
		{
			redirect(base_url()."patients/patientlogs");
		}
	}
	
	public function addnewdiagnosis()
	{
		if($this->input->post('addcomment'))
		{
			$data=$this->user_model->add_new_diagnosis();
			redirect(base_url()."patients/patientlogs");
		}
		else
		{
			redirect(base_url()."patients/patientlogs");
		}
	}
	
	public function getdgns()
	{
		$data['rotation']=$this->input->post('rotation');
		return $this->load->view("ajax4",$data);
	}
	
	public function delete_record()
	{
		$pid=$this->input->post("pid");
		$this->db->where('patient_id', $pid);
        $this->db->delete('patient_logs');
		return $this->load->view("patient_logs");
		
	}
	
	public function addnewpatient()
	{
		$data['rotdata']=$this->input->post("rotdata");
		return $this->load->view("resident_add_entry",$data);
	}
}