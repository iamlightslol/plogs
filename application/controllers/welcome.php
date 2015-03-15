<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Canada/Eastern');
class Welcome extends CI_Controller {


public function __construct()
	{
		parent::__construct();
		 $this->load->library('session');  //Load the Session 
		$this->load->model('user_model');
		$this->load->model('org_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	/*public function index()
	{
		$this->load->view('login');
	}*/
	
	
	public function index($msg = NULL){
      
        $data['msg'] = $msg;
        $this->load->view('login', $data);
    }
	
	
	public function welcome()
	{
		
		$this->load->view("registration_view");
	}
	
    
    public function login(){
		
        $result = $this->user_model->validate();
		
        
        if(! $result){
           
            $msg = '<font color=red>Invalid username and/or password.</font><br />';
            $this->index($msg);
        }else if($result=='1'){
           
            redirect('dashboard');
        }
		else if($result=='2'){
           redirect('patients');
            
        }       
    }
	
	
	
	
	
	

	
	
	public function addpatientdata()
	{
			if($this->input->post('submit'))
			{
				$rotdata=$this->input->post('rotation');
				$locdata=$this->input->post('location');
				$result=$this->user_model->add_patient_data();
				if($result)
				{
					$test['rotdata']=$rotdata;
					$test['locdata']=$locdata;
					$test['info']="Patient information successfully added";
					$this->load->view("patient_logs",$test);
				}
				else
				{
					$test['rotdata']=$rotdata;
					$test['locdata']=$locdata;
					$test['info']="Failed....";
					$this->load->view("patient_logs",$test);
				}
			}
			else
			{
				$this->load->view("patient_logs");
			}
	}
	
	public function check_user()
	{
		$name=$this->input->post('name');
		$result=$this->user_model->chk_name($name);
		echo $result;
	}
	
	public function getcurrentage()
	{
		$date=$this->input->post('curdate');
		$age=date("d/m/Y",strtotime($date));
		$newage=implode('/', array_reverse(explode('/',$age)));
		$Year=date("Y",strtotime($newage));
		$month=date("m",strtotime($newage));
		$day=date("d",strtotime($newage));
		$newyear=date("Y",time())-$Year;
		$newmonth=date("m",time())-$month;
		$newday=date("d",time())-$day;
		if($newday==0){$curday="1";}
		else{$curday=$newday;}
		if($newyear=="0" && $newmonth=="0"){echo $dob="Age:".$curday." Day Old";}
		else if($newyear!="0"){echo $dob="Age:".$newyear." Year Old";}
		else if($newyear=="0"){echo $dob="Age:".$newmonth." Month Old";}
		else if($newmonth=="0"){echo $dob="Age:".$curday." Day Old";}

	}
	
	public function logs()
	{
		
		$this->load->view("patient_logs_detail");
	}
	
	public function getpdiagnosis1()
	{
		$rotation=$this->input->post('rotation');
		$data['rotation']=$rotation;
		echo $this->load->view("ajax1",$data);
	}
	
	public function getpdiagnosis2()
	{
		
		$rotation=$this->input->post('rotation');
		$data['rotation']=$rotation;
		echo $this->load->view("ajax2",$data);
	}
	
	public function changepassword()
	{
		if($this->input->post('submit')){
			$newpwd=$this->input->post('new_password');
			$uname=$this->input->post('username');
			$result=$this->user_model->change_pwd($newpwd,$uname);
			if($result)
			{
				$data['msg']='<font color=red>Password Successfully changed.</font><br />';
				
				$this->load->view("change_password",$data);
			}
			else
			{
				$this->load->view("change_password");
			}
		}
		else
		{
			$this->load->view("change_password");
		}
	}
	
	function get_pdgns_datas()
	{
		
    	$keyword = $this->input->post('term');
 
		$data['response'] = 'false'; //Set default response
 
		$query = $this->org_model->get_pdgns_data($keyword); //Model DB search
 
		if($query->num_rows() > 0){
		$data['response'] = 'true'; //Set response
		$data['message'] = array(); //Create array
		foreach($query->result() as $row){
		$data['message'] =$row->diagnosis_name; //Add a row to array
		}
		}
		echo json_encode($data);
 
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */