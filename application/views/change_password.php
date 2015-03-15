<?php 
ob_start();
session_start();
if($this->session->userdata['userid']=='')
{
	redirect(base_url());
}
?>
	<link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>form.css">
   <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>normalize.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>tabs.css">

   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
	<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
    
	<body>
     <?php include('header.php');?>
      <div class="heading">
	  <h1>Change Password</h1>
	  </div>
      <!--<div class="formholder">-->
        <div class="randompad">
		
		<?php $data=$this->user_model->get_user_data($this->session->userdata['userid'] );
		?>
	<?php 	echo form_open("welcome/changepassword");?>
        <?php echo isset($msg)?$msg:'';?>
           <fieldset>
             <label name="name"><b>Username</b></label>
             <input type="text"  name="username" value="<?php echo $this->session->userdata['userid'] ;?>" readonly/>
             <label name="password"><b>Old Password</b></label>
             <input type="password" placeholder="Old Password"  id="old_password" name="old_password" required />
            <label name="password"><b>New Password</b></label>
             <input type="password" placeholder="New Password"  id="new_password" name="new_password" required />
             <label name="password"><b>Confirm Password</b></label>
             <input type="password" placeholder="Confirm Password"  id="confirm_password" name="confirm_password" required />
             <input type="submit"  name="submit" value="Submit" id="remembers" onClick="return checkpassword();">

           </fieldset>
		   <?php echo form_close(); ?>
        </div>
     <!-- </div>-->
      <!--------------------for Location--------------->
      <?php if(@$this->session->userdata['status']=='1'){ ?>
       <div class="heading">
	  <h1>Add Location Data</h1>
	  </div>

    <div class="lthree">
    <div class="tabContaier">
        <ul>
            <li><a class="active" href="#tab1">View Location Data</a></li>
            <li><a href="#tab2">Add New Location</a></li>
            
        </ul></div><!-- //Tab buttons -->
    <div class="tabDetails">
    	<div id="tab1" class="tabContents">
        	<?php
			$Infodata=$this->org_model->get_location_field($this->session->userdata['id']);
			echo form_open("dashboard/deletelocation");?>
            <table class="ta1" border="0" cellpadding="0" cellspacing="1">
            <tr class="mn"><td width="20%" align="center">S.No</td>
            <td width="50%" align="center">Location name</td>
            <td width="30%" align="center"><nobr><input type="checkbox" id="selecctall"/><input type="submit" name="delete" value="Delete"/></nobr></td>
            </tr>
            
            <?php $a=1;
			if(!empty($Infodata)):
			foreach($Infodata as $v):?>
            <tr class="tbn"> 
            <td align="center"><?php echo $a;?></td>
            <td align="center"><?php echo $v->location_name;?></td>
            <td align="center"><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $v->location_id;?>"></td>
            </tr>
            <?php $a++;endforeach;endif;?>
            
            </table>
            <?php echo form_close();?> 
  
            
        </div><!-- //tab1 -->
    	<div id="tab2" class="tabContents">
        <h2>Add Location Data</h2>
            <p align="center"><?php echo isset($infos)?$infos:'';?></p>
            
        <button id="btnAdd">Add</button><button id="btnDel">Delete</button>
       <?php echo form_open("dashboard/addlocation");?> 
        
        <input type="hidden" name="id" value="<?php echo $this->session->userdata['id']; ?>"/>
        <div id="address">
        <div class="ld"><input type="text"  name="location[]" id="location" required placeholder="Location"/></div>
        </div>
        <input type="submit" name="submit" value="Submit"/>
         <?php echo form_close();?> 
 
       	</div><!-- //tab2 -->
    </div><!-- //tab Details -->
 </div>
 <!--------------Location end-------------------------------->
 	<div class="heading">
	  <h1>Add Rotation Data</h1>
	</div>
 	<div class="lthree">   
    <div class="tabContaier1">
	<ul>
    	<li><a class="active" href="#tab3">View Rotation Data</a></li>
    	<li><a href="#tab4">Add New Rotation</a></li>
    	
    </ul></div><!-- //Tab buttons -->
    <div class="tabDetails1">
    	<div id="tab3" class="tabContents1">
        	<?php
			$Infodata=$this->org_model->get_rotation_field($this->session->userdata['id']);
			echo form_open("dashboard/deleterotation");?>
            <table class="ta1" border="0" cellpadding="0" cellspacing="1">
            <tr class="mn"><td width="10%" align="center">S.No</td>
            <td width="40%" align="center">Rotation Name</td>
            <td width="20%" align="center">Rotation Year</td>
            <td width="30%" align="center"><nobr><input type="checkbox" id="selecctall1"/><input type="submit" name="delete" value="Delete"/></nobr></td>
            </tr>
            
            <?php $a=1;
			if(!empty($Infodata)):
			foreach($Infodata as $v):?>
            <tr class="tbn"> 
            <td align="center"><?php echo $a;?></td>
            <td align="center"><?php echo $v->rotation_name;?></td>
            <td align="center"><?php echo $v->rotation_year;?></td>
            <td align="center"><input class="checkbox11" type="checkbox" name="check[]" value="<?php echo $v->rotation_id;?>"></td>
            </tr>
            <?php $a++;endforeach;endif;?>
            
            </table>
            <?php echo form_close();?>
            
        </div><!-- //tab3 -->
    	<div id="tab4" class="tabContents1">
        	<h2>Add Rotation Data</h2>
            <p align="center"><?php echo isset($info)?$info:'';?></p>
            
        <button id="btnAdd1">Add</button><button id="btnDel1">Delete</button>
       <?php echo form_open("dashboard/addrotation");?> 
        
        <input type="hidden" name="id" value="<?php echo $this->session->userdata['id']; ?>"/>
        <input type="hidden" name="total" id="total" value="0"/>
        <div id="address1">
        <div class="ld1"><input type="text"  name="rotation" id="rotation" required placeholder="Rotation"/><input type="text"  name="rotation_year" required placeholder="Rotation Year"/></div>
        </div>
        <input type="submit" name="submit" value="Submit"/>
         <?php echo form_close();?> 
        </div><!-- //tab4 -->
    </div><!-- //tab Details -->
 </div>
 
 <!--------------Rotation end-------------------------------->
 	<div class="heading">
	  <h1>Add Diagnosis Data</h1>
	</div>
 	<div class="lthree">   
    <div class="tabContaier2">
	<ul>
    	<li><a class="active" href="#tab5">View Diagnosis Data</a></li>
    	<li><a href="#tab6">Add New Diagnosis</a></li>
    	
    </ul></div><!-- //Tab buttons -->
    <div class="tabDetails1">
    	<div id="tab5" class="tabContents2">
        	<?php
			//$Infodatas=$this->org_model->get_diagnosis_field($this->session->userdata['id']);
		$config["base_url"] = base_url() ."dashboard/setting";
		$config["total_rows"] =$this->org_model->get_total_dgns_filed($this->session->userdata['id']);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		
		$this->pagination->initialize($config);
		 
		$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		$Infodatas= $this->org_model->get_diagnosis_field($this->session->userdata['id'],$config["per_page"],$page);
		$links = $this->pagination->create_links();	
			echo form_open("dashboard/deletediagnosis");?>
            <table class="ta2" border="0" cellpadding="0" cellspacing="1">
            <tr class="mn"><td width="20%" align="center">S.No</td>
            <td width="50%" align="center">Diagnosis Name</td>
            <td width="30%" align="center"><nobr><input type="checkbox" id="selecctall2"/><input type="submit" name="delete" value="Delete"/></nobr></td>
            </tr>
            
            <?php $a=1;
			if(!empty($Infodatas)):
			foreach($Infodatas as $v):?>
            <tr class="tbnn"> 
            <td align="center"><?php echo $a;?></td>
            <td align="center"><?php echo $v->diagnosis_name;?></td>
            <td align="center"><input class="checkbox2" type="checkbox" name="check[]" value="<?php echo $v->diagnosis_id;?>"></td>
            </tr>
            <?php $a++;endforeach;endif;?>
            
            </table>
            <?php echo form_close();?>
              <div class="pagi"><?php echo $links; ?></div>
        </div><!-- //tab3 -->
    	<div id="tab6" class="tabContents2">
        	<h2>Add Diagnosis Data</h2>
            <p align="center"><?php echo isset($information)?$information:'';?></p>
            
        <button id="btnAdd2">Add</button><button id="btnDel2">Delete</button>
       <?php echo form_open("dashboard/adddiagnosis");?> 
        
        <input type="hidden" name="id" value="<?php echo $this->session->userdata['id']; ?>"/>
        <div id="address2">
        <div class="ld"><input type="text"  name="diagnosis[]" required placeholder="Diagnosis"/></div>
        </div>
        <input type="submit" name="submit" value="Submit"/>
         <?php echo form_close();?> 
        </div><!-- //tab4 -->
    </div><!-- //tab Details -->
 </div>
 <?php } ?>
    
    </body></html>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>	
