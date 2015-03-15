<?php
//for Gender-----------------------------------------
$id=$rid;
$type=$type;
$total_patient=$this->report_model->total_roation_patient($id,"","",$res_year);
 

//for Dignosis and difficulty of case---------------------------------------
$prm_dgns=$this->report_model->get_dignosis_list($id,"","","10",$res_year);

$cln='"';
$scm="'";
$cnt="0";
foreach($prm_dgns as $v):
$pdg[]=$cln.$v->primary_diagnosis.$cln;
$primary_dgns=$this->report_model->get_prmy_dgns_data($id,$v->primary_diagnosis);
$prm_dg[]=$primary_dgns;
$case=$this->report_model->get_diffculty_of_case($id,$v->primary_diagnosis);
$new_data[]=$scm.$case.$scm;
$cnt++;
endforeach;
if(!empty($prm_dgns))
{
	$pd=implode(",",$pdg);
	$newrclmn=implode(",",$prm_dg);			
}


?>
<script src="<?php echo HTTP_JS_PATH; ?>Chart.min.js"></script>
<script>
	function createChart()
        {
            //Get the context of the canvas element we want to select
            var ctx = document.getElementById("myChart").getContext("2d");
            
            //Create the data object to pass to the chart
            var data = {
                labels : [<?=$pd;?>],
                datasets : [
                            {
                                fillColor : "rgba(151,187,205,0.5)",
                                strokeColor : "rgba(151,187,205,1)",
                                data : [<?=$newrclmn;?>]
                            } 
                           ]
                      };
            
            //The options we are going to pass to the chart
            options = {
                barDatasetSpacing : 15,
                barValueSpacing: 10
            };
			
		   function wholeNumberAxisFix(data) {
		   var maxValue = false;
		   for (datasetIndex = 0; datasetIndex < data.datasets.length; ++datasetIndex) {
			   var setMax = Math.max.apply(null, data.datasets[datasetIndex].data);
			   if (maxValue === false || setMax > maxValue) maxValue = setMax;
		   }
		
		   var steps = new Number(maxValue);
		   var stepWidth = new Number(1);
		   if (maxValue > 10) {
			   stepWidth = Math.floor(maxValue / 10);
			   steps = Math.ceil(maxValue / stepWidth);
		   }
		   return { scaleOverride: true, scaleSteps: steps, scaleStepWidth: stepWidth, scaleStartValue: 0 };
		}
            
            //Create the chart
            new Chart(ctx).Bar(data, wholeNumberAxisFix(data));
        }
		
		createChart();

        </script>
<body>
              
<div class="report-container">
	<div class="report-content">
    <h2 align="center">Graph Report</h2>
      
        <div><p align="center">Number of Patients VS. Primary Diagnosis</p>
            <canvas id="myChart" width="500" height="400" align="center"></canvas>
        </div>
        
       
    </div>
</div>
   
</body>






