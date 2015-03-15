<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    date_default_timezone_set('Canada/Eastern');
	class Org_model extends CI_Model
    {   
	public function __construct(){
	parent::__construct();
		 $this->load->library('session');
	}
	
        function signup()
        {
            $OrgName = $this->input->post('org_name');
            $OrgUsrName = $this->input->post('org_user_username');
			$OrgUsrPwd = $this->input->post('org_repassword');
			$Price = $this->input->post('price');
            $data = array(
					'organization_name'=>$OrgName,
					'p_user'=>$OrgUsrName,
					'p_password'=>$OrgUsrPwd,
					'org_price'=>$Price,
					'status'=>'1',                    
                    );
             $res= $this->db->insert('patient_admin',$data);
			 if($res){
				 return true;
				 }    
            }
			
			
			function get_patent_field($uname)
			{
				$this->db->where('p_user', $uname);
				$query = $this->db->get('patient_admin');
				if($query->num_rows == 1)
				{
					foreach ($query->result() as $v)
					{
						$data['org_id']=$v->org_id;
						$data['year']=$v->year;
						$data['patient_logs_data']=$v->patient_logs_data;
					}
					return $data;
				}
			}
			
			function get_location_field($id)
			{
				$this->db->where('orgnization_id', $id);
				$this->db->where('status', '1');
				$this->db->order_by('location_id','desc');
				$res = $this->db->get('table_location ');
				if($res->num_rows >0)
				{
					return $res->result();
				}
			}
			
			function get_rotation_field($id)
			{
				$this->db->where('orgnization_id', $id);
				$this->db->where('status', '1');
				$this->db->order_by('rotation_id','desc');
				$res = $this->db->get('table_rotation ');
				if($res->num_rows >0)
				{
					return $res->result();
				}
			}
			
			
			function get_diagnosis_field($id,$limit, $start)
			{
				$this->db->where('orgnization_id', $id);
				$this->db->where('status', '1');
				$this->db->order_by('diagnosis_id','desc');
				$this->db->limit($limit, $start);
				$res = $this->db->get('table_diagnosis ');
				if($res->num_rows >0)
				{
					return $res->result();
				}
			}
			
			function get_total_dgns_filed($id)
			{
				$this->db->where('orgnization_id', $id);
				$this->db->where('status', '1');
				$res = $this->db->get('table_diagnosis');
				return $res->num_rows;
			}
			
			
			function get_rotation_data($id)
			{
				$this->db->where('p_id', $id);
				$query = $this->db->get('patient_admin');
				if($query->num_rows>0)
				{
					foreach ($query->result() as $v)
					{
						$orgid=$v->org_id;
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('status', '1');
						$this->db->order_by('rotation_id', 'asc');
						$res = $this->db->get('table_rotation');
						if($res->num_rows >0)
						{
							return $res->result();
						}
						
					}
					
				}
			}
			
			function get_yearly_rotation_data($orgid,$year)
			{
				
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('rotation_year', $year);
						$this->db->where('status', '1');
						$this->db->order_by('rotation_id', 'asc');
						$res = $this->db->get('table_rotation');
						if($res->num_rows >0)
						{
							return $res->result();
						}		
			}
			
			function get_srotation_data($orgid,$res_year)
			{
				
						
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('rotation_year', $res_year);
						$this->db->where('status', '1');
						$this->db->order_by('rotation_id', 'asc');
						$this->db->limit(1);
						$res = $this->db->get('table_rotation');
						if($res->num_rows >0)
						{
							foreach($res->result() as $row)
							{
								return $row->rotation_name;
							}
						}
						
				
			}
			
			function get_rotation_data1($id)
			{
				
						$this->db->where('orgnization_id', $id);
						$this->db->where('status', '1');
						$res = $this->db->get('table_rotation');
						if($res->num_rows >0)
						{
							return $res->result();
						}
			}
			
			function get_rotation_data2($id,$residency_year)
			{
				
				$this->db->distinct();
				$this->db->select('rotation');  
   				$this->db->from('patient_logs');
				$this->db->where('resident_id',$id);  
  				/*$this->db->where('residency_year',$residency_year);*/
   				$query=$this->db->get();
				return $query->result();
	
			}
			
			function get_dignosis_data2($id,$residency_year)
			{
				
				$this->db->distinct();
				$this->db->select('primary_diagnosis');  
   				$this->db->from('patient_logs');
				$this->db->where('resident_id',$id);  
  				/*$this->db->where('residency_year',$residency_year);*/
   				$query=$this->db->get();
				return $query->result();
	
			}
			
			
			function get_dignosis_data($id)
			{
				$this->db->where('p_id', $id);
				$query = $this->db->get('patient_admin');
				if($query->num_rows>0)
				{
					foreach ($query->result() as $v)
					{
						$orgid=$v->org_id;
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('status', '1');
						$this->db->limit(20);
						$res = $this->db->get('table_diagnosis ');
						if($res->num_rows >0)
						{
							return $res->result();
						}
						
					}
					
				}
			}
			
			function get_all_dignosis_data($id)
			{
				$this->db->where('p_id', $id);
				$query = $this->db->get('patient_admin');
				if($query->num_rows>0)
				{
					foreach ($query->result() as $v)
					{
						$orgid=$v->org_id;
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('status', '1');
						$res = $this->db->get('table_diagnosis ');
						if($res->num_rows >0)
						{
							return $res->result();
						}
						
					}
					
				}
			}
			
			function get_all_rotation_dignosis_data($org_id,$rotation,$year)
			{
				
				$this->db->distinct();
				$this->db->select('primary_diagnosis');  
   				$this->db->from('patient_logs');
				$this->db->where('org_id',$org_id);  
  				$this->db->where('rotation',$rotation);
				/*$this->db->where('residency_year',$year);*/
				$this->db->limit(20);  
   				$query=$this->db->get();
				return $query->result();
		
				
				
			}
			
			function get_all_rotation_dignosis_data1($org_id,$rotation,$year)
			{
				
				$this->db->distinct();
				$this->db->select('primary_diagnosis');  
   				$this->db->from('patient_logs');
				$this->db->where('org_id',$org_id);  
  				$this->db->where('rotation',$rotation);
				/*$this->db->where('residency_year',$year);*/
				$this->db->limit(20);  
   				$query=$this->db->get();
				return $query->result();	
				
				
			}
			
			function get_all_dignosis_data1($rotation)
			{
				$this->db->distinct();
				$this->db->select('primary_diagnosis');  
   				$this->db->from('patient_logs');  
  				$this->db->where('rotation',$rotation);
				$this->db->limit(20);  
   				$query=$this->db->get();
				return $query->result();
				
			}
			
			function get_dignosis_data1($id)
			{
				
						$this->db->where('orgnization_id', $id);
						$this->db->where('status', '1');
						$res = $this->db->get('table_diagnosis ');
						if($res->num_rows >0)
						{
							return $res->result();
						}
			}
			
			function get_location_data($id)
			{
				$this->db->where('p_id', $id);
				$query = $this->db->get('patient_admin');
				if($query->num_rows>0)
				{
					foreach ($query->result() as $v)
					{
						$orgid=$v->org_id;
						$this->db->where('orgnization_id', $orgid);
						$this->db->where('status', '1');
						$res = $this->db->get('table_location ');
						if($res->num_rows >0)
						{
							return $res->result();
						}
						
					}
					
				}
			}
			
			function get_location_data1($id)
			{
				
						$this->db->where('orgnization_id', $id);
						$this->db->where('status', '1');
						$res = $this->db->get('table_location ');
						if($res->num_rows >0)
						{
							return $res->result();
						}
					
			}
			
			
			function chk_user($name)
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
			
			
		  public function get_pdgns_data($keyword)
		  {
			$this->db->select('diagnosis_name');
			$this->db->from('table_diagnosis');
			$this->db->like('diagnosis_name', $keyword);
			$this->db->order_by("diagnosis_name", "asc");
			 
			$query = $this->db->get();
			foreach($query->result_array() as $row){
			//$data[$row['friendly_name']];
			$data[] = $row;
			}
			//return $data;
			return $query;
		  }
		  
public function scndary_diagnosis($org_id,$rotation,$year){
			  
			 $this->db->where('orgnization_id', $org_id);
			 $this->db->where('status', '1');
			 $res = $this->db->get('table_diagnosis');
			if($res->num_rows >0)
			{
				foreach($res->result() as $v)
				{
					$query=$this->db->query('SELECT count(secondary_diagnoses)as total
FROM patient_logs where rotation="'.$rotation.'" and org_id="'.$org_id.'" and secondary_diagnoses like "%'.$v->diagnosis_name.'%"');
					if($query->num_rows >0)
					{
						$total=$query->num_rows;
						foreach($query->result() as $value)
							{
								$arr2[]=$value->total;
							}
							
							$arr1[]=$v->diagnosis_name;
							
					}
					
				}
				
				$new_array_result = array_combine($arr1, $arr2);
				arsort($new_array_result);
				foreach($new_array_result as $key=>$val)
				{
					if($val!='0'){
						
					$new_res[]=$key;	 
					}
				}
				return @array_slice(@$new_res,0,20);	
				
				
			}
	 }
				 
}
?>
