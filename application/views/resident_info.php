<?php
ob_start();
session_start();
date_default_timezone_set('Canada/Eastern');
if($this->session->userdata['userid']=='')
{
	redirect(base_url());
}
?>


   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>


<body>

 <?php include('header.php');
 
		$config["base_url"] = base_url() ."dashboard/residentinfo";
		$config["total_rows"] =$this->user_model->get_total_resident($this->session->userdata['id']);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		
		$this->pagination->initialize($config);
		 
		$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		$data= $this->user_model->get_resident_detail($this->session->userdata['id'],$config["per_page"],$page);
		$links = $this->pagination->create_links();	
 ?>
 
       			<h1 align="center">Residents Detail</h1>
               <p align="center"><?php echo isset($info)?$info:'';?></p>
               <?php echo form_open("dashboard/deleteresident");?>
	    		<table class="ptbls" border="0" cellpadding="0" cellspacing="1">
           
                <tr class="mmm">
                <td align="center" width="5%"><b>S.No.</b></td>
                <td align="center" width="25%"><b>Residents Name</b></td>
                <td align="center" width="25%"><b>Username</b></td>
                <td align="center" width="15%"><b>Report</b></td>
                <td align="center" width="15%"><b>Graph Report</b></td>
                <td align="center" width="15%"><nobr><input type="checkbox" id="selecctall"/><input type="submit" name="delete" value="Delete"/></nobr></td>
                </tr>
                <?php $a=1;if(!empty($data)):
				foreach($data as $v):?>
                <tr class="tbmm">
                <td align="center"><?=$a;?></td>
                <td><?php echo ucfirst($v->p_first_name)." ".ucfirst($v->p_last_name);?></td>
                <td><?php echo ucfirst($v->p_user);?></td>
                <td align="center"><a href="<?php echo base_url();?>dashboard/report/<?php echo $v->p_id;?>/<?=$v->year;?>">Report</a></td>
                <td align="center"><a href="<?php echo base_url();?>dashboard/graphreport/<?php echo $v->p_id;?>/<?=$v->year;?>">Graph Report</a></td>
                <?php /*?><td align="center"><a href="<?php echo base_url();?>dashboard/rotation_list/<?php echo $v->p_id;?>">View Rotation List for Report</a></td><?php */?>
                <td align="center"><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $v->p_id;?>"/><a href="<?php echo base_url();?>dashboard/addnewentry/<?=$v->p_id;?>">Edit</a></td>
                </tr>
				<?php $a++;endforeach; endif;?>
                </table>
              	 <?php echo form_close();?>
                <div class="pagi"><?php echo $links; ?></div>
			
    


</body>

<script>
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});
</script>




