<?php

ob_start();
session_start();

date_default_timezone_set('America/Los_Angeles');

if($this->session->userdata['userid']=='')
{
	redirect(base_url());
}
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

?>
   
  <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jquery.autocomplete.css" type="text/css" />
   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
    
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>

    <script type='text/javascript' src='<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js'></script>
       <script type='text/javascript' src='<?php echo HTTP_JS_PATH; ?>jquery-1.7.2.js'></script>

    <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery-1.8.18.js"></script>
   <script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>
   <script src="<?php echo HTTP_JS_PATH; ?>jquery-1.4.2.js"></script>
   <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.autocomplete.js"></script>
   

      


<body>

  <?php include('header.php');?>
  
    	<?php $Infodata=$this->org_model->get_patent_field($this->session->userdata['userid']);
		$residency_year=$Infodata['year'];
		echo $this->session->userdata['year'];
		$rdata=$this->org_model->get_yearly_rotation_data($this->session->userdata['id'],$this->session->userdata['year']);
		
		$singlerdata=$this->org_model->get_srotation_data($this->session->userdata['id']);
		if(!empty($rdata)){$new_rdata=$rdata;}
		else{$new_rdata="";}
		if(@$rotdata!=''){
			$ddata=$this->org_model->get_all_rotation_dignosis_data($this->session->userdata['org_id'],$rotdata);
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
			}
		else{$ddata=$this->org_model->get_all_rotation_dignosis_data1($this->session->userdata['org_id'],$singlerdata);
		
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
		
		}
		
		$ldata=$this->org_model->get_location_data($this->session->userdata['id']);
		if(!empty($ldata)){$new_ldata=$ldata;}
		else{$new_ldata="";}
		
		
		?>
       <h1 align="center" style="margin-top:30px;">Add New Patients</h1>
       <p align="center"><font color="red"><?php echo isset($info)?$info:'';?></font></p>
       
     <?php echo form_open('welcome/addpatientdata');?>
	    		
                <table class="aks">
                <?php 
				$available_filed_data=explode(",", $Infodata['patient_logs_data']);
				?>
                <tr><td colspan="3"><p class="pa"><a href="<?php echo base_url();?>patients/patientlogs">View Patients-Logs</a></p></td></tr>
                <tr>
               
                <td width="30%"><b>Patient Initial</b><br>
                <input type="hidden" name="org_id" value="<?php echo $this->session->userdata['org_id'];?>"/>
                <input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/>
                <input type="hidden" name="resident_user" value="<?php echo $this->session->userdata['userid'];?>"/>
                <input type="hidden" name="resident_year" value="<?php echo $this->session->userdata['year'];?>"/>
                <input type="text"  name="patient_number" id="patient_number" placeholder="Patient Name" required /></td>
               
                <td width="40%"><b>Age</b><br>
               	<input type="text"  name="patient_age" placeholder="Patient Age" required style="width:120px !important;" />
                <select name="age" style="width:100px !important;" >
                <option value="Year">Year</option>
                <option value="Month">Month</option>
                <option value="Day">Day</option>
                </select>
                
                </td>
    
                <td width="30%"><b>Gender</b><br>
                <div class="akr"><input type="radio" name="patient_gender"  value="male" checked/>&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="patient_gender" value="female"/>&nbsp;Female</div>
                </td>
             
                </tr>
                
                <tr>
                
                <td><b>Rotation</b><br>
                <select name="rotation" id="slt" onChange="get_diagnosis_list()" required>
                	
                    <?php foreach($new_rdata as $v):
					if(@$rotdata!=''){
					?>
                    <option <?php if(@$rotdata==$v->rotation_name){ ?> selected="selected" <?php }?> value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                    <?php } else { ?>
                    <option value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                     <?php } endforeach;?>
                    </select>
                </td>
                
               
                <td><b>Date</b><br>
               <input type="text" name="date" class="tcal" value="<?php echo date("m/d/Y",time());?>" />
                </td>
                
              
                <td><b>Time</b><br>
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
                 <option value="12:00 AM">12:00 AM</option>
                 <option value="12:15 AM">12:15 AM</option>
                 <option value="12:30 AM">12:30 AM</option>
                 <option value="12:45 AM">12:45 AM</option>
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
                 <option value="12:00 PM">12:00 PM</option>
                 <option value="12:15 PM">12:15 PM</option>
                 <option value="12:30 PM">12:30 PM</option>
                 <option value="12:45 PM">12:45 PM</option>
                 </select>
                </td>
               
                </tr>
                
                <tr>
                
                <td valign="top"><b>Primary Diagnosis</b><br>
                <div id="ajx1">
                    <ul>
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
                
                </td>
               
                <td valign="top"><b>Secondary Diagnoses</b>
                <div id="ajx3">
                    <ul>
                     <?php if($new_ddata!=""): foreach($new_ddata as $v):
					 if(@$rotdata!=''){
					 ?>   
                    <li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?>&nbsp;&nbsp;&nbsp;</li>	
                    <?php } else { ?>
                    
                    <li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?>&nbsp;&nbsp;&nbsp;</li>	

                    <?php } endforeach; endif;?>
                    <li><input type="checkbox" class="coupon_question" name="chkn"/>&nbsp;Add More</li>
                    </ul>
                   	</div><div id="ajx4"></div>
                    <div class="nts">
                    <div class="address" style="display:none;">
                    <div class="ats">
                    <input type="hidden" name="total" id="total" value="0"/>
                    <ul id="ulTest" class="ul-style"> 
        <li class="li-style">
                <input id="secondary_diagnoses0" name="secondary_diagnoses0" placeholder="Search Diagnosis"/>&nbsp;
                <img src="<?php echo HTTP_IMAGES_PATH;?>plus-icon.png" id="add0" width="32" height="32"/>
                <img src="<?php echo HTTP_IMAGES_PATH;?>minus.png" id="del0" width="26" height="27"/>
                </li>
    </ul></div>
    				</div>
                    </div>
                   
                    
                </td>
              
                <td></td>
                </tr>
                
                <tr valign="middle">
                <td colspan="3"><b>Notes</b><br>
                <textarea name="comments" rows="1" cols="1" required></textarea>
                </td>
                
                </tr>
                
                <tr>
                <td colspan="3">
                <input type="submit" name="submit" value="Submit" id="remembers"/>
                </td>
                </tr>
              
                </table>
              	<?php echo form_close(); ?>


