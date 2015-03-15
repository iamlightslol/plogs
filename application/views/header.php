<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Patient Logs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
	
</head>

<body>

  <div id="wrap">
  <div id="regbar">
  <div class="right">
  <!--<p>Patient-logs<span>.com</span></p>
  <p class="cc">Customize your web presence</p>-->
  </div>
 <?php  if(@$this->session->userdata['userid']!=''){
	 
	 	if(@$this->session->userdata['status']=='1'){ ?>
        
 <div class="left">Welcome,<?php echo ucfirst($this->session->userdata['userid']); ?><br>
 <ul>
 <li>
 <a href="<?php echo base_url();?>dashboard/addnewentry">Add New Resident</a>&nbsp;|&nbsp;</li>
 <li><a href="<?php echo base_url();?>dashboard/residentinfo">View Resident</a>&nbsp;|&nbsp;</li>
 <!--<li><a href="<?php //echo base_url();?>dashboard/report">Report</a>&nbsp;|&nbsp;</li>-->
 <li> <a href="<?php echo base_url();?>dashboard/setting">Setting</a>&nbsp;|&nbsp;</li>
<!--<li class="drp"> <a href="javascript:void(0)">Manage</a>&nbsp;|&nbsp;
<ul>
<li><a href="<?php echo base_url();?>dashboard/location">Lcation</a></li>
<li><a href="<?php echo base_url();?>dashboard/rotation">Rotation</a></li>
<li><a href="<?php echo base_url();?>dashboard/diagnosis">Diagnosis</a></li>
</ul></li>-->
<li> <a href="<?php echo base_url();?>dashboard/logout">Logout</a></li>
 </div>
 
 <?php } else if(@$this->session->userdata['status']=='2'){?>
 
 <div class="left">Welcome Dr.<?php echo ucfirst($this->session->userdata['p_first_name'])." ".ucfirst($this->session->userdata['p_last_name']); ?>,<br><?php /*?><a href="<?php echo base_url();?>patients/addnewentry">Add New Patients</a>&nbsp;|&nbsp;<?php */?><a href="<?php echo base_url();?>patients/patientlogs">View Logs</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/report">Report</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/graphreport">View Graph</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/setting">Setting</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/logout">Logout</a></div>
  
  <?php } }else { ?>
  
  <div class="left">Patient Logs</div>
  
  <?php } ?>
  
  </div>
  
    <div id="navthing"></div>
     
    </div>
     
     
</body>

</html>
