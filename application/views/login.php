

   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
	<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>


<body>

  <!--<div id="wrap">
  <div id="regbar">
  <div class="right">
  <p>Patient-logs<span>.com</span></p>
  <p class="cc">Customize your web presence</p>
  </div>
  <div class="left">ADMINISTRATIVE SECTION</div>
  
  
  </div>
  
    <div id="navthing"></div>
     
    </div>-->
    <?php include('header.php');?>
      <div class="heading">
	  <h1>Log In</h1>
	  </div>
      <!--<div class="formholder">-->
        <div class="randompad">
		
		<?php echo form_open("welcome/login"); ?>
        <?php echo isset($msg)?$msg:'';?>
           <fieldset>
             <label name="name"><b>Username</b></label>
             <input type="text"  name="username"  placeholder="username" required/>
             <label name="password"><b>Password</b></label>
             <input type="password" placeholder="password"  id="password" name="password" required />
             <p><input type="checkbox" name="chk"/>&nbsp;&nbsp;Log me in automatically</p>
             <input type="submit" value="Log in" id="remembers">

           </fieldset>
		   <?php echo form_close(); ?>
        </div>
    <?php /*?> <!-- </div>-->
         <div class="heading">   <h1>Organization Sign up</h1></div>
   <!-- <div class="formholder">-->
        <div class="randompad">
		<?php echo validation_errors('<p class="error">'); ?>
        <font color="#FF0000"><?php echo isset($org)? $org:'';?></font>
		
        <form name="frmrg" id="frmrg" method="post" action="residents/register">
           <fieldset>
          
           <label name="name"><b>Name of Organization</b></label>
            <input type="text"  name="org_name"  placeholder="Enter Organization Name" required/>
            <label name="name"><b>Username</b></label>
            <input type="text"  name="org_user_username" id="org_user_username"  placeholder="Enter Your Username" autocomplete="off" required/><img src="<?php echo base_url();?>assets/images/yes.png" id="right" style="display:none; position:absolute; margin:-2% 0 0 17%;"/><img src="<?php echo base_url();?>assets/images/no.png" id="cross" style="display:none; position:absolute; margin:-2% 0 0 17%;"/>
             <label name="password"><b>Password</b></label>
             <input type="password" placeholder="Enter Your Password"  name="org_password" id="org_password" required /><label name="password"><b>Re Password</b></label>
             <input type="password" placeholder="Enter Again Password" name="org_repassword" id="org_repassword" required />
              <label name="name"><b>Price</b></label>
            <input type="text"  name="price" id="price"  placeholder="0000" required/>
             <input type="submit" value="Register" id="remembers" name="Register" onClick="return check_validation()">

           </fieldset>
		   </form>
        </div>
      <!--</div>--><?php */?>
</body>

<script language="javascript">
$(document).ready(function() {	

	$("#frmrg").submit(function(){
		
		
		if($("#cross").is(':visible'))
		{
			$("#org_user_username").focus();
			return false;
		}
		if($("#org_password").val()!=$("#org_repassword").val())
		{
			alert("password and confirm password doesn't matched.....!");
			$("#org_repassword").focus();
			return false;
		}
		if(isNaN($("#price").val()))
		{
			alert("Enter Only Numeric Data...!");
			$("#price").focus();
			return false;
		}
		
	});
	
	   $("#org_user_username").keyup(check_name);
	  
		function check_name()
		{ 
		
		  $.ajax({
		   type: "POST",
		   url: "<?php echo base_url();?>welcome/check_user",
		   data: "name="+$("#org_user_username").val(),
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


</script>