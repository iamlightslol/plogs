
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Patient-logs</title>

   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
	
</head>

<body>

  <div id="wrap">
  <div id="regbar">
  <div class="right">
  <p>Patient-logs<span>.com</span></p>
  <p class="cc">Customize your web presence</p>
  </div>
 <?php  if(@$this->session->userdata['userid']!=''){
	 
	 	if(@$this->session->userdata['status']=='1'){ ?>
        
 <div class="left">Welcome,<?php echo $this->session->userdata['userid']; ?><br><a href="<?php echo base_url();?>dashboard/addnewentry">Add New Entry</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/residentinfo">View Resident</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/report">Report</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/setting">Setting</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/logout">Logout</a></div>
 
 <?php } else if(@$this->session->userdata['status']=='2'){?>
 
 <div class="left">Welcome,<?php echo $this->session->userdata['userid']; ?><br><a href="<?php echo base_url();?>patients/addnewentry">Add New Entry</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/patientlogs">View Patients-logs</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/report">Report</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>patients/setting">Setting</a>&nbsp;|&nbsp;<a href="<?php echo base_url();?>dashboard/logout">Logout</a></div>
  
  <?php } }else { ?>
  
  <div class="left">ADMINISTRATIVE SECTION</div>
  
  <?php } ?>
  
  </div>
  
    <div id="navthing"></div>
     
    </div>
     
     
</body>

</html>
