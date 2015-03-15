<?php
$itdata=$this->org_model->get_all_rotation_dignosis_data($this->session->userdata['org_id'],$rotation,$this->session->userdata['year']);
?>

<ul class="akm">
 <?php if(!empty($itdata)){ foreach($itdata as $v):?>   
<li class="rads"><input type="radio" class="rado" name="primary_diagnos" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?></li>
<?php endforeach;?>
<li><input type="radio" name="group1" class="mts"/>&nbsp;Other</li>
<?php } else{ ?>
<li><input type="radio" name="group1" class="mts"/>&nbsp;Other</li>
<?php } ?>
</ul>
<script>
$(document).ready(function(){ 
    $("input[name$='group1']").click(function() {
		 $(".rado").attr("checked", false);
		
        $(".adm").show();
    });
	
	
	
	
	$("input[name$='primary_diagnos']").click(function() {
		 $(".mts").attr("checked", false);
		 $(".adm").hide();
		
    });
	
	
	 
});

</script>
        