<script type="text/javascript">
function checkpassword()
{
	var pwd='<?=$data?>';
	
	var oldpwd=$("#old_password").val();
	var newpwd=$("#new_password").val();
	var cnfmpwd=$("#confirm_password").val();
	if(newpwd!=cnfmpwd){
		alert("New password and Confirm Password do not matched");
		$("#confirm_password").focus();
		return false;
	}
	
	if(oldpwd!=pwd){
		alert("You have enter a wrong password");
		$("#old_password").focus();
		return false;
	}
	
	return true;
}


$(document).ready(function() {
	jQuery.noConflict();
    $('#btnAdd').click(function() {
		
		
        var $address = $('#address');
        var num = $('.clonedAddress').length; // there are 5 children inside each address so the prevCloned address * 5 + original
        var newNum = new Number(num + 1);
        var newElem = $address.clone().attr('id', 'address' + newNum).addClass('clonedAddress');
        
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
        if ($('.clonedAddress').length == 0) {
            $('#btnDel').attr('disabled', 'disabled');
        }
    });
    $('#btnDel').attr('disabled', 'disabled');
});

$(document).ready(function() {
	jQuery.noConflict();
	var nextRowID = 0;
	
    $('#btnAdd1').click(function() {
		
		var newid = ++nextRowID;
        var $address1= $('#address1');
        var num = $('.clonedAddress').length; // there are 5 children inside each address so the prevCloned address * 5 + original
        var newNum = new Number(num + 1);
        var newElem = $address1.clone().attr('id', 'address1' + newNum).addClass('clonedAddress');
		
		 var total=$("#total").attr('value',newid);
	   
	   var fname='<div class="ld1"><input type="text"  name="rotation" id="rotation'+newid+'" value="" required/></div>';
	   var lname='<div class="ld1"><input type="text"  name="rotation_year" id="rotation_year'+newid+'" value="" required/></div>';
        
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
            $address1.after(newElem);
        }
            

        $('#btnDel1').removeAttr('disabled');
            
        if (newNum == 7) $('#btnAdd1').attr('disabled', 'disabled');
    });
    $('#btnDel1').click(function() {
        $('.clonedAddress:last').remove();
        $('#btnAdd1').removeAttr('disabled');
		$("#total").attr('value',$('.clonedAddress').length);
        if ($('.clonedAddress').length == 0) {
            $('#btnDel1').attr('disabled', 'disabled');
        }
		--nextRowID;
    });
    $('#btnDel1').attr('disabled', 'disabled');
});


