<?php

date_default_timezone_set('Canada/Eastern');
$rid=$rid;
$res_year=$res_year;
//echo $rotation=$rotation;
$type=$type;
$value=$value;
$org_id=$org_id;
$resident_info=$resident_info;
$total_patient=$total_patient;
$total__distinct_patient=$total__distinct_patient;
foreach($resident_info as $v):
$org_id=$v->org_id;
$resident_name=ucfirst($v->p_first_name)." ".ucfirst($v->p_last_name);
endforeach;
$date=date("Y");
$min_date=$min_date;
$mini=$date-date("Y",strtotime($min_date));

$max_date=$max_date;
$maxi=$date-date("Y",strtotime($max_date));
if($type=="months"){$field_name="months";}
elseif($type=="rotation"){$field_name="rotation";}

if($type=="months" && $value=="1"){ $rto= "January";}
elseif($type=="months" && $value=="2"){ $rto= "February";}
elseif($type=="months" && $value=="3"){ $rto= "March";}
elseif($type=="months" && $value=="4"){ $rto=  "April";}
elseif($type=="months" && $value=="5"){ $rto=  "May";}
elseif($type=="months" && $value=="6"){ $rto=  "June";}
elseif($type=="months" && $value=="7"){ $rto=  "July";}
elseif($type=="months" && $value=="8"){ $rto=  "August";}
elseif($type=="months" && $value=="9"){ $rto=  "September";}
elseif($type=="months" && $value=="10"){ $rto=  "October";}
elseif($type=="months" && $value=="11"){ $rto=  "November";}
elseif($type=="months" && $value=="12"){ $rto=  "December";}
else {$rto=$value;}


 $age_group=$this->report_model->age_group($rid,$field_name,$value,$res_year,"0","1");
 
 $age_group1=$this->report_model->age_group($rid,$field_name,$value,$res_year,"1","5");
$age_group2=$this->report_model->age_group($rid,$field_name,$value,$res_year,"5","18");
 $age_group3=$this->report_model->age_group($rid,$field_name,$value,$res_year,"18","65");
$age_group4=$this->report_model->age_group($rid,$field_name,$value,$res_year,"65","");
?>
    <div class="conatainer">
    <div class="heading">
    <h2 align="center">Report</h2>
    <h1>Dr.<?php echo $resident_name;?></h1>
    <h1><?php echo ucfirst($rto);?></h1>
    </div>
    
    <div class="content">
    <ul class="hm">
    <li> Total patients logged:<?php echo $total__distinct_patient;?> </li>
    <li>Total Male: <?php echo $total_male ;?></li>
    <li>Total Encounters Documented:<?php echo $total_patient;?></li>
    <li>Total Female: <?php echo $total_female ;?></li>
    </ul>
    <p class="hm"><b>Age Group:</b>&nbsp;&nbsp;0-1=[<?php if($total__distinct_patient!='0'){echo number_format($age_group*100/$total__distinct_patient, 2);}?>%]&nbsp;&nbsp;1-5=[<?php if($total__distinct_patient!='0'){echo number_format($age_group1*100/$total__distinct_patient, 2);}?>%]&nbsp;&nbsp;5-18=[<?php if($total__distinct_patient!='0'){echo number_format($age_group2*100/$total__distinct_patient, 2);}?>%]&nbsp;&nbsp;18-65=[<?php if($total__distinct_patient!='0'){echo number_format($age_group3*100/$total__distinct_patient, 2);}?>%]&nbsp;&nbsp;>&nbsp;&nbsp;65=[<?php if($total__distinct_patient!='0'){echo number_format($age_group4*100/$total__distinct_patient, 2);}?>%] </p>
   <?php /*?> <?php if($min_date!=""){ echo $max_date." - ".$min_date;}?><?php */?>
    <div class="catgry1">
    <div class="para">
    <p class="hm"><strong>Primary Diagnoses Encountered:&nbsp;<?php  $cnt=0;foreach($dgns as $v): $cnt++;endforeach;echo $cnt;?></strong></p></div>
    <div class="list">
    <ul class="nk">
    <?php 
    foreach($dgns as $v):
	$total_unique_diagnosis=$this->report_model->total_unique_diagnosis($rid,$res_year,$v->primary_diagnosis,$type,$value);
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
    <?php } endforeach; }?>
    </ul></div>
    
   <?php /*?> <p class="hm">By signing this document you are agreeing the above information is true.</p>
    <div class="dr-name">
    <div class="lt"><hr />Supervisor Name</div>
    <div class="rt"><hr /><?php echo $resident_name;?></div>
    </div>
    <div class="dr-name1">
    <div class="lt"><hr />Supervisor Signature</div>
    </div><?php */?>
    <div class="clr"></div>
    
    </div>
    
    
    </div>
    




