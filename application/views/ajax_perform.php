<?php
date_default_timezone_set('Canada/Eastern');
				
				$Infodata=$this->user_model->get_search_result_data($rid,$type,$value);
				if(!empty($Infodata)):
				foreach($Infodata as $v):?>
               <?php /*?> <table class="ptbl" border="0" cellpadding="0" cellspacing="1">
                <tr class="tbm">
                <td  class="rd" width="22%" valign="top"><?php 
				$newdate=implode('/', array_reverse(explode('/', $v->doj)));
				echo $newdate;if($v->doj!=''){
					
					$month=date("m",strtotime($v->doj));
					if($month=='01'){ echo " (January)";} else if($month=='02'){ echo " (February)";} else if($month=='03'){ echo " (March)";} else if($month=='04'){ echo " (April)";} else if($month=='05'){ echo " (May)";} else if($month=='06'){ echo " (June)";} else if($month=='07'){ echo " (July)";} else if($month=='08'){ echo " (August)";} else if($month=='09'){ echo " (September)";} else if($month=='10'){ echo " (October)";} else if($month=='11'){ echo " (November)";} else if($month=='12'){ echo " (December)";}
					
					}?><br><?php echo isset($v->patient_number)?ucfirst($v->patient_number):'';?><br><?php echo isset($v->patient_mrn)?$v->patient_mrn:'N/A';?><br>
                	
                    <?php if($v->years!=''){
						$Year=date("Y",strtotime($v->years));
						$month=date("m",strtotime($v->years));
						$day=date("d",strtotime($v->years));
						$newyear=date("Y",time())-$Year;
						$newmonth=date("m",time())-$month;
						$newday=date("d",time())-$day;
						if($newday==0){$curday="1";}
						else{$curday=$newday;}
						if($newyear=="0" && $newmonth=="0"){ $dob=$curday." Day";}
						else if($newyear!="0"){$dob=$newyear." Year";}
						else if($newyear=="0"){$dob=$newmonth." Month";}
						else if($newmonth=="0"){$dob=$curday." Day";}
						$age=implode('/', array_reverse(explode('/', $v->years)));
						echo $dob." old ".ucfirst($v->patient_gender);
					}?><br>[<?php echo isset($age)?$age:'';?>]
                    
                    
                	
                    
                    
                </td>
                <td class="grn" width="22%" valign="top">
                	<?php echo isset($v->rotation)?$v->rotation:'';?><br>
                    <?php echo isset($v->location)?$v->location:'';?><br>
                    Year: <?php echo isset($v->residency_year)?$v->residency_year:'';?>	
                </td>
                <td  class="bl" width="34%" valign="top"><?php if($v->primary_diagnosis!=''){echo "Primary:".$v->primary_diagnosis;}?><br>
                	<?php if($v->secondary_diagnoses!=''){ echo "Secondary:".$v->secondary_diagnoses;} else { echo 'Secondary:None';} ?>
                </td>
                <td  class="wh" width="22%" valign="top"><?php if($v->difficulty_of_case!=''){echo "Difficulty of Case:".$v->difficulty_of_case;}?><br>
                	<?php if($v->procedure_performed!='' && $v->procedure_performed!='0'){echo "Procedures:".$v->procedure_performed;}?><br>
                    <?php if($v->supervisor!='' && $v->supervisor!='0'){echo "Supervisor:".$v->supervisor;}?>
                    
                </td>
                </tr>
                <tr class="tbm">
                <td  class="yl" colspan="4">Notes:<?php if($v->comments!=''){echo $v->comments;}?></td>
                </tr>
                
                 </table><br><br><?php */?>
                 
                    <table class="ptbl" border="0" cellpadding="0" cellspacing="1">
                <tr>
                <td width="70%">
                <?php 
				$newdate=implode('/', array_reverse(explode('/', $v->doj)));
				echo $newdate;if($v->doj!=''){
					
					$month=date("m",strtotime($v->doj));
					if($month=='01'){ echo " (January)";} else if($month=='02'){ echo " (February)";} else if($month=='03'){ echo " (March)";} else if($month=='04'){ echo " (April)";} else if($month=='05'){ echo " (May)";} else if($month=='06'){ echo " (June)";} else if($month=='07'){ echo " (July)";} else if($month=='08'){ echo " (August)";} else if($month=='09'){ echo " (September)";} else if($month=='10'){ echo " (October)";} else if($month=='11'){ echo " (November)";} else if($month=='12'){ echo " (December)";}
					
					}?>
                </td>
                <td width="30%">
                <?php echo isset($v->rotation)?$v->rotation:'';?>&nbsp;(Year <?php echo isset($v->residency_year)?$v->residency_year:'';?>)
                </td>
                </tr>
                <tr>
                <td colspan="2">
                <?php echo isset($v->patient_number)?ucfirst($v->patient_number):'';?>&nbsp;(<?php echo isset($v->patient_mrn)?$v->patient_mrn:'N/A';?>) is a <?php if($v->years!=''){
						$Year=date("Y",strtotime($v->years));
						$month=date("m",strtotime($v->years));
						$day=date("d",strtotime($v->years));
						$newyear=date("Y",time())-$Year;
						$newmonth=date("m",time())-$month;
						$newday=date("d",time())-$day;
						if($newday==0){$curday="1";}
						else{$curday=$newday;}
						if($newyear=="0" && $newmonth=="0"){ $dob=$curday." Day";}
						else if($newyear!="0"){$dob=$newyear." Year";}
						else if($newyear=="0"){$dob=$newmonth." Month";}
						else if($newmonth=="0"){$dob=$curday." Day";}
						$age=implode('/', array_reverse(explode('/', $v->years)));
						echo $dob." old ".ucfirst($v->patient_gender);
					}?>&nbsp;[<?php echo isset($age)?$age:'';?>] seen with a primary diagnosis of <?php if($v->primary_diagnosis!=''){echo $v->primary_diagnosis;}?>.
                    <?php echo isset($v->patient_number)?ucfirst($v->patient_number):'';?> also had <?php if($v->secondary_diagnoses!=''){ echo $v->secondary_diagnoses;} else { echo '';} ?>.
                    
<?php if($v->procedure_performed!='' && $v->procedure_performed!='0'){echo ucfirst($v->procedure_performed)." procedure(s) was performed.";}?>
                    
<?php if($v->comments!=''){echo ucfirst($v->comments);}?>
                </td>
                </tr>
                </table><br>
                 
				<?php endforeach; endif;?>
               

<script>
$( "table tbody:odd" ).css( "background-color", "#fff" );
$( "table tbody:even" ).css( "background-color", "#fff" );

 
</script>