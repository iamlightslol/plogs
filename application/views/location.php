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
   <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>form.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
	<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script> 


<body>

  <?php include('header.php');?>
<div class="three">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1" >View Location Data</a></li>
            <li><a href="#tabs-2" >Add New Location</a></li>
        </ul> 
    <div id="tabs-1">
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
    </div>
    <div id="tabs-2">
        <h2>Add Location Data</h2>
            <p align="center"><?php echo isset($info)?$info:'';?></p>
            
        <button id="btnAdd">Add</button><button id="btnDel">Delete</button>
       <?php echo form_open("dashboard/addlocation");?> 
        
        <input type="hidden" name="id" value="<?php echo $this->session->userdata['id']; ?>"/>
        <div id="address">
        <div class="ld"><input type="text"  name="location[]" id="location" required placeholder="Location"/></div>
        </div>
        <input type="submit" name="submit" value="Submit"/>
         <?php echo form_close();?> 
     </div>
    
   </div> 
</div>
</body>
<script language="javascript">
$(document).ready(function() {
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
$("#tabs").tabs();

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

