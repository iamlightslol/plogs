<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Los_Angeles');
class User_model extends CI_Model {
    
  public function __construct(){
	parent::__construct();
		 $this->load->library('session');	
	}
	
	public function validate(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
        // Prep the query
        $this->db->where('p_user', $username);
        $this->db->where('p_password', $password);
        
        // Run the query
        $query = $this->db->get('patient_admin');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
			foreach ($query->result() as $v)
			{
				$status=$v->status;
			}
			if($status=='1')
			{
			
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
					'id'=> $row->p_id,
                    'userid' => $row->p_user,
					'status'=> $row->status,
                    'validated' => true
                    );
            $this->session->set_userdata($data);
            return "1";
			}
			else if($status=='2')
			{
				$row = $query->row();
            	$data = array(
                    'id'=> $row->p_id,
					'org_id'=>$row->org_id,
                    'userid' => $row->p_user,
					'p_first_name' => $row->p_first_name,
					'p_last_name' => $row->p_last_name,
					'year'=>$row->year,
					'status'=> $row->status,
                    'validated' => true
                    );
            $this->session->set_userdata($data);
            return "2";
			}
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
	
	
	
	public function chk_name($name)
	{
		$query = $this->db->get_where('patient_admin', array('p_user' =>$name));        
       if($query->num_rows()>0)
		{
		return "0";
		}else
		{
		return "1";
		}
	}
	
	
	public function add_patient_data()
	{
				
			$date=date("d/m/Y",strtotime($this->input->post('date')));
			$years=date("d/m/Y",strtotime($this->input->post('years')));
			$newdate=implode('/', array_reverse(explode('/', $date)));
			$newyears=implode('/', array_reverse(explode('/', $years)));
			$months=date("m",strtotime($newdate));
			$age=date("Y",strtotime($newyears));
			$age_in_year=date("Y",time())-$age;
			$orgnization_id=$this->input->post('org_id');
				
			$primary_diagnos=$this->input->post('primary_diagnos');
			$primary_diagnosis=$this->input->post('primary_diagnosis');
			$secondary_diagnos=$this->input->post('secondary_diagnos');
			$total=$this->input->post('total');
			
			if($primary_diagnos!=''){$new_primary_diagnos=$primary_diagnos;}
			
			else if($primary_diagnosis!='')
			{
				$query = $this->db->get_where('table_diagnosis', array('diagnosis_name' =>$primary_diagnosis,'orgnization_id'=>$orgnization_id));        
			    if($query->num_rows()<1)
				{
				  $newdata=array(
								'orgnization_id'=>$orgnization_id,
								'diagnosis_name'=>$primary_diagnosis
					);
			
					$this->db->insert('table_diagnosis', $newdata);
				}
				$new_primary_diagnos=$primary_diagnosis;
			}
			
			else{$new_primary_diagnos='';}
			
			if($secondary_diagnos!=''){$a=implode(", ", $secondary_diagnos); }
			
			else{$a="";}
			$scnd=$this->input->post('secondary_diagnoses0');
			for($i=0;$i<=$total;$i++)
			{
				$sec_diagnoses=$this->input->post('secondary_diagnoses'.$i);
				if($sec_diagnoses!='')
				{
				$query = $this->db->get_where('table_diagnosis', array('diagnosis_name' =>$sec_diagnoses,'orgnization_id'=>$orgnization_id));        
			    if($query->num_rows()<1)
					{
					  $newdata=array(
									'orgnization_id'=>$orgnization_id,
									'diagnosis_name'=>$sec_diagnoses
						);
				
						$this->db->insert('table_diagnosis', $newdata);
					}
					$scnd_dgns[]=$sec_diagnoses;
				}
			}
			if(@$scnd_dgns[0]!='' && $scnd!=''){$b=implode(", ", @$scnd_dgns); }
			
			else{$b="";}
			
			if($a!="" && $b!=""){$c=$a.",".$b;}
			
			else if($a!=''){$c=$a;}
			
			else if($b!=''){ $c=$b;}
			
			else{$c="";} 
			
			$data=array(
			'resident_id'=>$this->input->post('resident_id'),
			'resident_user'=>$this->input->post('resident_user'),
			'residency_year'=>$this->input->post('residency_year'),
			'org_id'=>$orgnization_id,
			'doj'=>$newdate,
			'fld_cur_time'=>$this->input->post('curnt_time'),
			'patient_number'=>$this->input->post('patient_number'),
			'patient_mrn'=>$this->input->post('patient_mrn'),
			'icd_code'=>$this->input->post('icd_code'),
			'months'=>$months,
			'years'=>$newyears,
			'age_in_year'=>$age_in_year,
			'patient_gender'=>$this->input->post('patient_gender'),
			'location'=>$this->input->post('location'),
			'rotation'=>$this->input->post('rotation'),
			'primary_diagnosis'=>$new_primary_diagnos,
			'p_system_name'=>$this->input->post('p_system_name'),
			'secondary_diagnoses'=>$c,
			's_system_name'=>$this->input->post('s_system_name'),
			'difficulty_of_case'=>$this->input->post('difficulty_of_case'),
			'supervisor'=>$this->input->post('supervisor'),
			'outcome'=>$this->input->post('outcome'),
			'procedure_performed'=>$this->input->post('procedure_performed'),
			'comments'=>$this->input->post('comments')
			);
			
			$this->db->insert('patient_logs', $data);
			
			return true;
			
	}
	
