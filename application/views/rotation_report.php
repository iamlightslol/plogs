<?php
ob_start();
session_start();
date_default_timezone_set('Canada/Eastern');
if($this->session->userdata['userid']==''){redirect(base_url());}

if($this->session->userdata['status']=='1'){ 
$id=$this->uri->segment(3);
$org_id=$this->session->userdata['id'];
$res_year=$this->uri->segment(4);
}

else{
 $id=$this->session->userdata['id'];
$org_id=$this->session->userdata['org_id'];
$res_year=$this->session->userdata['year'];
}

$rdata=$this->org_model->get_rotation_data2($id,$res_year);

/*$ddata=$this->org_model->get_dignosis_data2($id,$res_year);*/

/*$ldata=$this->org_model->get_location_data1($org_id);*/

$cln='"';
if(!empty($rdata)):
foreach($rdata as $v):
$a[]="{display: ".$cln.$v->rotation.$cln.", value: ".$cln.$v->rotation.$cln." }";
endforeach;
$rt=implode(",",$a);

/*foreach($ddata as $v):
$b[]="{display: ".$cln.$v->primary_diagnosis.$cln.", value: ".$cln.$v->primary_diagnosis.$cln." }";
endforeach;
$dig=implode(",",$b);*/

/*foreach($ldata as $v):
$c[]="{display: ".$cln.$v->location_name.$cln.", value: ".$cln.$v->location_name.$cln." }";
endforeach;
$loc=implode(",",$c);*/
endif;

$resident_info=$this->report_model->get_resident_data($id);
$total_patient=$this->report_model->total_roation_patient($id,"","",$res_year);
$total__distinct_patient=$this->report_model->total__distinct_patient($id,"","",$res_year);
foreach($resident_info as $v):
$org_id=$v->org_id;
$resident_name=ucfirst($v->p_first_name)." ".ucfirst($v->p_last_name);
endforeach;
$date=date("Y");
$min_date=$this->report_model->min_date($id,"","",$res_year);
$mini=$date-date("Y",strtotime($min_date));

$max_date=$this->report_model->max_date($id,"","",$res_year);
$maxi=$date-date("Y",strtotime($max_date));

$total_male=$this->report_model->total_male($id,"","",$res_year);
$total_female=$this->report_model->total_female($id,"","",$res_year);

$age_group=$this->report_model->age_group($id,"","",$res_year,"0","1");
$age_group1=$this->report_model->age_group($id,"","",$res_year,"1","5");
$age_group2=$this->report_model->age_group($id,"","",$res_year,"5","18");
$age_group3=$this->report_model->age_group($id,"","",$res_year,"18","65");
$age_group4=$this->report_model->age_group($id,"","",$res_year,"65","");

$data=$this->report_model->get_dignosis_list_for_report($id,"","",$res_year);
$rotation=$this->report_model->get_rotation_for_report($id,$res_year);
$sdiagnossis_for_report=$this->report_model->scndary_diagnosis_for_report($id,$org_id,$res_year,"","");
?>


   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link href="<?php echo HTTP_CSS_PATH; ?>stylesheet.css" rel="stylesheet">
	<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>

<script>
$(document).ready(function(){

//Initializing arrays with city names
var Month = [
    {display: "January", value: "1" }, 
    {display: "February", value: "2" }, 
    {display: "March", value: "3" },
	{display: "April", value: "4" },
	{display: "May", value: "5" },
	{display: "June", value: "6" },
	{display: "July", value: "7" },
	{display: "August", value: "8" },
	{display: "September", value: "9" },
	{display: "October", value: "10" },
	{display: "November", value: "11" },
    {display: "December", value: "12" }];

var Rotation = [<?php echo $rt;?>];
  
/*var Residency_Year = [
    {display: "1", value: "1" }, 
    {display: "2", value: "2" }, 
    {display: "3", value: "3" },
	{display: "4", value: "4" },
	{display: "5", value: "5" },
	{display: "6", value: "6" },
	{display: "7", value: "7" },
	{display: "8", value: "8" },
	{display: "9", value: "9" },
    {display: "10", value: "10" }];
	*/
	
	<?php /*?>var Location = [<?php echo $loc;?>];<?php */?>
	
	<?php /*?>var Diagnosis = [<?php echo $dig;?>];<?php */?>

//Function executes on change of first select option field 
$("#viewdata").change(function(){

var select = $("#viewdata option:selected").val();

switch(select){
case "Month":
	city(Month);
break;

case "Rotation":
	city(Rotation);
break;

/*case "Residency_Year":
	city(Residency_Year);
break;*/

/*case "Location":
	city(Location);
break;*/

case "Diagnosis":
	city(Diagnosis);
break;

default:
	$("#city").empty();
	$("#city").append("<option>--Select--</option>");
break;
}
});

//Function To List out Cities in Second Select tags
function city(arr){
	$("#city").empty();//To reset cities
	$("#city").append("<option>--Select--</option>");
	$(arr).each(function(i){//to list cities
		$("#city").append("<option value=\""+arr[i].value+"\">"+arr[i].display+"</option>")
	});
}

});

function get_result(){
		var res=$("#viewdata option:selected").text();
		if(res=="Month"){ var type="months"; }
		else if(res=="Rotation"){ var type="rotation"; }
		else if(res=="Residency_Year"){ var type="residency_year"; }
		else if(res=="Location"){ var type="location"; }
		else if(res=="Diagnosis"){ var type="primary_diagnosis"; }
		var value=$("#city option:selected").val();
		var rid="<?=$id;?>";
		var res_year="<?=$res_year;?>";
		var org_id="<?=$org_id;?>";
		var data="type="+type+"&rid="+rid+"&value="+value+"&res_year="+res_year+"&org_id="+org_id;
		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>report/getsearchdata",
			data:data,
			success:function(response)
			{
				
				if(response!='')
				{
					$(".acf").hide();
					$(".acn").html(response);
				}
			}
		});
}



