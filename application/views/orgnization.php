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
	$Infodata=$this->user_model->get_all_data($resident_id);
	
}
if(!empty($Infodata)):
foreach($Infodata as $v):
$p_first_name=$v->p_first_name;
$p_last_name=$v->p_last_name;
$year=$v->year;
$p_password=$v->p_password;
endforeach;endif;
?>


   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script> 
<body>
 <?php include('header.php');?>
 
<div class="nar">
<h2><?php if($resident_id!=''){echo 'Edit Resident Info';} else { echo 'Add Residents';}?></h2>
<p align="center"><?php echo isset($info)?$info:'';?></p>
<?php if($resident_id==''){?>
<button id="btnAdd">Add More Residents</button><button id="btnDel">Delete</button>
<?php } ?>
<?php echo form_open("dashboard/addresident");?>
<input type="hidden" name="id" value="<?php echo $this->session->userdata['id']; ?>"/>
<input type="hidden" name="rid" value="<?php if($resident_id!=''){ echo $resident_id;} ?>"/>
<input type="hidden" name="total" id="total" value="0"/>
<div class="na1"><b>Resident First Name</b></div><div class="na2"><b>Resident Last Name</b></div><!--<div class="na3"><b>Email-Id</b></div>--><div class="na4"><b>Year</b></div><div class="na5"><b>Default Password</b></div><div class="na6"><b>Default Confirm Password</b></div>
<div id="address">

<div class="na1"><input type="text"  name="first_name" id="first_name" required  autocomplete="off" placeholder="First Name" value="<?php echo isset($p_first_name)? $p_first_name:'';?>"/></div>

<div class="na2"><input type="text"  name="last_name" id="last_name" required  autocomplete="off" placeholder="Last Name" value="<?php echo isset($p_last_name)? $p_last_name:'';?>"/></div>

<!--<div class="na3"><input type="text"  name="resident_name" id="resident_name" required  autocomplete="off" placeholder="Email-Id" value=""/></div>-->

<div class="na4"><input name="resident_exp" type="text" id="resident_exp" required ="required" placeholder="Year" value="<?php echo isset($year)? $year:'';?>" /></div>

<div class="na5"><input name="password" type="text"   id="password" required ="required" placeholder="Enter Resident Password" value="<?php echo isset($p_password)? $p_password:'123456';?>"  /></div>

<div class="na6"><input name="repassword" type="text" id="repassword" required placeholder="Enter Confirm password" value="<?php echo isset($p_password)? $p_password:'123456';?>" /></div>

</div>
<?php if($resident_id==''){?>
<div class="nar2"><div class="na9"><b>Features in patient logs:</b></div>
<div class="na10">
			<div style="margin-left:0px; width:100%; text-align:left;"><input type="checkbox" id="selecctall"/><b>CheckedAll/Unchecked</b></div><br>
<ul class="orgul">
            <li><input type="checkbox" name="features[]" value="Date" class="checkbox1" />&nbsp;Date&nbsp;&nbsp;&nbsp;</li>
            <li> <input type="checkbox" name="features[]" value="Patient Initials" class="checkbox1" />&nbsp;Patient Initials&nbsp;&nbsp;&nbsp;</li>
            <li> <input type="checkbox" name="features[]" value="Patient MRN" class="checkbox1" />&nbsp;Patient MRN&nbsp;&nbsp;&nbsp;</li>
            
            <li><input type="checkbox" name="features[]" value="Patient Age" class="checkbox1" />&nbsp;Patient Age&nbsp;&nbsp;&nbsp;</li>
            <li> <input type="checkbox" name="features[]" value="Patient Gender" class="checkbox1" />&nbsp;Patient Gender&nbsp;&nbsp;&nbsp;</li>
            <li> <input type="checkbox" name="features[]" value="Location" class="checkbox1" />&nbsp;Location</li>
            
            <li><input type="checkbox" name="features[]" value="Rotation" class="checkbox1" />&nbsp;Rotation</li>
            <li> <input type="checkbox" name="features[]" value="Primary Diagnosis" class="checkbox1" />&nbsp;Primary Diagnosis&nbsp;&nbsp;&nbsp;</li>
            <li><input type="checkbox" name="features[]" value="Secondary Diagnoses" class="checkbox1" />&nbsp;Secondary Diagnoses&nbsp;&nbsp;&nbsp;</li>
            
            <li><input type="checkbox" name="features[]" value="ICD Codes" class="checkbox1" />&nbsp;ICD Codes</li>
            <li><input type="checkbox" name="features[]" value="Procedures Performed" class="checkbox1" />&nbsp;Procedures Performed&nbsp;&nbsp;&nbsp;</li>
            <li><input type="checkbox" name="features[]" value="Difficulty of case" class="checkbox1" />&nbsp;Difficulty of case&nbsp;&nbsp;&nbsp;</li>
            
            <li><input type="checkbox" name="features[]" value="Supervisor" class="checkbox1" />&nbsp;Supervisor&nbsp;&nbsp;&nbsp;</li>
            <li> <input type="checkbox" name="features[]" value="Outcome" class="checkbox1" />&nbsp;Outcome&nbsp;&nbsp;&nbsp;</li>
            <li><input type="checkbox" name="features[]" value="Comments" class="checkbox1" />&nbsp;Comments</li>
            </ul>
</div>
</div>
<?php } ?>
<div align="center" class="nar1"><input type="submit" name="submit" value="Submit" onClick="return checkpassword()"/></div>


  <?php echo form_close();?>
  <div class="clr"></div>
  </div>

