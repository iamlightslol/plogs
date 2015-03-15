<?php
//for Gender-----------------------------------------
$id=$rid;
$type=$type;
$total_patient=$this->report_model->total_roation_patient($id,"","",$res_year);
 

//for month------------------------------------------

$a0=$this->report_model->get_age_data($id,"0","10",$res_year);


$a1=$this->report_model->get_age_data($id,"11","20",$res_year);


$a2=$this->report_model->get_age_data($id,"21","30",$res_year);


$a3=$this->report_model->get_age_data($id,"31","40",$res_year);


$a4=$this->report_model->get_age_data($id,"41","50",$res_year);


$a5=$this->report_model->get_age_data($id,"51","60",$res_year);


$a6=$this->report_model->get_age_data($id,"61","70",$res_year);


$a7=$this->report_model->get_age_data($id,"71","80",$res_year);


$a8=$this->report_model->get_age_data($id,"81","90",$res_year);


$a9=$this->report_model->get_age_data($id,"91","100",$res_year);



?>
<script src="<?php echo HTTP_JS_PATH; ?>Chart.min.js"></script>
<script>
	function createChart()
        {
            //Get the context of the canvas element we want to select
            var ctx = document.getElementById("myChart").getContext("2d");
            
            //Create the data object to pass to the chart
            var data = {
                labels : ["0-10","11-20","21-30","31-40","41-50","51-60","61-70","71-80","81-90","91-100"],
                datasets : [
							
                            {
								
								fillColor: "rgba(151,187,205,0.5)",
								strokeColor: "rgba(151,187,205,0.8)",
								highlightFill: "rgba(151,187,205,0.75)",
								highlightStroke: "rgba(151,187,205,1)",
                                data : [<?=$a0;?>,<?=$a1;?>,<?=$a2;?>,<?=$a3;?>,<?=$a4;?>,<?=$a5;?>,<?=$a6;?>,<?=$a7;?>,<?=$a8;?>,<?=$a9;?>]
                            } 
                           ]
                      };
    
            options={
				scaleIntegersOnly: true,
				scaleBeginAtZero: true,
				scaleShowGridLines : true,
				scaleGridLineColor : "rgba(0,0,0,.05)",
				scaleGridLineWidth : 1,
				barShowStroke : true,
				barStrokeWidth : 2,
				barValueSpacing : 1,
				barDatasetSpacing : 0
			   
			}
			
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
           var myBarChart = new Chart(ctx).Bar(data, wholeNumberAxisFix(data));

        }
		
		createChart();


        </script>
<body>
              
<div class="report-container">
	<div class="report-content">
    <h2 align="center">Graph Report</h2>
      
        <div><p align="center">Number of Patients VS. Age</p>
            <canvas id="myChart" width="500px" height="400px" align="center"></canvas>
        </div>
        
    </div>
</div>
   
</body>






