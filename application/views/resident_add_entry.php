<?php

$clm='"';
$ddata11=$this->org_model->get_dignosis_data($this->session->userdata['id']);
$all_dgns_data=$this->org_model->get_all_dignosis_data($this->session->userdata['id']);

if(!empty($all_dgns_data)){
foreach($all_dgns_data as $v):
$r[] =$v->diagnosis_name;
$r1[]=$clm.$v->diagnosis_name.$clm;

endforeach;
$res=implode(",",$r);
$res1=implode(",",$r1);
}
else
{
$res="";
$res1="";
}
$rotdata=isset($rotdata)?$rotdata:'';
?>
   
    	<?php $Infodata=$this->org_model->get_patent_field($this->session->userdata['userid']);
		$residency_year=$Infodata['year'];
		
		$rdata=$this->org_model->get_yearly_rotation_data($this->session->userdata['org_id'],$this->session->userdata['year']);
		
		$singlerdata=$this->org_model->get_srotation_data($this->session->userdata['org_id'],$this->session->userdata['year']);
		if(!empty($rdata)){$new_rdata=$rdata;}
		else{$new_rdata="";}
		if(@$rotdata!=''){
			$ddata=$this->org_model->get_all_rotation_dignosis_data($this->session->userdata['org_id'],$rotdata,$this->session->userdata['year']);
			$scndiagnosis=$this->org_model->scndary_diagnosis($this->session->userdata['org_id'],$rotdata,$this->session->userdata['year']);
		
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
			}
		else{$ddata=$this->org_model->get_all_rotation_dignosis_data1($this->session->userdata['org_id'],$singlerdata,$this->session->userdata['year']);
			$scndiagnosis=$this->org_model->scndary_diagnosis($this->session->userdata['org_id'],$singlerdata,$this->session->userdata['year']);
			
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
		
		}
		
		$ldata=$this->org_model->get_location_data($this->session->userdata['id']);
		if(!empty($ldata)){$new_ldata=$ldata;}
		else{$new_ldata="";}
		
		
		?>
         <script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
       <p align="center"><font color="red"><?php echo isset($info)?$info:'';?></font></p>
       
     <?php echo form_open('welcome/addpatientdata');?>
	    		
               
                <ul>
                <?php 
				$available_filed_data=explode(",", $Infodata['patient_logs_data']);
				?>
                <?php /*?><tr><td colspan="3"><p class="pa"><a href="<?php echo base_url();?>patients/patientlogs">View Patients-Logs</a></p></td></tr>
                <tr><?php */?>
               
                <li><b>Patient Initial</b><br>
                <input type="hidden" name="org_id" value="<?php echo $this->session->userdata['org_id'];?>"/>
                <input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/>
                <input type="hidden" name="resident_user" value="<?php echo $this->session->userdata['userid'];?>"/>
                <input type="hidden" name="resident_year" value="<?php echo $this->session->userdata['year'];?>"/>
                <input type="text"  name="patient_number" id="patient_number" placeholder="Patient Name" required /></li>
               
                <li><b>Age</b><br>
               	<input type="text"  name="patient_age" placeholder="Patient Age" required style="width:90px !important;" />
                <select name="age" style="width:100px !important;" >
                <option value="Year">Year</option>
                <option value="Month">Month</option>
                <option value="Day">Day</option>
                </select>
                
                </li>
    
                <li><b>Gender</b><br>
                <div class="akr"><input type="radio" name="patient_gender"  value="male" checked/>&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="patient_gender" value="female"/>&nbsp;Female</div>
                </li>
             
                
                
                <li><b>Rotation</b><br>
                <select name="rotation" id="slt" onChange="get_diagnosis_list()" required>
                	
                    <?php foreach($new_rdata as $v):
					if(@$rotdata!=''){
					?>
                    <option <?php if(@$rotdata==$v->rotation_name){ ?> selected="selected" <?php }?> value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                    <?php } else { ?>
                    <option value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                     <?php } endforeach;?>
                    </select>
                </li>
                
               
                <li><b>Date</b><br>
               <input type="text" name="date" id="datepicker" value="<?php echo date("m/d/Y",time());?>" />
                </li>
                
              
                <li><b>Time</b><br>
                 <select name="fld_cur_time">
                 <option value="<?php echo date("h:i A",time());?>"><?php echo date("h:i A",time());?></option>
                 <option value="01:00 AM">01:00 AM</option>
                 <option value="01:15 AM">01:15 AM</option>
                 <option value="01:30 AM">01:30 AM</option>
                 <option value="01:45 AM">01:45 AM</option>
                 <option value="02:00 AM">02:00 AM</option>
                 <option value="02:15 AM">02:15 AM</option>
                 <option value="02:30 AM">02:30 AM</option>
                 <option value="02:45 AM">02:45 AM</option>
                 <option value="03:00 AM">03:00 AM</option>
                 <option value="03:15 AM">03:15 AM</option>
                 <option value="03:30 AM">03:30 AM</option>
                 <option value="03:45 AM">03:45 AM</option>
                 <option value="04:00 AM">04:00 AM</option>
                 <option value="04:15 AM">04:15 AM</option>
                 <option value="04:30 AM">04:30 AM</option>
                 <option value="04:45 AM">04:45 AM</option>
                 <option value="05:00 AM">05:00 AM</option>
                 <option value="05:15 AM">05:15 AM</option>
                 <option value="05:30 AM">05:30 AM</option>
                 <option value="05:45 AM">05:45 AM</option>
                 <option value="06:00 AM">06:00 AM</option>
                 <option value="06:15 AM">06:15 AM</option>
                 <option value="06:30 AM">06:30 AM</option>
                 <option value="06:45 AM">06:45 AM</option>
                 <option value="07:00 AM">07:00 AM</option>
                 <option value="07:15 AM">07:15 AM</option>
                 <option value="07:30 AM">07:30 AM</option>
                 <option value="07:45 AM">07:45 AM</option>
                 <option value="08:00 AM">08:00 AM</option>
                 <option value="08:15 AM">08:15 AM</option>
                 <option value="08:30 AM">08:30 AM</option>
                 <option value="08:45 AM">08:45 AM</option>
                 <option value="09:00 AM">09:00 AM</option>
                 <option value="09:15 AM">09:15 AM</option>
                 <option value="09:30 AM">09:30 AM</option>
                 <option value="09:45 AM">09:45 AM</option>
                 <option value="10:00 AM">10:00 AM</option>
                 <option value="10:15 AM">10:15 AM</option>
                 <option value="10:30 AM">10:30 AM</option>
                 <option value="10:45 AM">10:45 AM</option>
                 <option value="11:00 AM">11:00 AM</option>
                 <option value="11:15 AM">11:15 AM</option>
                 <option value="11:30 AM">11:30 AM</option>
                 <option value="11:45 AM">11:45 AM</option>
                 <option value="01:00 PM">01:00 PM</option>
                 <option value="01:15 PM">01:15 PM</option>
                 <option value="01:30 PM">01:30 PM</option>
                 <option value="01:45 PM">01:45 PM</option>
                 <option value="02:00 PM">02:00 PM</option>
                 <option value="02:15 PM">02:15 PM</option>
                 <option value="02:30 PM">02:30 PM</option>
                 <option value="02:45 PM">02:45 PM</option>
                 <option value="03:00 PM">03:00 PM</option>
                 <option value="03:15 PM">03:15 PM</option>
                 <option value="03:30 PM">03:30 PM</option>
                 <option value="03:45 PM">03:45 PM</option>
                 <option value="04:00 PM">04:00 PM</option>
                 <option value="04:15 PM">04:15 PM</option>
                 <option value="04:30 PM">04:30 PM</option>
                 <option value="04:45 PM">04:45 PM</option>
                 <option value="05:00 PM">05:00 PM</option>
                 <option value="05:15 PM">05:15 PM</option>
                 <option value="05:30 PM">05:30 PM</option>
                 <option value="05:45 PM">05:45 PM</option>
                 <option value="06:00 PM">06:00 PM</option>
                 <option value="06:15 PM">06:15 PM</option>
                 <option value="06:30 PM">06:30 PM</option>
                 <option value="06:45 PM">06:45 PM</option>
                 <option value="07:00 PM">07:00 PM</option>
                 <option value="07:15 PM">07:15 PM</option>
                 <option value="07:30 PM">07:30 PM</option>
                 <option value="07:45 PM">07:45 PM</option>
                 <option value="08:00 PM">08:00 PM</option>
                 <option value="08:15 PM">08:15 PM</option>
                 <option value="08:30 PM">08:30 PM</option>
                 <option value="08:45 PM">08:45 PM</option>
                 <option value="09:00 PM">09:00 PM</option>
                 <option value="09:15 PM">09:15 PM</option>
                 <option value="09:30 PM">09:30 PM</option>
                 <option value="09:45 PM">09:45 PM</option>
                 <option value="10:00 PM">10:00 PM</option>
                 <option value="10:15 PM">10:15 PM</option>
                 <option value="10:30 PM">10:30 PM</option>
                 <option value="10:45 PM">10:45 PM</option>
                 <option value="11:00 PM">11:00 PM</option>
                 <option value="11:15 PM">11:15 PM</option>
                 <option value="11:30 PM">11:30 PM</option>
                 <option value="11:45 PM">11:45 PM</option>
                 </select>
                </li>
               
             
                
                <li><b>Primary Diagnosis</b><br>
                <div id="ajx1">
                    <ul class="akm">
                     <?php if($new_ddata!=""): foreach($new_ddata as $v):
					 if(@$rotdata!=''){
					 ?>   
                    <li class="rads"><input type="radio" class="rado" name="primary_diagnos" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?></li>
                    <?php } else { ?>
                    <li class="rads"><input type="radio" class="rado" name="primary_diagnos" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?></li>
                    <?php } endforeach; endif;?>
                    <li><input type="radio" name="group1" class="mts"/>&nbsp;Other</li>
                    </ul>
                    </div><div id="ajx2"></div>
                    <div class="nts">
                    <div class="adm" style="display:none;">
                    
                    <div class="txt"><input name="primary_diagnosis" type="text" id="primary_diagnosis" placeholder="Search Diagnosis"/></div>
                    
                    </div>
                    </div>
                
                </li>
               
                <li><b>Secondary Diagnoses</b>
                <div id="ajx3">
                    <ul class="akm">
                     <?php  if(!empty($scndiagnosis)){foreach($scndiagnosis as $v):?>   
					
                    <li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v;?>"/>&nbsp;<?php echo $v;?>&nbsp;&nbsp;&nbsp;</li>	
                    <?php endforeach; }?>

          
                    <li><input type="checkbox" class="coupon_question" name="chkn"/>&nbsp;Add More</li>
                    </ul>
                   	</div><div id="ajx4"></div>
                    <div class="nts">
                    <div class="address" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES_PATH;?>plus-icon.png" id="btnAdd" width="32" height="32"/>
                <img src="<?php echo HTTP_IMAGES_PATH;?>minus.png" id="btnDel" width="26" height="27"/>
                    <input type="hidden" name="totals" id="totals" value="0"/>
                    <div id="adddel">
                    <div class="ld"><input type="text"  name="secondary_diagnoses" id="secondary_diagnoses" placeholder="secondary_diagnoses" /></div>
                    </div>
    				</div>
                    </div>
                   
                    
                </li>
              
                
      
                <li class="notes"><b>Notes</b><br>
                <textarea name="comments" rows="1" cols="1" ></textarea>
                </li>
                
                <li>
                <input type="submit" name="submit" value="Submit" id="remembers"/>
                </li>
              
                </ul>
              	<?php echo form_close(); ?>