function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=300,height=300');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>

<body>

 <?php include('header.php');?>
 <h5 align="center">View By:
       			
               <select id="viewdata" style="width:150px; height:25px;">
               <option>--Select--</option>
              <option>Month</option>
              <option>Rotation</option>
            <!-- <option>Residency_Year</option>-->
            <!-- <option>Location</option>-->
             <!--<option>Diagnosis</option>-->
            </select>
           <select id="city" style="width:150px; height:25px;" onChange="get_result()">
           </select><input type="button" style=" margin-left:20px;width:100px; height:25px;font-size: 1px" onClick="PrintDiv();" value="Print"></h5>
<div class="maindiv" id="divToPrint">
	<link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link href="<?php echo HTTP_CSS_PATH; ?>stylesheet.css" rel="stylesheet">
	<div class="acf"> 	
    <div class="conatainer">
    <div class="heading">
    <h2 align="center">Report</h2>
    <h1>Dr.<?php echo $resident_name;?></h1>
   
    </div>
    
    <div class="content">
    <ul class="hm">
    <li>Total patients logged: <?php echo $total__distinct_patient;?></li>
    <li>Total Male: <?php echo $total_male ;?></li>
    <li>Total encounters documented: <?php echo $total_patient;?></li>
    <li>Total Female: <?php echo $total_female ;?></li>
  
    </ul>
    <p class="hm"><b>Age Groups:</b>&nbsp;&nbsp;0-1= <?php if($total__distinct_patient!='0'){echo number_format($age_group*100/$total__distinct_patient, 2);}?>%&nbsp;&nbsp;1-5= <?php if($total__distinct_patient!='0'){echo number_format($age_group1*100/$total__distinct_patient, 2);}?>%&nbsp;&nbsp;5-18= <?php if($total__distinct_patient!='0'){echo number_format($age_group2*100/$total__distinct_patient, 2);}?>%&nbsp;&nbsp;18-65= <?php if($total__distinct_patient!='0'){echo number_format($age_group3*100/$total__distinct_patient, 2);}?>%&nbsp;&nbsp;&nbsp;>65= <?php if($total__distinct_patient!='0'){echo number_format($age_group4*100/$total__distinct_patient, 2);}?>%  </p>
    
  
  
    <div class="para">
    <p class="hm"><strong>Rotations:&nbsp;<?php  $cnt=0;foreach($rotation as $v): $cnt++;endforeach;echo $cnt;?></strong></p></div>
    <div class="list">
    <ul class="nk">
    <?php 
    foreach($rotation as $v):
    ?>
    <li><?=$v->rotation;?>[<?=$v->total;?>]</li>
    <?php endforeach;?>
    </ul></div>
   
   
    <div class="catgry1">
    <div class="para">
    <p class="hm"><strong>Primary Diagnoses Encountered:&nbsp;<?php  $cnt=0;foreach($data as $v): $cnt++;endforeach;echo $cnt;?></strong></p></div>
    <div class="list">
    <ul class="nk">
    <?php 
    foreach($data as $v):
	$total_unique_diagnosis=$this->report_model->total_unique_diagnosis($id,$res_year,$v->primary_diagnosis,"","");
    ?>
    <li><?=$v->primary_diagnosis;?>[<?=$total_unique_diagnosis;?>]</li>
    <?php endforeach;?>
    </ul></div>
    </div>
   
    <div class="para">
    <p class="hm"><strong>Secondary Diagnoses Encountered:&nbsp;<?php $cnt1=0;foreach($sdiagnossis_for_report as $k=>$v): if($v!='0') { $cnt1++;}endforeach; echo $cnt1;?></strong></p></div>
    <div class="list">
    <ul class="nk">
    <?php 
	
	if(!empty($sdiagnossis_for_report)){
    foreach($sdiagnossis_for_report as $k=>$v):
	if($v!='0') { ?>
    <li><?=$k;?>[<?=$v;?>]</li>
    <?php } endforeach; };?>
    </ul></div>
   <!-- <p class="hm">By signing this document you are agreeing the above information is true.</p>-->
    <?php /*?><div class="dr-name">
    <div class="lt"><hr style="width:65%; height:1px;"/>Supervisor Name</div>
    <div class="rt"><hr style="width:75%; height:1px;"/><?php echo $resident_name;?></div>
    </div><?php */?>
    <!--<div class="dr-name1">
    <div class="lt"><hr style="width:65%; height:1px;"/>Supervisor Signature</div>
    </div>-->
    <div class="clr"></div>
    
    </div>
    
    
    </div>
    </div>
    <div class="acn"></div>
    
	
</div>

</body>
<!------------------------------Garph Report Start-------------------------------->
<!--<div>
    <h4 align="center" style="margin:20px 0px 10px;">View By:
                    
                   <select id="grph" style="width:150px; height:35px;" onChange="get_graph_data()">
                   <option>--Select--</option>
                  <option>Age</option>
                  <option>Rotation</option>
                 <option>Primary Diagnosis</option>
                 <option>Gender</option>
                 <option>Difficulty of Case</option>
                </select>
                <p>[Choose options for Graph Report]</p>
    </h4>
    <div id="skr"></div>
</div>-->
<script>
function get_graph_data()
{
		var type=$("#grph option:selected").text();
		var rid="<?=$id;?>";
		var data="type="+type+"&rid="+rid;
		//alert(data);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>report/getgraphdata",
			data:data,
			success:function(response)
			{
				//alert(response);
				if(response!='')
				{
					$("#skr").html(response);
				}
			}
		});
}
</script>            