</body>




<script>

<?php /*?>$(document).ready(function(){
    var data = "<?=$res;?>".split(",");
$("#primary_diagnosis").autocomplete(data);

});<?php */?>

$(document).ready(function(){
	jQuery.noConflict();
$( "#slider-range-min" ).slider({
range: "min",
value: 34,
min: 0,
max: 100,
slide: function( event, ui ) {
$( "#amount" ).val(ui.value + "%" );
}
});
$( "#amount" ).val($( "#slider-range-min" ).slider( "value" )+ "%" );
});


$(window).load(function(){
$(function () {
		jQuery.noConflict();

    var availableTags = [<?=$res1;?>];
    
    window.count = 0;
    $("img[id^='add']").live("click", null, function () {
        window.count++;
        var txtTagsID= "secondary_diagnoses" + window.count;
		var slctTagsID= "s_system_name" + window.count;
        var btnAddID = "add" + window.count;
        var btnDelID = "del" + window.count;
		var total=$("#total").attr("value",window.count);
        var ul = $("#ulTest");
        var li = $("<li class='li-style'></li>")
            .append($("<input id='" + txtTagsID+ "' name='" + txtTagsID+ "' placeholder='Search Diagnosis' />&nbsp;&nbsp;"
				/*+"<select id='" + slctTagsID+ "' name='" + slctTagsID+ "'><option value='Musculoskeletal'>Musculoskeletal</option><option value='Cardiovascular'>Cardiovascular</option><option value='Gastrointestinal'>Gastrointestinal</option><option value='Endocrine'>Endocrine</option><option value='Nervous'>Nervous</option><option value='Respiratory'>Respiratory</option><option value='Urinary'>Urinary</option><option value='Reproductive'>Reproductive</option><option value='Integumentary'>Integumentary</option><option value='Immune/Lymphatic'>Immune/Lymphatic</option><option value='Psychiatric'>Psychiatric</option></select>&nbsp;&nbsp;"*/
				+"<img src='<?php echo HTTP_IMAGES_PATH;?>plus-icon.png' id='" + btnAddID + "' width='32' height='32'/>&nbsp;"
                +"<img src='<?php echo HTTP_IMAGES_PATH;?>minus.png' id='" + btnDelID + "' width='26' height='27'/>"));
        li.appendTo(ul);
    });

    $("img[id^='del']").live("click", null, function () {
        if (window.count == 0) {
            alert("You should have one textbox!");
            return;
        }
        var li = $(this).parent();
        li.remove();
        window.count--;
		var total=$("#total").attr("value",window.count);
    });
    
    
    $("input:text[id^='secondary_diagnoses']").live("focus.autocomplete", null, function () {
        $(this).autocomplete({
            source: availableTags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
    });
	
	$("input:text[id^='primary_diagnosis']").live("focus.autocomplete", null, function () {
        $(this).autocomplete({
            source: availableTags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
    });
    
 });
});//]]>



$(document).ready(function(){ 
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


