<script>

$(document).ready(function(){

	
    var availableTags = [<?=$res1;?>];
    
    var nextRowID = 0;
    $('#btnAdd').click(function() {
		
		var newid = ++nextRowID;
        var $adddel = $('#adddel');
        var num = $('.clonedadddel').length; // there are 5 children inside each adddel so the prevCloned adddel * 5 + original
        var newNum = new Number(num + 1);
        var newElem = $adddel.clone().attr('id', 'adddel' + newNum).addClass('clonedadddel');
        var total=$("#totals").attr('value',newid);
        //set all div id's and the input id's
        newElem.children('div').each (function (i) {
            this.id = 'input' + (newNum*5 + i);
        });
        
        newElem.find('input').each (function () {
            this.id = this.id + newNum;
            this.name = this.name + newNum;
        });
         
        if (num > 0) {
            $('.clonedadddel:last').after(newElem);
        } else {
            $adddel.after(newElem);
        }
            

        $('#btnDel').removeAttr('disabled');
            
        if (newNum == 7) $('#btnAdd').attr('disabled', 'disabled');
    });
    $('#btnDel').click(function() {
        $('.clonedadddel:last').remove();
        $('#btnAdd').removeAttr('disabled');
		$("#totals").attr('value',$('.clonedadddel').length);
        if ($('.clonedadddel').length == 0) {
            $('#btnDel').attr('disabled', 'disabled');
        }
		--nextRowID;
    });
    $('#btnDel').attr('disabled', 'disabled');
	
	$("input:text[id^='secondary_diagnoses']").live("focus.autocomplete", null, function () {
        $(this).autocomplete({
            source: availableTags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
    });
	
	$("input:text[id^='primary_diagnos']").live("focus.autocomplete", null, function () {
        $(this).autocomplete({
            source: availableTags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
    });
    
 




    $("input[name$='group1']").click(function() {
		 $(".rado").attr("checked", false);
		
        $(".adm").show();
    });
	
	$("input[name$='chkn']").click(function() {
		
        $(".address").show();
		
    });
	
	
	
$(".coupon_question").click(function() {
		if($(this).is(":checked")) {
			$(".address").show();
		} else {
			$(".address").hide();
					}
});
	
	
	$("input[name$='primary_diagnos']").click(function() {
		 $(".mts").attr("checked", false);
		 $(".adm").hide();
		
    });
	
	
	 
});

$(document).ready(function(){
    $('#datepicker').datepicker({ 
	onSelect: function(date) {
    var curdate=date;
	var data="curdate="+curdate;
	//alert(data);
	$.ajax({
			type:"post",
			url:"<?=base_url()?>welcome/getcurrentage",
			data:data,
			success:function(response)
			{
				//alert(response);
				if(response!='')
				{
				$("#cur").html(response);
				}
			}
		});    
  		}
	});
});

function get_diagnosis_list()
{
	var rotation=$("#slt option:selected").val();
	var data="rotation="+rotation;
	//alert(data);
	$.ajax({
		
		type:"post",
		url:"<?=base_url()?>welcome/getpdiagnosis1",
		data:data,
		success:function(response){
		
			if(response!=''){
				$("#ajx1").hide();
				$("#ajx2").html(response);
			}
		}
			
	});
	
	$.ajax({
		
		type:"post",
		url:"<?=base_url()?>welcome/getpdiagnosis2",
		data:data,
		success:function(txt){
			
			if(txt!=''){
				$("#ajx3").hide();
				$("#ajx4").html(txt);
			}
		}
			
	});
}



</script>


