	public function add_new_encounter()
	{
		$resident_id=$this->input->post('resident_id');
		$patient_name=$this->input->post('patient_name');
		$current_time=$this->input->post('current_time');
		$curnt_date=$this->input->post('curnt_date');
		$comments=$this->input->post('comments');
		$months=date("m",strtotime($curnt_date));
		$this->db->where('resident_id', $resident_id);
		$this->db->where('patient_number', $patient_name);
		$this->db->order_by('patient_id', 'desc');
		$this->db->limit(1);
        $query = $this->db->get('patient_logs');
        foreach($query->result() as $row)
        {
			$resident_user=$row->resident_user;
			$residency_year=$row->residency_year;
			$org_id=$row->org_id;
			$patient_mrn=$row->patient_mrn;	
			$icd_code=$row->icd_code;
			$years=$row->years;
			$age_in_year=$row->age_in_year;
			$patient_gender=$row->patient_gender;	
			$location=$row->location;
			$rotation=$row->rotation;	
			$primary_diagnosis=$row->primary_diagnosis;
			$p_system_name=$row->p_system_name;
			$secondary_diagnoses=$row->secondary_diagnoses;
			$s_system_name=$row->s_system_name;
			$difficulty_of_case=$row->difficulty_of_case;
			$supervisor=$row->supervisor;
			$outcome=$row->outcome;
			$procedure_performed=$row->procedure_performed;				
		}
			
			$newdata=array(
			'resident_id'=>$resident_id,
			'resident_user'=>$resident_user,
			'residency_year'=>$residency_year,
			'org_id'=>$org_id,
			'doj'=>$curnt_date,
			'fld_cur_time'=>$current_time,
			'patient_number'=>$patient_name,
			'patient_mrn'=>$patient_mrn,
			'icd_code'=>$icd_code,
			'months'=>$months,
			'years'=>$years,
			'age_in_year'=>$age_in_year,
			'patient_gender'=>$patient_gender,
			'location'=>$location,
			'rotation'=>$rotation,
			'primary_diagnosis'=>$primary_diagnosis,
			'p_system_name'=>$p_system_name,
			'secondary_diagnoses'=>$secondary_diagnoses,
			's_system_name'=>$s_system_name,
			'difficulty_of_case'=>$difficulty_of_case,
			'supervisor'=>$supervisor,
			'outcome'=>$outcome,
			'procedure_performed'=>$procedure_performed,
			'comments'=>$comments
			);
			
			$this->db->insert('patient_logs', $newdata);
			
			return true;
	}
	
	
	public function add_new_datetime()
	{
		$patient_id=$this->input->post('patient_id');
		$resident_id=$this->input->post('resident_id');
		$current_date=date("d/m/Y",strtotime($this->input->post('current_date')));
		$newdate=implode('/', array_reverse(explode('/', $current_date)));
		$months=date("m",strtotime($newdate));
		$current_time=$this->input->post('current_time');
		$comments=$this->input->post('comments');
		$this->db->where('resident_id', $resident_id);
		$this->db->where('patient_id', $patient_id);
        $query = $this->db->get('patient_logs');
        foreach($query->result() as $row)
        {
			
			$resident_user=$row->resident_user;
			$residency_year=$row->residency_year;
			$org_id=$row->org_id;
			$patient_number=$row->patient_number;
			$patient_mrn=$row->patient_mrn;	
			$icd_code=$row->icd_code;
			$years=$row->years;
			$age_in_year=$row->age_in_year;
			$patient_gender=$row->patient_gender;	
			$location=$row->location;
			$rotation=$row->rotation;	
			$primary_diagnosis=$row->primary_diagnosis;
			$p_system_name=$row->p_system_name;
			$secondary_diagnoses=$row->secondary_diagnoses;
			$s_system_name=$row->s_system_name;
			$difficulty_of_case=$row->difficulty_of_case;
			$supervisor=$row->supervisor;
			$outcome=$row->outcome;
			$procedure_performed=$row->procedure_performed;				
		}
			
			$newdata=array(
			'resident_id'=>$resident_id,
			'resident_user'=>$resident_user,
			'residency_year'=>$residency_year,
			'org_id'=>$org_id,
			'doj'=>$newdate,
			'fld_cur_time'=>$current_time,
			'patient_number'=>$patient_number,
			'patient_mrn'=>$patient_mrn,
			'icd_code'=>$icd_code,
			'months'=>$months,
			'years'=>$years,
			'age_in_year'=>$age_in_year,
			'patient_gender'=>$patient_gender,
			'location'=>$location,
			'rotation'=>$rotation,
			'primary_diagnosis'=>$primary_diagnosis,
			'p_system_name'=>$p_system_name,
			'secondary_diagnoses'=>$secondary_diagnoses,
			's_system_name'=>$s_system_name,
			'difficulty_of_case'=>$difficulty_of_case,
			'supervisor'=>$supervisor,
			'outcome'=>$outcome,
			'procedure_performed'=>$procedure_performed,
			'comments'=>$comments
			);
			
			$this->db->insert('patient_logs', $newdata);
			
			return true;
	}
	
	
	public function add_new_diagnosis()
	{
		
		$patient_name=$this->input->post('patient_name');
		$resident_id=$this->input->post('resident_id');
		$orgnization_id=$this->input->post('org_id');	
		$primary_diagnos=$this->input->post('primary_diagnos');
		$primary_diagnosis=$this->input->post('primary_diagnosis');
		$secondary_diagnos=$this->input->post('secondary_diagnos');
		$scnd=$this->input->post('secondary_diagnoses0');
		$total=$this->input->post('total');
		$this->db->where('resident_id', $resident_id);
		$this->db->where('patient_number', $patient_name);
		$this->db->order_by('patient_id', 'desc');
		$this->db->limit(1);
        $query = $this->db->get('patient_logs');
        foreach($query->result() as $row)
        {	
			$pmrdgns=$row->primary_diagnosis;
			$scndgns=$row->secondary_diagnoses;			
		}
			
		if($primary_diagnos!='' || $primary_diagnosis!='')
		{
			if($primary_diagnos!=''){$new_primary_diagnos=$primary_diagnos;}
				
				else if($primary_diagnosis!='')
				{
					$query = $this->db->get_where('table_diagnosis', array('diagnosis_name' =>$primary_diagnosis,'orgnization_id'=>$orgnization_id));        
					if($query->num_rows()<1)
					{
					  $newdata=array(
									'orgnization_id'=>$orgnization_id,
									'diagnosis_name'=>$primary_diagnosis
						);
				
						$this->db->insert('table_diagnosis', $newdata);
					}
					$new_primary_diagnos=$primary_diagnosis;
				}
				
				$data = array(
           		'primary_diagnosis' => $new_primary_diagnos
        			);
				$this->db->where('resident_id', $resident_id);
				$this->db->where('patient_number', $patient_name);
				$this->db->update('patient_logs', $data); 
		}
			
			if($secondary_diagnos!='' || $scnd!='')
			{
				if($secondary_diagnos!=''){$a=implode(", ", $secondary_diagnos);}
				else{$a="";};
				
				
				for($i=0;$i<=$total;$i++)
				{
					$sec_diagnoses=$this->input->post('secondary_diagnoses'.$i);
					if($sec_diagnoses!='')
					{
					$query = $this->db->get_where('table_diagnosis', array('diagnosis_name' =>$sec_diagnoses,'orgnization_id'=>$orgnization_id));        
					if($query->num_rows()<1)
						{
						  $newdata=array(
										'orgnization_id'=>$orgnization_id,
										'diagnosis_name'=>$sec_diagnoses
							);
					
							$this->db->insert('table_diagnosis', $newdata);
						}
						$scnd_dgns[]=$sec_diagnoses;
					}
				}
				if($scnd_dgns[0]!='' && $scnd!=''){$b=implode(", ", $scnd_dgns); }
				else{$b="";}
				
				if($a!="" && $b!=""){$c=$a.",".$b;}
				
				else if($a!=''){$c=$a;}
				
				else if($b!=''){ $c=$b;}
				
				
				$data = array(
           		'secondary_diagnoses' =>$scndgns.",".$c
        			);
				$this->db->where('resident_id', $resident_id);
				$this->db->where('patient_number', $patient_name);
				$this->db->update('patient_logs', $data);
			
			}		
		
	}
	
