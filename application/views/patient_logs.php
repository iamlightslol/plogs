<?php
ob_start();
session_start();
date_default_timezone_set('Canada/Eastern');
if($this->session->userdata['userid']=='')
{
	redirect(base_url());
}
if($this->session->userdata['status']=='1'){ 
$org_id="";
}
else
{
	$org_id=$this->session->userdata['org_id'];
}
$res_year=$this->session->userdata['year'];
/*$rdata=$this->org_model->get_rotation_data1($org_id);
$ddata=$this->org_model->get_dignosis_data1($org_id);
$ldata=$this->org_model->get_location_data1($org_id);
$cln='"';

foreach (range(1, $res_year) as $number) {
$rsd_year[]="{display: ".$cln.$number.$cln.", value: ".$cln.$number.$cln." }";	
}
$resid_year=implode(",",$rsd_year);

if(!empty($rdata) && !empty($ddata) && !empty($ldata)):
foreach($rdata as $v):
$a[]="{display: ".$cln.$v->rotation_name.$cln.", value: ".$cln.$v->rotation_name.$cln." }";
endforeach;
$rt=implode(",",$a);

foreach($ddata as $v):
$b[]="{display: ".$cln.$v->diagnosis_name.$cln.", value: ".$cln.$v->diagnosis_name.$cln." }";
endforeach;
$dig=implode(",",$b);

foreach($ldata as $v):
$c[]="{display: ".$cln.$v->location_name.$cln.", value: ".$cln.$v->location_name.$cln." }";
endforeach;
$loc=implode(",",$c);
endif;*/
?>
 <style>
      a {text-decoration: none;}
   </style>
  
 	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jquery.autocomplete.css" type="text/css" />
    <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    
   	  <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
      <script language="javascript" src="<?php echo HTTP_JS_PATH; ?>list14-2.js"></script> 
       <script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
	  
     
		<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>
        
        <script type='text/javascript' src='<?php echo HTTP_JS_PATH; ?>jquery-1.7.2.js'></script>
      <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery-1.8.18.js"></script>
      
   
  
  
    
