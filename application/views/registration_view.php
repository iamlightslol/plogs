<?php
date_default_timezone_set('America/Los_Angeles');
?>

   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>



<body>

  <div id="wrap">
  <div id="regbar"></div>
  
    <div id="navthing"></div>
      <h2></h2>
    </div>
      
      
       			<?php echo form_open('welcome/patienlog');?>
	    		<table class="tbl">
                <tr><td colspan="2" align="center"><font color="#FF0000"><?php echo isset($info)? $info:'';?></font></td></tr>
                <tr>
                    <td class="lft"><b>Date</b></td>
                    <td class="rgt"><input type="text" name="date" class="tcal" value="<?php echo date("d/m/Y");?>" /></td>
                </tr>
                <tr>
                    <td class="lft"><b>Patient Number/Patient initials</b></td>
                    <td class="rgt"><input type="text"  name="pnumber" id="pnumber" /></td>
                </tr>
                
                <tr>
                    <td class="lft"><b>Age</b></td>
                    <td class="rgt">Day&nbsp;<select name="day"><?php foreach(range(1,31) as $num){?><option value="<?php echo $num;?>"><?php echo $num;?></option>
				<?php	} ?>
                </select>&nbsp;&nbsp;
                Month&nbsp;<select name="month"><?php foreach(range(1,12) as $num){?><option value="<?php echo $num;?>"><?php echo $num;?></option>
				<?php	} ?>
                </select>&nbsp;&nbsp;
                Year&nbsp;<select name="year"><?php foreach(range(1950,2050) as $num){?><option value="<?php echo $num;?>"><?php echo $num;?></option>
				<?php	} ?>
                </select>
					</td>
                </tr>
                
                <tr>
                    <td class="lft"><b>Gender</b></td>
                    <td class="rgt" style="height:50px;"><input type="radio" name="gen"  value="male" checked/>&nbsp;male&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gen" value="female"/>&nbsp;female</td>
                </tr>
                
                <tr>
                    <td class="lft"><b>Diagnosis</b></td>
                    <td class="rgt"><input type="checkbox" name="dgns[]" value="1">&nbsp;Type1&nbsp;&nbsp;&nbsp;<input type="checkbox" name="dgns[]" value="2">&nbsp;Type2&nbsp;&nbsp;&nbsp;<input type="checkbox" name="dgns[]" value="3">&nbsp;Type3&nbsp;&nbsp;&nbsp;<input type="checkbox" name="dgns[]" value="4">&nbsp;Type4</td>
                </tr>
               
             	<tr>
                    <td class="lft"><b>Difficulty of case slide</b></td>
                    <td class="rgt"><input type="text" id="amount" name="amount" readonly style="border:0; color:#f6931f; font-weight:bold; width:50px; background-color:#EFEFEF;"></label>
                   <div id="slider-range-min"></div></td>
                </tr>
                
                <tr>
                    <td class="lft"><b>Rotation</b></td>
                    <td class="rgt" style="height:50px;"><input type="radio" name="rto" value="1" checked/>&nbsp;Type1&nbsp;&nbsp;&nbsp;<input type="radio" name="rto" value="2"/>&nbsp;Type2&nbsp;&nbsp;&nbsp;<input type="radio" name="rto" value="3"/>&nbsp;Type3&nbsp;&nbsp;&nbsp;<input type="radio" name="rto" value="4"/>&nbsp;Type4</td>
                </tr>
                
                <tr>
                    <td class="lft"><b>Notes</b></td>
                    <td class="rgt"><textarea name="notes" rows="1" cols="1"></textarea></td>
                </tr>
                
                <tr>
              
                    <td class="rgt" colspan="2" align="center" style="height:40px;"><input type="submit" name="submit" value="Submit" id="remembers" onClick="return formvalidation();"/><a href="<?php echo base_url();?>welcome/logs">View Previous Logs</a></td>
                </tr>
                </table>
              	<?php echo form_close(); ?>
                
			
    


</body>



<script>

$(function() {
$( "#slider-range-min" ).slider({
range: "min",
value: 37,
min: 0,
max: 100,
slide: function( event, ui ) {
$( "#amount" ).val(ui.value + "%" );
}
});
$( "#amount" ).val($( "#slider-range-min" ).slider( "value" )+ "%" );
});

function formvalidation()
{
	var tcal=$(".tcal").val();
	var pnumber=$("#pnumber").val();
	if(tcal=='')
	{
		alert("Enter date");
		$(".tcal").focus();
		return false;
	}
	if(pnumber=='')
	{
		alert("Enter patient number");
		$("#pnumber").focus();
		return false;
	}
	return true;
}
</script>


























