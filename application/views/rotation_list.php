<?php
ob_start();
session_start();
date_default_timezone_set('Canada/Eastern');
if($this->session->userdata['userid']=='')
{
	redirect(base_url());
}
$resident_id=$this->uri->segment(3);
if($resident_id!='')
{
	$uid=$this->session->userdata['id'];
	$id=$resident_id;
}
else
{
	$uid=$this->session->userdata['org_id'];
	$id=$this->session->userdata['id'];
}
?>


   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>


<body>

 <?php include('header.php');?>
 
 	<?php $data=$this->report_model->get_rotaion_list($uid);
	
				
				?>
       			<h1 align="center">Rotation list</h1>
	    		<table class="ptbls" border="0" cellpadding="0" cellspacing="1">
           
                <tr class="mmm">
                <td align="center" width="10%"><b>S.No.</b></td>
                <td align="center" width="50%"><b>Rotation Name</b></td>
                <td align="center" width="40%"><b>Action</b></td>
                
                </tr>
                <?php $a=1;if(!empty($data)):
				foreach($data as $v):
				$rotation=$v->rotation_name;?>
                <tr class="tbmm">
                <td align="center"><?php echo $a;?></td>
                <td><?php echo ucfirst($v->rotation_name);?></td>
                
                <td align="center"><a href="<?php echo base_url();?>patients/rotation_report/<?=$id;?>/<?=$rotation;?>">View Report According Rotation</a></td>
                </tr>
				<?php $a++;endforeach; endif;?>
                </table>
              	
                
			
    


</body>