<body>

  <?php include('header.php');?>
      
      			<!--<h4 align="center">View By:
       			
               <select id="viewdata" style="width:150px; height:35px;">
               <option>--Select--</option>
              <option>Month</option>
              <option>Rotation</option>
             <option>Residency_Year</option>
             <option>Location</option>
             <option>Diagnosis</option>
            </select>
           <select id="city" style="width:150px; height:35px;" onChange="get_result()">
           </select>--></h4></h4>
           <div class="skn" id="divToPrint">
           <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
           <script>
		   $( "table tbody:odd" ).css( "background-color", "#fff" );
			$( "table tbody:even" ).css( "background-color", "#fff" );
		   </script>
           <P align="right" class="lst"><a href="#dialog5" class="button add" name="modal" nts="addnew" rotdata="<?php echo isset($rotdata)?$rotdata:'';?>">+ ADD NEW</a></P><h1 align="center">Patient Logs </h1>
           <p align="center" style="color:lightseagreen; font-size:18px;"><?php echo isset($info)?$info:'';?></p>
         
                <?php
				$datas=$this->user_model->get_unique_date($this->session->userdata['id'],$res_year);
			
				if(!empty($datas)){
				foreach($datas as $m=>$vk){
					
					$total_encounter_data=$this->user_model->get_total_encounter_data($this->session->userdata['id'],$vk->doj,"");
				
				?>
               
               
                <b><a ID="xproducts<?php echo $m;?>" href="javascript:Toggle('products<?php echo $m;?>');">[+]</a><?php 
				
					$month=date("m",strtotime($vk->doj));
					$day=date("d",strtotime($vk->doj));
					$years=date("Y",strtotime($vk->doj));
					if($month=='01'){ $newmonth="January";} else if($month=='02'){ $newmonth="February";} else if($month=='03'){ $newmonth="March";} else if($month=='04'){ $newmonth="April";} else if($month=='05'){ $newmonth="May";} else if($month=='06'){ $newmonth="June";} else if($month=='07'){ $newmonth="July";} else if($month=='08'){ $newmonth="August";} else if($month=='09'){ $newmonth="September";} else if($month=='10'){ $newmonth="October";} else if($month=='11'){$newmonth="November";} else if($month=='12'){ $newmonth="December";} 
					
					echo " ".$newmonth." ".$day.",".$years."&nbsp;[".$total_encounter_data."]";?></b><br>
                   
               
				
                   <div ID="products<?php echo $m;?>" style="display:none; margin-left:2em;" class="pt-details">
            <?php 
			$res=$this->user_model->get_distinct_name($this->session->userdata['id'],$vk->doj);
			foreach($res as $k=>$r){
			 $patient_data=$this->user_model->get_patient_detail_according_date($this->session->userdata['id'],$r->patient_unique_id,$vk->doj);
				foreach($patient_data as $v){
					
					$total_encounter_patient=$this->user_model->get_total_encounter_data($this->session->userdata['id'],$vk->doj,$v->patient_unique_id);
					
					
					if($total_encounter_patient=='1'){?>
                    
                    <ul>
                   <li class="time"><?php echo $v->fld_cur_time; ?>                   </li>
                   <li class="dept"><?php echo ucfirst($v->rotation);?></li>
                   <li class="desc"><?php echo isset($v->patient_number)?ucfirst($v->patient_number):'';?> is a 
				   		<?php if($v->years!=''){echo $v->years." old ";}echo ucfirst($v->patient_gender);
					?> with  <span><?php echo $v->primary_diagnosis;?></span><?php  if($v->secondary_diagnoses!=''){ ?> and <span><?php echo $v->secondary_diagnoses;} else { echo '';?></span><?php } ?>.</li>
                     <?php if($v->comments!=''){echo "<li class='cmnt' color='red'>".ucfirst($v->comments)."</li>";}?>
                      <li class="btns">
             <a href="#dialog" name="modal" pname="<?php echo $v->patient_number; ?>">COPY TO TODAY</a>|
             <a href="#dialog1" name="modal" pid="<?php echo $v->patient_id; ?>">COPY TO DATE</a>|
             <a href="#dialog2" name="modal" p_name="<?php echo $v->patient_number; ?>" rot="<?php echo $v->rotation; ?>">CHANGE DIAGNOSIS</a>|
             <a href="javascript:void(0)" onClick="deleterecord(<?php echo $v->patient_id;?>)">DELETE</a>
                     </li>  
                     <div class="clr"></div>
                     </ul>
                                     
                     <?php } else { ?>
                   <ul>
                   <li class="time">  
                     <a ID="xspecs<?php echo $m.$k;?>" href="javascript:Toggle('specs<?php echo $m.$k;?>');" class="xspecs">[+]</a> &nbsp; [<?php echo $total_encounter_patient;?>]&nbsp;<?php echo $v->fld_cur_time; ?> </li>
                    <li class="dept"><?php echo ucfirst($v->rotation);?></li> 
					<li class="desc"><?php echo isset($v->patient_number)?ucfirst($v->patient_number):'';?> is a  		<?php if($v->years!=''){echo $v->years." old ";}echo ucfirst($v->patient_gender);?>                  
                   with  <span><?php echo $v->primary_diagnosis;?></span><?php  if($v->secondary_diagnoses!=''){ ?> and <span><?php echo $v->secondary_diagnoses;} else { echo '';?></span><?php } ?>.</li>
					 <?php if($v->comments!=''){echo "<li class='cmnt'>".ucfirst($v->comments)."</li>";}?>
                     <li class="btns">
             <a href="#dialog" name="modal" pname="<?php echo $v->patient_number; ?>">COPY TO TODAY</a>|
             <a href="#dialog1" name="modal" pid="<?php echo $v->patient_id; ?>">COPY TO DATE</a>|
             <a href="#dialog2" name="modal" p_name="<?php echo $v->patient_number; ?>" rot="<?php echo $v->rotation; ?>">CHANGE DIAGNOSIS</a>|
             <a href="javascript:void(0)" onClick="deleterecord(<?php echo $v->patient_id;?>)">DELETE</a>
                     </li> 
                     <div class="clr"></div>
                     </ul>
                     
                    
                     <?php } ?>

 <div ID="specs<?php echo $m.$k;?>" style="display:none; margin-left:2em">
<?php $ptnt_data=$this->user_model->get_remaining_data($this->session->userdata['id'],$v->patient_unique_id,$vk->doj,$total_encounter_patient);

foreach($ptnt_data as $a=>$n){?>
      <ul>
	  <li class="time"><?php echo $n->fld_cur_time; ?></li>
      
       <li class="desc">
	   <?php echo isset($n->patient_number)?ucfirst($n->patient_number):'';?>  is a   				
       <?php if($n->years!=''){echo $n->years." old ";}echo ucfirst($n->patient_gender);?>
       with 
       <span><?php if($n->primary_diagnosis!=''){echo $n->primary_diagnosis;}?></span> and <span><?php if($n->secondary_diagnoses!=''){ echo $n->secondary_diagnoses;} else { echo '';} ?></span>.</li>
	   <?php if($n->comments!=''){echo "<li class='cmnt'>".ucfirst($n->comments)."</li>";}?>
      
	  </ul>
<?php }?>
   </div>
                  
                   
                 
                   <?php } }?>
                   </div><br>
                
             
                
               
				<?php } }?>
                
       
         
          
           </div>
              
<!---------------for popup---------------------->
<div id="boxes">

<div id="dialog" class="window txt">

<a href="#" class="close"></a>

