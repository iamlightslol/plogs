<?php
$itdata=$this->org_model->scndary_diagnosis($this->session->userdata['org_id'],$rotation,$this->session->userdata['year']);


?>
      
<ul class="akm">
<?php  if(!empty($itdata)){foreach($itdata as $v):?>   
<li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v;?>"/>&nbsp;<?php echo $v;?>&nbsp;&nbsp;&nbsp;</li>
<?php endforeach;?>
<li><input type="checkbox" name="chkn" class="coupon_question"/>&nbsp;Add More
<?php } else{ ?>
<li><input type="checkbox" name="chkn" class="coupon_question"/>&nbsp;Add More
<?php } ?>
</ul>
<script>
$(document).ready(function(){ 
    
	
	$(".coupon_question").click(function() {
		if($(this).is(":checked")) {
			$(".address").show();
		} else {
			$(".address").hide();
		}
});	
	
	
	
	 
});

</script>
    
                    