<?php
//for Gender-----------------------------------------
$id=$rid;
$type=$type;
$total_patient=$this->report_model->total_roation_patient($id,"","",$res_year);
 
$male=$this->report_model->get_gender_data($id,"male",$res_year);


$female=$this->report_model->get_gender_data($id,"female",$res_year);






?>
<script src="<?php echo HTTP_JS_PATH; ?>Chart.min.js"></script>
<script>
	function createChart()
        {
            //Get the context of the canvas element we want to select
            var ctx = document.getElementById("myChart").getContext("2d");
            
            //Create the data object to pass to the chart
            var data = {
                labels : ["Male","Female"],
                datasets : [
                            {
                                fillColor : "rgba(151,187,205,0.5)",
                                strokeColor : "rgba(151,187,205,1)",
                                data : [<?=$male;?>,<?=$female;?>]
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
      
        <div><p align="center">Number of Patients VS. Gender</p>
            <canvas id="myChart" width="500" height="400" align="center"></canvas>
        </div>
        
       
    </div>
</div>
   
</body>