	public function get_total_patients($id)
	{
		
		$this->db->where('resident_id', $id);
        $query = $this->db->get('patient_logs');
        return $query->num_rows;
		
	}
	public function get_patient_detail($id,$limit,$start)
	{
		
		$this->db->where('resident_id', $id);
		$this->db->order_by('doj', 'desc');
		$this->db->limit($limit,$start);
        $query = $this->db->get('patient_logs');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
	}
	
	public function get_unique_date($r_id)
			{
				
				$this->db->distinct();
				$this->db->select('doj');  
   				$this->db->from('patient_logs');
				$this->db->where('resident_id',$r_id);  
  				$this->db->order_by('doj', 'desc'); 
   				$query=$this->db->get();
				if($query->num_rows>0)
				{
					return $query->result();
				}
				
			}
	public function get_distinct_name($id,$date)
	{
				$this->db->distinct();
				$this->db->select('patient_number');  
   				$this->db->from('patient_logs');
				$this->db->where('resident_id',$id);  
  				$this->db->where('doj', $date);
				$this->db->order_by('patient_id', 'desc');
   				$query=$this->db->get();
				return $query->result();
				
	}
	
	public function get_total_encounter_data($id,$date,$name)
	{
		if($name!=''){
		$this->db->where('resident_id', $id);
		$this->db->where('doj', $date);
		$this->db->where('patient_number', $name);
        $query = $this->db->get('patient_logs');
		return $query->num_rows;
		}
		else
		{
		$this->db->where('resident_id', $id);
		$this->db->where('doj', $date);
        $query = $this->db->get('patient_logs');
		return $query->num_rows;
		}
	}
	
