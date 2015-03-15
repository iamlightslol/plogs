<?php
$rotation=$rotation;
$itdata=$this->org_model->get_all_rotation_dignosis_data($this->session->userdata['org_id'],$rotation,$this->session->userdata['year']);
$scndiagnosis=$this->org_model->scndary_diagnosis($this->session->userdata['org_id'],$rotation,$this->session->userdata['year']);
$all_dgns_data=$this->org_model->get_all_dignosis_data($this->session->userdata['id']);
$clm='"';
if(!empty($all_dgns_data)){
foreach($all_dgns_data as $v):
$r[] =$v->diagnosis_name;
$r1[]=$clm.$v->diagnosis_name.$clm;

endforeach;
$res=implode(",",$r);
$res1=implode(",",$r1);
}
?>
<table width="100%" style="margin:20px 0px 0px 10px;">
<tr>
<td width="50%" valign="top"><h4><font color="#178fbb">Primary Diagnosis</font></h4><br>
<ul style="list-style:none; margin-left:0px;">
 <?php if(!empty($itdata)){ foreach($itdata as $v):?>   
<li><input type="radio" class="rado" name="primary_diagnos" id="primary_diagnos" value="<?php echo $v->primary_diagnosis;?>"/>&nbsp;<?php echo $v->primary_diagnosis;?></li>
<?php endforeach;?>
<li><input type="radio" name="group1" class="mts"/>&nbsp;Other</li>
<?php } else{ ?>
<li><input type="radio" name="group1" class="mts"/>&nbsp;Other</li>
<?php }?>
</ul>
<div class="adm" style="display:none;">
                    <div style="width:90%; margin:0px 0px 0px 10px; float:left;"><br>Textbox</div><!--<div style="width:40%; margin:0px 0px 0px 10px; float:left;"><br>&nbsp;&nbsp;&nbsp;System</div>-->
                    
                    <div style="width:90%; margin:0px 0px 0px 10px; float:left;"><input name="primary_diagnosis" type="text" id="primary_diagnosis" placeholder="search diagnosis"/></div>
                    <!--<div style="width:40%; margin:0px 0px 0px 10px; float:left;">
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
</td>
<td width="50%" valign="top"><h4><font color="#178fbb">Secondary Diagnosis</font></h4><br>
<ul style="list-style:none; margin-left:0px;">
<?php  if(!empty($scndiagnosis)){foreach($scndiagnosis as $v):?>   
<li><input type="checkbox" name="secondary_diagnos[]" value="<?php echo $v;?>"/>&nbsp;<?php echo $v;?>&nbsp;&nbsp;&nbsp;</li>
<?php endforeach;}?>
<li><input type="checkbox" name="chkn" class="coupon_question"/>&nbsp;Add More

</ul>
<div class="address" style="display:none;">
                    <div><div style="width:90%; margin:0px 0px 0px 10px; float:left;"><br>Textbox</div><!--<div style="width:40%; margin:0px 0px 0px 10px; float:left;"><br>&nbsp;&nbsp;&nbsp;System</div>-->

                    <div class="amp">
                    <ul id="ulTest" class="ul-style"> 
                    <input type="hidden" name="total" id="total" value="0"/>
        <li class="li-style">
        		
                <input id="secondary_diagnoses0" name="secondary_diagnoses0"/>&nbsp;<!--<select id="s_system_name0" name="s_system_name0">				                <option value='Musculoskeletal'>Musculoskeletal</option>
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
</td>

</tr>
</table>
<script>
$(document).ready(function(){
	
    var data = "<?=$res;?>".split(",");
$("#primary_diagnosis").autocomplete(data);

});

 $(document).ready(function(){
$(function () {
	

    var availableTags = [<?=$res1;?>];
    
    count = 0;
    $("img[id^='add']").live("click", null, function () {
        count++;
        var txtTagsID= "secondary_diagnoses" + count;
		var slctTagsID= "s_system_name" + count;
        var btnAddID = "add" + count;
        var btnDelID = "del" + count;
		var total=$("#total").attr("value",count);
        var ul = $("#ulTest");
        var li = $("<li class='li-style'></li>")
            .append($("<input id='" + txtTagsID+ "' name='" + txtTagsID+ "' />&nbsp;&nbsp;"
				/*+"<select id='" + slctTagsID+ "' name='" + slctTagsID+ "'><option value='Musculoskeletal'>Musculoskeletal</option><option value='Cardiovascular'>Cardiovascular</option><option value='Gastrointestinal'>Gastrointestinal</option><option value='Endocrine'>Endocrine</option><option value='Nervous'>Nervous</option><option value='Respiratory'>Respiratory</option><option value='Urinary'>Urinary</option><option value='Reproductive'>Reproductive</option><option value='Integumentary'>Integumentary</option><option value='Immune/Lymphatic'>Immune/Lymphatic</option><option value='Psychiatric'>Psychiatric</option></select>&nbsp;&nbsp;"*/
				+"<img src='<?php echo HTTP_IMAGES_PATH;?>plus-icon.png' id='" + btnAddID + "' width='32' height='32'/>&nbsp;"
                +"<img src='<?php echo HTTP_IMAGES_PATH;?>minus.png' id='" + btnDelID + "' width='26' height='27'/>"));
        li.appendTo(ul);
    });

    $("img[id^='del']").live("click", null, function () {
        if (count == 0) {
            alert("You should have one textbox!");
            return;
        }
        var li = $(this).parent();
        li.remove();
        count--;
		var total=$("#total").attr("value",count);
    });
    
    
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
</script>