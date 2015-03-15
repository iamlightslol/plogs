<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Report_model extends CI_Model {
    
	
	
  public function __construct(){
	parent::__construct();
		 $this->load->library('session');	
	}
	
	public function get_res_patient_detail($userid)
	{
		
		$this->db->where('resident_id', $userid);
		//$this->db->where('doj', "%".$month.'%');
        $query = $this->db->get('patient_logs');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
	}
	
	public function get_resident_data($id)
	{
		
		$this->db->where('p_id', $id);
        $query = $this->db->get('patient_admin');
     
			return $query->result();
	}
	
	/*public function get_resident_detail($username)
	{
		$this->db->where('org_id', $username);
        $query = $this->db->get('patient_admin');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
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
	}*/
	
	
	public function get_gender_data($userid,$gender,$res_year)
	{
		$this->db->distinct();
		$this->db->select('patient_unique_id');
		$this->db->where('resident_id', $userid);
		/*$this->db->where('residency_year', $res_year);*/
		$this->db->where('patient_gender',$gender);
        $query = $this->db->get('patient_logs');
     
        
			return $query->num_rows;
		
	}
	
	public function get_prmy_dgns_data($userid,$dignosis)
	{
		$this->db->distinct();
		$this->db->select('patient_unique_id');
		$this->db->where('resident_id', $userid);
		$this->db->where('primary_diagnosis',$dignosis);
        $query = $this->db->get('patient_logs');
     
        
			return $query->num_rows;
		
	}
	
	public function get_monthly_data($userid,$months)
	{
		
		$this->db->where('resident_id', $userid);
		$this->db->where('months',$months);
        $query = $this->db->get('patient_logs');
     
        
			return $query->num_rows;
		
	}
	
	public function get_rotaion_list($org_id)
	{
		$this->db->where('orgnization_id', $org_id);
		$this->db->where('status', "1");
        $query = $this->db->get('table_rotation');
     
        if($query->num_rows>0)
        {
			return $query->result();
		}
	}
	
	public function get_dignosis_list($rid,$type,$rotation,$top,$res_year)
	{
		if($rotation!=''){
		$query = $this->db->select('primary_diagnosis, COUNT(primary_diagnosis) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
				  ->where($type, $rotation)
                  ->group_by('primary_diagnosis')
				  ->order_by('count','desc')
				  ->limit("20")
                  ->get()->result();
			return $query;
		}
		else if($top!="")
		{
			$query = $this->db->select('primary_diagnosis, COUNT(primary_diagnosis) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
				  ->group_by('primary_diagnosis')
				  ->order_by('count','desc')
				  ->limit("10")
                  ->get()->result();
			return $query;
		}
		else
		{
			$query = $this->db->select('primary_diagnosis, COUNT(primary_diagnosis) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
                  ->group_by('primary_diagnosis')
				  ->order_by('count','desc')
				  ->limit("20")
                  ->get()->result();
			return $query;
		}
	
	}
	
	public function get_dignosis_list_for_report($rid,$type,$rotation,$res_year)
	{
		if($rotation!=''){
		$query = $this->db->select('primary_diagnosis, COUNT(primary_diagnosis) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
				  ->where($type, $rotation)
                  ->group_by('primary_diagnosis')
				  ->order_by('count','desc')
                  ->get()->result();
			return $query;
		}
		else
		{
			$query = $this->db->select('primary_diagnosis, COUNT(primary_diagnosis) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
                  ->group_by('primary_diagnosis')
				  ->order_by('count','desc')
                  ->get()->result();
			return $query;
		}
	
	}
	
	public function get_rotation_for_report($rid,$res_year)
	{
		
		$query = $this->db->select('rotation, COUNT(rotation) AS total')
                  ->from('patient_logs')
				  ->where('resident_id', $rid)
				  /*->where('residency_year', $res_year)*/
                  ->group_by('rotation')
				  ->order_by('total','desc')
                  ->get()->result();
			return $query;
	}
	
	public function total_unique_diagnosis($rid,$res_year,$dgns,$type,$value)
	{
		if($type!='' && $value!=''){
		$sql='SELECT patient_unique_id
		FROM patient_logs where resident_id="'.$rid.'" and '.$type.'="'.$value.'" and primary_diagnosis="'.$dgns.'"  group by patient_unique_id';
		$res=$this->db->query($sql);
		return $res->num_rows();
		}
		else{
		$sql='SELECT patient_unique_id
		FROM patient_logs where resident_id="'.$rid.'" and primary_diagnosis="'.$dgns.'"  group by patient_unique_id';
		$res=$this->db->query($sql);
		return $res->num_rows();
		}
	}
	
	public function get_diffculty_of_case($id,$rotation)
	{
				
			$sql='SELECT avg(difficulty_of_case) as aver FROM patient_logs where resident_id="'.$id.'" and primary_diagnosis="'.$rotation.'"';
			$res=$this->db->query($sql);
			foreach($res->result() as $v){
			return $v->aver;
			}
		
	}
	
	public function get_top10_rotation($id,$residency_year)
	{
		
		$query = $this->db->select('rotation, COUNT(rotation) AS count')
                  ->from('patient_logs')
				  ->where('resident_id', $id)
				  /*->where('residency_year', $residency_year)*/
                  ->group_by('rotation')
				  ->order_by('count','desc')
				  ->limit("10")
                  ->get()->result();
			return $query;
	}
	
	
	public function total_male($rid,$type,$val,$res_year)
	{
		if($val!="")
		{
			$this->db->distinct();
			$this->db->select('patient_unique_id');
			$this->db->where('resident_id', $rid);
		    $this->db->where($type, $val);
			$this->db->where('patient_gender',"male");
			/*$this->db->where('residency_year',$res_year);*/
			$query = $this->db->get('patient_logs');
			return $query->num_rows();
		}
		else
		{
			$this->db->distinct();
			$this->db->select('patient_unique_id');
			$this->db->where('resident_id', $rid);
			$this->db->where('patient_gender',"male");
			/*$this->db->where('residency_year',$res_year);*/
			$query = $this->db->get('patient_logs');
			return $query->num_rows();
		}
		
	}
	
	
	public function total_female($rid,$type,$val,$res_year)
	{
		if($val!="")
		{
			$this->db->distinct();
			$this->db->select('patient_unique_id');
			$this->db->where('resident_id', $rid);
		    $this->db->where($type, $val);
			$this->db->where('patient_gender',"female");
			/*$this->db->where('residency_year',$res_year);*/
			$query = $this->db->get('patient_logs');
			return $query->num_rows();
		}
		else
		{
			$this->db->distinct();
			$this->db->select('patient_unique_id');
			$this->db->where('resident_id', $rid);
			$this->db->where('patient_gender',"female");
			/*$this->db->where('residency_year',$res_year);*/
			$query = $this->db->get('patient_logs');
			return $query->num_rows();
		}
		
	}
	
	public function total_roation_patient($id,$type,$rotation,$res_year)
	{
		if($rotation!=''){	
		$this->db->where('resident_id', $id);
		/*$this->db->where('residency_year', $res_year);*/
		$this->db->where($type, $rotation);
        $query = $this->db->get('patient_logs');
     
			return $query->num_rows;
		}
		
		else
		{
			$this->db->where('resident_id', $id);
			/*$this->db->where('residency_year', $res_year);*/
        	$query = $this->db->get('patient_logs');
     
			return $query->num_rows;
		}
	
		
	}
	
	public function total_roation_patient1($id,$type,$rotation,$res_year)
	{
		$this->db->distinct();
		$this->db->select('patient_unique_id');	
		$this->db->where('resident_id', $id);
		/*$this->db->where('residency_year', $res_year);*/
		$this->db->where($type, $rotation);
        $query = $this->db->get('patient_logs');
     
			return $query->num_rows;
	}
	
	
	public function total__distinct_patient($id,$type,$rotation,$res_year)
	{
		if($rotation!=''){
		$this->db->distinct();
		$this->db->select('patient_unique_id');	
		$this->db->where('resident_id', $id);
		/*$this->db->where('residency_year', $res_year);*/
		$this->db->where($type, $rotation);
        $query = $this->db->get('patient_logs');
     
			return $query->num_rows;
		}
		
		else
		{
			$this->db->distinct();
			$this->db->select('patient_unique_id');
			$this->db->where('resident_id', $id);
			/*$this->db->where('residency_year', $res_year);*/
        	$query = $this->db->get('patient_logs');
     
			return $query->num_rows;
		}
	
		
	}
	
	public function get_age_data($id,$no,$end,$res_year)
	{
		
		$this->db->distinct();
		$this->db->select('patient_unique_id');
		$this->db->where('resident_id',$id);
		/*$this->db->where('residency_year',$res_year);*/
		$this->db->where("age_in_year BETWEEN ".$no." AND ".$end);  
        $query = $this->db->get('patient_logs');
		return $query->num_rows;
		
	}
	
	public function min_date($id,$type,$rotation,$res_year)
	{
		if($rotation!=''){
			$sql="SELECT max(age_in_year)as maxi FROM patient_logs where resident_id='".$id."' and ".$type."='".$rotation."'";
			$res=$this->db->query($sql);
			foreach($res->result() as $v){
			return $v->maxi;
			}
		}
		else
		{
			$sql="SELECT max(age_in_year)as maxi FROM patient_logs where resident_id='".$id."'";
			$res=$this->db->query($sql);
			foreach($res->result() as $v){
			return $v->maxi;
			}
		}
	}
	
	public function max_date($id,$type,$rotation,$res_year)
	{
		if($rotation!=''){
			$sql="SELECT min(age_in_year)as mini FROM patient_logs where resident_id='".$id."' and ".$type."='".$rotation."'";
			$res=$this->db->query($sql);
			foreach($res->result() as $v){
			return $v->mini;
			}
		}
		else
		{
			$sql="SELECT min(age_in_year)as mini FROM patient_logs where resident_id='".$id."'";
			$res=$this->db->query($sql);
			foreach($res->result() as $v){
			return $v->mini;
			}
		}
	}
	
	public function from_date($id,$rotation,$res_year)
	{
		$sql="SELECT min(doj)as mini FROM patient_logs where resident_id='".$id."' and rotation='".$rotation."'";
		$res=$this->db->query($sql);
		foreach($res->result() as $v){
		return $v->mini;
		}
	}
	
	public function to_date($id,$rotation,$res_year)
	{
		$sql="SELECT max(doj)as mini FROM patient_logs where resident_id='".$id."' and rotation='".$rotation."'";
		$res=$this->db->query($sql);
		foreach($res->result() as $v){
		return $v->mini;
		}
	}
	
	public function age_group($rid,$type,$value,$ryear,$age,$age1)
	{
		if($type!='' && $age!='' && $age1!=''){
			$query=$this->db->query("SELECT patient_unique_id 
	FROM patient_logs where resident_id='".$rid."' and ".$type."='".$value."' and age_in_year between ".$age." and ".$age1." group by patient_unique_id");
			return $query->num_rows();
		}
		else if($type!='' && $age!='' && $age=='65'){
			$query=$this->db->query("SELECT patient_unique_id 
	FROM patient_logs where resident_id='".$rid."' and ".$type."='".$value."' and age_in_year >=".$age." group by patient_unique_id");
			
				return $query->num_rows();
			
		}
		else if($age!='' && $age=='65'){
			$query=$this->db->query("SELECT patient_unique_id 
	FROM patient_logs where resident_id='".$rid."' and  age_in_year >='".$age."' group by patient_unique_id");
			
				return $query->num_rows();
			
		}
		else
		{
			$query=$this->db->query("SELECT patient_unique_id 
FROM `patient_logs` where resident_id='".$rid."' and  age_in_year between ".$age." and ".$age1." group by patient_unique_id");
			return $query->num_rows();
		}
	}
	
	
	
	 
	 public function scndary_diagnosis_for_report($id,$org_id,$year,$type,$output){
			
			
			 $this->db->where('orgnization_id', $org_id);
			 $this->db->where('status', '1');
			 $res = $this->db->get('table_diagnosis');
			 	if($type!='' && $output!='')
				{
					if($res->num_rows >0)
					{
						foreach($res->result() as $v)
						{
							$query=$this->db->query('SELECT patient_unique_id FROM patient_logs where '.$type.'="'.$output.'" and  
	resident_id="'.$id.'"  
	and secondary_diagnoses like "%'.$v->diagnosis_name.'%" group by patient_unique_id');
							
									$arr2[]=$query->num_rows();
									
									
									$arr1[]=$v->diagnosis_name;
									
							}
							
						
						
						$new_array_result = array_combine($arr1, $arr2);
						arsort($new_array_result);
						return $new_array_result;
					}
				}
				else 
				{
					if($res->num_rows >0)
					{
						foreach($res->result() as $v)
						{
							$query=$this->db->query('SELECT patient_unique_id
		FROM patient_logs where resident_id="'.$id.'" and secondary_diagnoses like "%'.$v->diagnosis_name.'%" group by patient_unique_id');
									$arr2[]=$query->num_rows();
								
									$arr1[]=$v->diagnosis_name;
									
							}
							
						
						
						$new_array_result = array_combine($arr1, $arr2);
						arsort($new_array_result);
						return $new_array_result;
						}
						
					
				}
	 }
	 
	
	
}
?>