<?php echo form_open('dashboard/addnewencounter');?>
 <input type="hidden" name="patient_name" id="patient_name"/>
 <input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/>
 <input type="hidden" name="curnt_date" value="<?php echo date("Y/m/d",time());?>"/>
  <p>Pick a Time:</p>
 <select name="current_time">
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
 <p>Comment/Note:
  <textarea name="comments" rows="1" cols="1" required></textarea>
 <input type="submit" name="addcomment" value="Submit"/>
 <?php echo form_close();?>

</div>


<div id="dialog1" class="window txt">

<a href="#" class="close"></a>

<?php echo form_open('dashboard/addnewdatetime');?>
 <input type="hidden" name="patient_id" id="patient_id"/>
 <input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/>
 <p>Pick a Date:</p>
 <input type="text" name="current_date" class="tcal" value="<?php echo date("m/d/Y",time());?>" required/>
 <p>Pick a Time:</p>
 <select name="current_time">
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
 <p>Comment/Note:
  <textarea name="comments" rows="1" cols="1" required></textarea>
 <input type="submit" name="addcomment" value="Submit"/>
 <?php echo form_close();?>

</div>

<div id="dialog2" class="window txt">

<a href="#" class="close"></a>

<?php echo form_open('dashboard/addnewdiagnosis');?>
 <input type="hidden" name="patient_name" id="p_name"/>
 <input type="hidden" name="org_id" value="<?php echo $this->session->userdata['org_id'];?>"/>
 <input type="hidden" name="rotation" id="rotation"/>
 <input type="hidden" name="resident_id" value="<?php echo $this->session->userdata['id'];?>"/>
 <div id="ntr"></div>
 <input type="submit" name="addcomment" value="Submit"/>
 <?php echo form_close();?>

</div>

<div id="dialog5" class="window txt">

<a href="#" class="close"></a>


 <div id="nkbs"></div>


</div>


    <div id="mask"></div>
    
</div>
<div class="prnt"><input type="button" style="margin-bottom:20px;width:120px; height:40px;font-size: 20px" onClick="PrintDiv();" value="Print"></div>
</body>


<script language="javascript">
	
	
	/* Pop Up Code */
$(document).ready(function(){
$('a[name=modal]').click(function(e) {
  //Cancel the link behavior
 
  e.preventDefault();
  
  //Get the A tag
  var id = $(this).attr('href');
  var pname = $(this).attr('pname');
  var pid = $(this).attr('pid');
  var p_name = $(this).attr('p_name');
  var rot = $(this).attr('rot');
  var nts = $(this).attr('nts');
  var rotdata = $(this).attr('rotdata');
  var patient_name=$("#patient_name").attr('value',pname);
  var patient_id=$("#patient_id").attr('value',pid);
  var pnames=$("#p_name").attr('value',p_name);
  var rotation=$("#rotation").attr('value',rot);
  
  if(nts!=''){
  var data="nts="+nts+"&rotdata="+rotdata;
	$.ajax({
			type:"post",
			url:"<?=base_url()?>dashboard/addnewpatient",
			data:data,
			success:function(response)
			{
				//alert(response);
				if(response!='')
				{
				$("#nkbs").html(response);
				}
			}
		});
  }
  
  if(rot!=''){
  var data="rotation="+rot;
	$.ajax({
			type:"post",
			url:"<?=base_url()?>dashboard/getdgns",
			data:data,
			success:function(response)
			{
				//alert(response);
				if(response!='')
				{
				$("#ntr").html(response);
				}
			}
		});
  }
  //Get the screen height and width
  var maskHeight = $(document).height();
  var maskWidth = $(window).width();
 
  //Set heigth and width to mask to fill up the whole screen
  $('#mask').css({'width':maskWidth,'height':maskHeight});
  
  //transition effect  
  $('#mask').fadeIn(1000); 
  $('#mask').fadeTo("slow",0.8); 
 
  //Get the window height and width
  var winH = $(window).height();
  var winW = $(window).width();
              
  //Set the popup window to center
  $(id).css('top',  winH/2-$(id).height()/2);
  $(id).css('left', winW/2-$(id).width()/2);
 
  //transition effect
  $(id).fadeIn(2000); 
 
 });
 
 //if close button is clicked
 $('.window .close').click(function (e) {
	
  //Cancel the link behavior
  e.preventDefault();
  
  $('#mask').hide();
  $('.window').hide();
 });  
 
 //if mask is clicked
 $('#mask').click(function () {
  $(this).hide();
  $('.window').hide();
 });
 
});






 


 function PrintDiv() {
	 
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=300,height=300');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
				
				
function deleterecord(pid)
{
	var data="pid="+pid;
	if (!confirm("Do you want to delete")){
      return false;
    }
	$.ajax({
			type:"post",
			url:"<?=base_url()?>dashboard/delete_record",
			data:data,
			success:function(response)
			{
				
				if(response!='')
				{
					location.reload();
				}
			}
		});
}
 </script>




