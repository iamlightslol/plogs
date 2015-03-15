<?php
//for Gender-----------------------------------------
$id=$rid;
$type=$type;
$total_patient=$this->report_model->total_roation_patient($id,"","",$res_year);

/*for Rotation------------------------------------------------------*/
	
$rotation_data=$this->report_model->get_top10_rotation($id,$res_year);
$cln='"';
$tot="0";
foreach($rotation_data as $v):
$rtn[]=$cln.$v->rotation.$cln;
$rot_data=$this->report_model->total_roation_patient1($id,"rotation",$v->rotation,$res_year);
$rt[]=$rot_data;
$tot++;
endforeach;
if(!empty($rotation_data))
{
	$rtd=implode(",",$rtn);
	
	$newrot=implode(",",$rt);
	
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
                labels : [<?=$rtd;?>],
                datasets : [
                            {
                                fillColor : "rgba(151,187,205,0.5)",
                                strokeColor : "rgba(151,187,205,1)",
                                data : [<?=$newrot?>]
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
      
        <div><p align="center">Number of Patients VS. Rotation</p>
            <canvas id="myChart" width="500" height="400" align="center"></canvas>
        </div>
        
       
    </div>
</div>
   
</body>