</body>

<script language="javascript">
$(document).ready(function() {
	var nextRowID = 0;
    $('#btnAdd').click(function() {
		
		
		var newid = ++nextRowID;
        var $address = $('#address');
        var num = $('.clonedAddress').length; // there are 5 children inside each address so the prevCloned address * 5 + original
        var newNum = new Number(num + 1);
		
		
        var newElem = $address.clone().attr('id', 'address' + newNum).addClass('clonedAddress');
		
       var total=$("#total").attr('value',newid);
	   
	   var fname='<div class="na1"><input type="text"  name="first_name" id="first_name'+newid+'" value="" required  autocomplete="off"/></div>';
	   var lname='<div class="na2"><input type="text"  name="last_name" id="last_name'+newid+'" value="" required  autocomplete="off"/></div>';
	   var uname='<div class="na1"><input type="text"  name="resident_name" id="resident_name'+newid+'" value="" required  autocomplete="off"/></div>';
	   var uexp='<div class="na4"><input type="text" id="resident_exp' + newid + '" required value="" />';
	   var pwd='<div class="na5"><input type="text" id="password' + newid + '" required value="" /></div>';
		var rpwd='<div class="na6"><input type="text" id="repassword'+newid+'" required value="" /></div>';
		
        //set all div id's and the input id's
        newElem.children('div').each (function (i) {
            this.id = 'input' + (newNum*5 + i);
        });
        
        newElem.find('input').each (function () {
            this.id = this.id + newNum;
            this.name = this.name + newNum;
        });
         
        if (num > 0) {
            $('.clonedAddress:last').after(newElem);
			
        } else {
            $address.after(newElem);
			 
        }
            

        $('#btnDel').removeAttr('disabled');
            
        if (newNum == 7) $('#btnAdd').attr('disabled', 'disabled');
    });
    $('#btnDel').click(function() {
		
        $('.clonedAddress:last').remove();
        $('#btnAdd').removeAttr('disabled');
		$("#total").attr('value',$('.clonedAddress').length);
        if ($('.clonedAddress').length == 0) {
			
            $('#btnDel').attr('disabled', 'disabled');
        }
		--nextRowID;
    });
    $('#btnDel').attr('disabled', 'disabled');
});



$(document).ready(function() {	

	$("#pform").submit(function(){
		
		if($("#cross").is(':visible'))
		{
			$("#resident_name").focus();
			return false;
		}
		
	});
	
	   $("#resident_name").keyup(check_name);
	  
		function check_name()
		{ 
		
		  $.ajax({
		   type: "POST",
		   url: "<?php echo base_url();?>dashboard/check_name",
		   data: "name="+$("#resident_name").val(),
		   success: function(msg){
			  
				if(msg=="1")
				{ 
				
				 $("#right").show();
				 $("#cross").hide();
				}
				else
				{
					$("#cross").show();
					$("#right").hide();
				 
				}
			 }
		  });
 
	}
});

function checkpassword()
{
	var i=$("#total").val();
	var pwd=$("#password").val();
	var repwd=$("#repassword").val();
	
	if(pwd!='')
	{
		if(pwd!=repwd)
		{
			alert("Password and confirm password does not matched!");
			$("#repassword").focus();
			return false;
		}
	}
	
	if(isNaN($("#resident_exp").val()))
		{
			alert("Enter Only numeric data..!");
			$("#resident_exp").focus();
			return false;
		}
	
	for(var n=1;n<=i;n++)
	{
		var npwd=$("#password"+n).val();
		var nrepwd=$("#repassword"+n).val();
		if(npwd!='')
		{
			if(npwd!=nrepwd)
			{
				alert("Password and confirm password does not matched!");
				$("#repassword"+n).focus();
				return false;
			}
		}
		
		if(isNaN($("#resident_exp"+n).val()))
		{
			alert("Enter Only numeric data..!");
			$("#resident_exp"+n).focus();
			return false;
		}
	}
	return true;
}

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
</script>
