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

?>


   <link href="<?php echo HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
   <link href="<?php echo HTTP_CSS_PATH; ?>stylesheet.css" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>tcal.css" />
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>tcal.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-1.10.2.js"></script>
<script src="<?php echo HTTP_JS_PATH; ?>jquery-ui.js"></script>
<script>

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
<h4 align="center" style="margin:20px 0px 10px;">View By:
                    
                   <select id="grph" style="width:150px; height:35px;" onChange="get_graph_data()">
                   <option>--Select--</option>
                  <option>Age</option>
                  <option>Rotation</option>
                 <option>Primary Diagnosis</option>
                 <option>Gender</option>
                 <!--<option>Difficulty of Case</option>-->
                </select>
                <p>[Choose options for Graph Report]</p>
   
<!--<input type="button" style=" margin-left:20px;width:120px; height:35px;font-size: 20px" onClick="PrintDiv();" value="print">--></h4>
<div class="maindiv" id="divToPrint">
	
 <div id="skr1"></div>	
</div>

</body>

<script>
function get_graph_data()
{
		var type=$("#grph option:selected").text();
		var rid="<?=$id;?>";
		var res_year="<?=$res_year;?>";
		var data="type="+type+"&rid="+rid+"&res_year="+res_year;
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
					$("#skr1").html(response);
				}
			}
		});
}
</script>            