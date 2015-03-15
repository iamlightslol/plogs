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
		
		$rdata=$this->org_model->get_rotation_data($this->session->userdata['id']);
		if(!empty($rdata)){$new_rdata=$rdata;}
		else{$new_rdata="";}
		if(@$rotdata!=''){
			$ddata=$this->org_model->get_all_rotation_dignosis_data($this->session->userdata['org_id'],$rotdata);
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
			}
		else{$ddata=$this->org_model->get_dignosis_data($this->session->userdata['id']);
			if(!empty($ddata)){$new_ddata=$ddata;}
			else{$new_ddata="";}
		
		}
		
		$ldata=$this->org_model->get_location_data($this->session->userdata['id']);
		if(!empty($ldata)){$new_ldata=$ldata;}
		else{$new_ldata="";}
		
		
		?>
       <h1 align="center" style="margin-top:30px;">Add New Patients</h1>
       
     <?php echo form_open('welcome/addpatientdata');?>
	    		<table class="tbl">
                <tr><td colspan="2" align="center"><font color="#FF0000"><?php echo isset($info)? $info:'';?></font>
                <input type="hidden" name="org_id" value="<?php echo $this->session->userdata['org_id'];?>"/><input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/><input type="hidden" name="resident_user" value="<?php echo $this->session->userdata['userid'];?>"/><input type="hidden" name="curnt_time" value="<?php echo date("h:i A",time());?>"/><input type="hidden" name="residency_year" value="<?php echo $this->session->userdata['year'];?>"/>
                </td></tr>
                <?php /*?><tr class="ac9">
                    <td class="lft"><b>Residency Year:</b></td>
                    <td class="rgt">
                    <select name="residency_year">
                    <?php foreach (range(1, $residency_year) as $number) {?>
    				<option value="<?php echo $number;?>"><?php echo $number;?></option>
					<?php }  ?>
                    </select></td>
                    </td>
                </tr><?php */?>
               <?php
			     
			$available_filed=explode(",", $Infodata['patient_logs_data']);
			for($i = 0; $i < count($available_filed); $i++){
			if($available_filed[$i]=='Date'){
			?>
                <tr class="ac">
                    <td class="lft"><b>Date:</b></td>
                    <td class="rgt"><input type="text" name="date" class="tcal" value="<?php echo date("m/d/Y",time());?>" /></td>
                </tr>
                <?php } if($available_filed[$i]=='Patient Initials'){?>
                <tr class="ac1">
                    <td class="lft"><b>Patient initials:</b></td>
                    <td class="rgt"><input type="text"  name="patient_number" id="patient_number" required /></td>
                </tr>
                <?php } if($available_filed[$i]=='Patient MRN'){?>
                <tr class="ac2">
                    <td class="lft"><b>Patient MRN:</b></td>
                    <td class="rgt"><input type="text"  name="patient_mrn" id="patient_mrn" required /></td>
                </tr>
                <?php } if($available_filed[$i]=='ICD Codes'){?>
                <tr class="ac3">
                    <td class="lft"><b>ICD Codes:</b></td>
                    <td class="rgt"><input type="text"  name="icd_code" id="icd_code" required /></td>
                </tr>
                <?php } if($available_filed[$i]=='Patient Age'){?>
                <tr class="ac4">
                <td class="lft"><b>Date of Birth:</b></td>
                 <td class="rgt"><input type="text" name="years" id="datepicker" value="<?php echo date("m/d/Y",time());?>"/><span id="cur"></span></td>
                 
                </tr>
                  <?php } if($available_filed[$i]=='Patient Gender'){?>
                <tr class="ac5">
                    <td class="lft"><b>Gender:</b></td>
                    <td class="rgt" style="height:50px;"><input type="radio" name="patient_gender"  value="male" checked/>&nbsp;male&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="patient_gender" value="female"/>&nbsp;female</td>
                </tr>
                <?php } if($available_filed[$i]=='Location'){?>
                <tr class="ac6">
                    <td class="lft"><b>Location:</b></td>
                    <td class="rgt" style="height:50px;">
                    <select name="location" class="tcal" required>
                    <?php foreach($new_ldata as $v):
					if(@$locdata!=''){
					?>
                    <option <?php if(@$locdata==$v->location_name){ ?> selected="selected" <?php }?> value="<?php echo $v->location_name;?>"><?php echo $v->location_name;?></option>
                    <?php } else { ?>
                    
                    <option value="<?php echo $v->location_name;?>"><?php echo $v->location_name;?></option>
                     <?php } endforeach;?>
                    </select>
                   
                   </td>
                </tr>
                
                <?php } if($available_filed[$i]=='Rotation'){?>
                <tr class="ac7">
                    <td class="lft"><b>Rotation:</b></td>
                    <td class="rgt" style="height:50px;">
                    <select name="rotation" id="slt" onChange="get_diagnosis_list()" required>
                    <?php foreach($new_rdata as $v):
					if(@$rotdata!=''){
					?>
                    <option <?php if(@$rotdata==$v->rotation_name){ ?> selected="selected" <?php }?> value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                    <?php } else { ?>
                    <option value="<?php echo $v->rotation_name;?>"><?php echo $v->rotation_name;?></option>
                     <?php } endforeach;?>
                    </select>
                    <?php /*?><ul>
                     <?php foreach($rdata as $v):?>    
                  <li>  <input type="radio" name="rotation" value="<?php echo $v->rotation_name;?>" checked/>&nbsp;<?php echo $v->rotation_name;?>&nbsp;&nbsp;&nbsp;</li>
                    <?php endforeach;?></ul><?php */?>
                    </td>
                </tr>
                <?php } if($available_filed[$i]=='Primary Diagnosis'){?>
                <tr class="ac8">
                    <td class="lft" valign="middle"><b>Primary Diagnosis:</b></td>
                    <td class="rgt">
                    <div id="ajx1">
                    <ul>
                     <?php if($new_ddata!=""): foreach($new_ddata as $v):
					 if(@$rotdata!=''){
					 ?>   
                    <li class="rads"><input type="radio" class="rado" name="primary_diagnos" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?></li>
                    <?php } else { ?>
                    <li class="rads"><input type="radio" class="rado" name="primary_diagnos" value="<?php echo $v->diagnosis_name;?>"/>&nbsp;<?php echo $v->diagnosis_name;?></li>
                    <?php } endforeach; endif;?>
                    <li><input type="radio" name="group1" class="mts"/>Other</li>
                    </ul>
                    </div><div id="ajx2"></div>
                    <div class="nts">
                    <div class="adm" style="display:none;">
                    <div class="txt"><br>Textbox</div><!--<div class="stm"><br>&nbsp;&nbsp;&nbsp;System</div>-->
                    
                    <div class="txt"><input name="primary_diagnosis" type="text" id="primary_diagnosis" placeholder="search diagnosis"/></div>
                    <!--<div class="stm">
                        <select name="p_system_name">
                        <option value='Musculoskeletal'>Musculoskeletal</option>
                        <option value='Cardiovascular'>Cardiovascular</option>
                        <option value='Gastrointestinal'>Gastrointestinal</option>
                        <option value='Endocrine'>Endocrine</option>
                        <option value='Nervous'>Nervous</option>
                        <option value='Respiratory'>Respiratory</option>
                        <option value='Urinary'>Urinary</option>
                        <option value='Reproductive'>Reproductive</option>
                        <option value='Integumentary'>Integumentary</option>
                        <option value='Immune/Lymphatic'>Immune/Lymphatic</option>
                        <option value='Psychiatric'>Psychiatric</option>
                        </select>
                </div>-->
                    </div>
                    </div>
                    </td>
                </tr>
                <?php } if($available_filed[$i]=='Secondary Diagnoses'){?>
                <tr class="ac9">
                    <td class="lft" valign="middle"><b>Secondary Diagnosis:</b></td>
                    <td class="rgt">
                    <div id="ajx3">
                    <ul>
                     <?php if($new_ddata!=""): foreach($new_ddata as $v):
					 if(@$rotdata!=''){
					 ?>   
                    <li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?>&nbsp;&nbsp;&nbsp;</li>	
                    <?php } else { ?>
                    
                    <li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v->diagnosis_name;?>"/>&nbsp;<?php echo $v->diagnosis_name;?>&nbsp;&nbsp;&nbsp;</li>	

                    <?php } endforeach; endif;?>
                    <li><input type="checkbox" class="coupon_question" name="chkn"/>Add More</li>
                    </ul>
                   	</div><div id="ajx4"></div>
                    <div class="nts">
                    <div class="address" style="display:none;">
                    <div class="nts"><div class="txt"><br>Textbox</div><!--<div class="stm"><br>&nbsp;&nbsp;&nbsp;System</div>-->

                    <div class="ats">
                    <ul id="ulTest" class="ul-style"> 
        <li class="li-style">
        		<input type="hidden" name="total" id="total" value="0"/>
                <input id="secondary_diagnoses0" name="secondary_diagnoses0"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<select id="s_system_name0" name="s_system_name0">				                <option value='Musculoskeletal'>Musculoskeletal</option>
				<option value='Cardiovascular'>Cardiovascular</option>
				<option value='Gastrointestinal'>Gastrointestinal</option>
				<option value='Endocrine'>Endocrine</option>
				<option value='Nervous'>Nervous</option>
				<option value='Respiratory'>Respiratory</option>
				<option value='Urinary'>Urinary</option>
				<option value='Reproductive'>Reproductive</option>
				<option value='Integumentary'>Integumentary</option>
                <option value='Immune/Lymphatic'>Immune/Lymphatic</option>
                <option value='Psychiatric'>Psychiatric</option>
                </select>-->
                <img src="<?php echo HTTP_IMAGES_PATH;?>plus-icon.png" id="add0" width="32" height="32"/>
                <img src="<?php echo HTTP_IMAGES_PATH;?>minus.png" id="del0" width="26" height="27"/>
                </li>
    </ul></div>
    </div>
                    </div>
                    </div>
                    
					</td>
                </tr>
               <?php } if($available_filed[$i]=='Difficulty of case'){?>
             	<tr class="ac10">
                    <td class="lft"><b>Difficulty of case:</b></td>
                    <td class="rgt"><input type="text" id="amount" name="difficulty_of_case" readonly style="border:0; color:#f6931f; font-weight:bold; width:50px; background-color:#EFEFEF;"></label>
                   <div id="slider-range-min"></div></td>
                </tr>
                <?php } if($available_filed[$i]=='Supervisor'){?>
                <tr class="ac11">
                    <td class="lft"><b>Supervisor:</b></td>
                    <td class="rgt"><input type="text"  name="supervisor" id="supervisor" required/></td>
                </tr>
                <?php } if($available_filed[$i]=='Outcome'){?>
                <tr class="ac12">
                    <td class="lft"><b>Outcome:</b></td>
                    <td class="rgt"><input type="text"  name="outcome" id="outcome" required /></td>
                </tr>
                <?php } if($available_filed[$i]=='Procedures Performed'){?>
                
                <tr class="ac13">
                    <td class="lft"><b>Procedures Performed:</b></td>
                    <td class="rgt"><textarea name="procedure_performed" rows="1" cols="1" required></textarea></td>
                </tr>
                <?php } if($available_filed[$i]=='Comments'){?>
                
                <tr class="ac14">
                    <td class="lft"><b>Notes:</b></td>
                    <td class="rgt"><textarea name="comments" rows="1" cols="1" required></textarea></td>
                </tr>
                <?php } }?>
                <tr class="ac15">
              
                    <td class="rgt" colspan="2" align="center" style="height:40px;"><input type="submit" name="submit" value="Submit" id="remembers"/></td>
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
            .append($("<input id='" + txtTagsID+ "' name='" + txtTagsID+ "' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
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


