	public function get_patient_detail_according_date($id,$name,$date)
	{
		
		$this->db->where('resident_id', $id);
		$this->db->where('patient_number', $name);
		$this->db->where('doj', $date);
		$this->db->order_by('patient_id', 'desc');
		$this->db->limit(1);
        $query = $this->db->get('patient_logs');
			return $query->result();
	}
	
	public function get_remaining_data($id,$name,$date,$limit)
	{
		
		$this->db->where('resident_id', $id);
		$this->db->where('patient_number', $name);
		$this->db->where('doj', $date);
		$this->db->order_by('patient_id', 'desc');
   		$this->db->limit($limit,'1');
        $query = $this->db->get('patient_logs');
			return $query->result();
	}
	
	public function get_search_result_data($rid,$type,$value)
	{
		
		$this->db->where('resident_id', $rid);
		$this->db->where($type, $value);
		$this->db->order_by('patient_id', 'desc');
        $query = $this->db->get('patient_logs');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
	}
	
	public function get_total_search_result_data($rid,$type,$value)
	{
		
		$this->db->where('resident_id', $rid);
		$this->db->where($type, $value);
        $query = $this->db->get('patient_logs');
		return $query->num_rows;
	}
	
	public function get_all_data($rid)
	{
		
		$this->db->where('p_id', $rid);
        $query = $this->db->get('patient_admin');
		return $query->result();
		
	}
	
	public function get_resident_detail($id,$limit,$start)
	{
		$this->db->where('org_id', $id);
		$this->db->limit($limit, $start);
        $query = $this->db->get('patient_admin');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
	}
	
	function get_total_resident($id)
    {             
        $this->db->where('org_id', $id);
        $query = $this->db->get('patient_admin');
		return $query->num_rows;
    } 
	
	public function get_user_data($username)
	{
		$this->db->where('p_user', $username);
        $query = $this->db->get('patient_admin');
        // Let's check if there are any results
        if($query->num_rows>0)
        {
			foreach ($query->result() as $v)
			{
				return $v->p_password;
			}
		}
	}
	
	public function change_pwd($pwd,$uname)
	{
		$data = array(
               'p_password' => $pwd
            );
		$this->db->where('p_user', $uname);
		$this->db->update('patient_admin', $data); 
		return true;
	}
	
	public function delete_resident()
	{
		$checked_messages = $this->input->post('check');
		if($checked_messages!=''):
		foreach ($checked_messages as $msg_id):
			$this->db->where('p_id', $msg_id);
			$this->db->delete('patient_admin');  

   		 endforeach;endif;
		 return true;
	}
	
	
	public function delete_location()
	{
		$checked_messages = $this->input->post('check');
		if($checked_messages!=''):
		foreach ($checked_messages as $msg_id):
       
			$data = array(
               'status' =>"0"
            );
			$this->db->where('location_id', $msg_id);
			$this->db->update('table_location', $data); 

   		 endforeach;endif;
	}
	
	public function delete_rotation()
	{
		$checked_messages = $this->input->post('check');
		if($checked_messages!=''):
		foreach ($checked_messages as $msg_id):
			$data = array(
               'status' =>"0"
            );
			$this->db->where('rotation_id', $msg_id);
			$this->db->update('table_rotation', $data); 

   		 endforeach;endif;
	}
	
	public function delete_diagnosis()
	{
		$checked_messages = $this->input->post('check');
		if($checked_messages!=''):
		foreach ($checked_messages as $msg_id):
			$data = array(
               'status' =>"0"
            );
			$this->db->where('diagnosis_id', $msg_id);
			$this->db->update('table_diagnosis', $data); 


   		 endforeach;endif;
	}
	
	
	
	
}
?>