$(document).ready(function() {
	jQuery.noConflict();
    $('#btnAdd2').click(function() {
		
		
        var $address2= $('#address2');
        var num = $('.clonedAddress').length; // there are 5 children inside each address so the prevCloned address * 5 + original
        var newNum = new Number(num + 1);
        var newElem = $address2.clone().attr('id', 'address2' + newNum).addClass('clonedAddress');
        
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
            $address2.after(newElem);
        }
            

        $('#btnDel2').removeAttr('disabled');
            
        if (newNum == 7) $('#btnAdd2').attr('disabled', 'disabled');
    });
    $('#btnDel2').click(function() {
        $('.clonedAddress:last').remove();
        $('#btnAdd2').removeAttr('disabled');
        if ($('.clonedAddress').length == 0) {
            $('#btnDel2').attr('disabled', 'disabled');
        }
    });
    $('#btnDel2').attr('disabled', 'disabled');
});
//----------------end---------------------------------------->	
$(document).ready(function() {
	jQuery.noConflict();
		$(".tabContents").hide(); // Hide all tab content divs by default
		$(".tabContents:first").show(); // Show the first div of tab content by default
		
		$(".tabContaier ul li a").click(function(){ //Fire the click event
			
			var activeTab = $(this).attr("href"); // Catch the click link
			$(".tabContaier ul li a").removeClass("active"); // Remove pre-highlighted link
			$(this).addClass("active"); // set clicked link to highlight state
			$(".tabContents").hide(); // hide currently visible tab content div
			$(activeTab).fadeIn(); // show the target tab content div by matching clicked link.
			
			return false; //prevent page scrolling on tab click
		});
	
//----------------end---------------------------------------->		
		$(".tabContents1").hide(); // Hide all tab content divs by default
		$(".tabContents1:first").show(); // Show the first div of tab content by default
		
		$(".tabContaier1 ul li a").click(function(){ //Fire the click event
			
			var activeTab1 = $(this).attr("href"); // Catch the click link
			$(".tabContaier1 ul li a").removeClass("active"); // Remove pre-highlighted link
			$(this).addClass("active"); // set clicked link to highlight state
			$(".tabContents1").hide(); // hide currently visible tab content div
			$(activeTab1).fadeIn(); // show the target tab content div by matching clicked link.
			
			return false; //prevent page scrolling on tab click
		});
		
		
		$(".tabContents2").hide(); // Hide all tab content divs by default
		$(".tabContents2:first").show(); // Show the first div of tab content by default
		
		$(".tabContaier2 ul li a").click(function(){ //Fire the click event
			
			var activeTab2 = $(this).attr("href"); // Catch the click link
			$(".tabContaier2 ul li a").removeClass("active"); // Remove pre-highlighted link
			$(this).addClass("active"); // set clicked link to highlight state
			$(".tabContents2").hide(); // hide currently visible tab content div
			$(activeTab2).fadeIn(); // show the target tab content div by matching clicked link.
			
			return false; //prevent page scrolling on tab click
		});
//----------------end---------------------------------------->		
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
	
	$('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox11').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox11').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
   
   $('#selecctall2').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox2').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox2').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

   
});

</script>	
</body>

