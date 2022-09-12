<?php
 include('header.php');
 $present=0;
 $absent=0;
 $present_percentage=0;
 $absent_percentage=0;
 $output='';
 $query="SELECT attendence_date,attendence_status FROM attendence WHERE student_id='".$_GET['student_id']."' AND (attendence_date BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."')";
 $run=$con->prepare($query);
 $run->execute();
 $result=$run->fetchAll();
 $total_row=$run->rowCount();
 foreach ($result as $row) 
 {
 	$status='';
			 if($row['attendence_status']=='Present')
			 {
			 	$present++;
                $status='<label class="badge badge-success">Present</label>';
			 }
			  if($row['attendence_status']=='Absent')
			 {
			 	$absent++;
                $status='<label class="badge badge-danger">Absent</label>';
			 }


	$output.='<tr>
     <td>'.$row['attendence_date'].'</td>
     <td>'.$status.'</td>
	</tr>
	';
	$present_percentage=($present/$total_row)*100;
	$absent_percentage=($absent/$total_row)*100;
 }

?>
<div class="container" style="margin-top: 100px;">
  
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					 Attendence Chart
				</div>
         
			  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="">
					 
						  
						  <tr>
							 
							  <th>Student Name</th>
							     <td><?php echo get_student_name($con,$_GET['student_id']); ?></td>
						 </tr>
						  <tr>
							  <th>Grade</th>
							   <td><?php echo get_grade_name($con,$_GET['student_id']); ?></td>
                          </tr>
                          <tr>
                          	<th>Teacher</th>
                          	<td><?php echo get_teacher_name($con,$_GET['student_id']); ?></td>
                          </tr>
                          <tr>
                          	<th>Date:</th>
                          	<td><?php echo $_GET['fromdate'].' to '.$_GET['todate']; ?></td>
                           
                          </tr>  
							     
					</table>
					   <div id="pi_chart" style="width: 100%;  ">
						<div class="table-responsive">
						 <table class="table table-borderd table-striped">
						 	<tr>
						 		<th>Date</th>
						 		<th>Attendence Status</th>
						 	  </tr> 
						 	  <?php echo $output; ?>
						 		 
						 	 
						 </table>	
						</div>

					</div>
			</div>
			<div id="piechart" style="width: 100%; height: 400px;"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</body>
</html>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['attendence Status', 'Percentage'],
          ['Present',   <?php echo $present_percentage ?>],
          ['Absent',    <?php echo $absent_percentage ?>]
           
        ]);
          var options = {
          title: 'Overall Percentage',
           is3D: true,
          hAxis:{
          	title:'Percentage',
          	minValue:0,
          	maxValue:100
          },
          vAxis:{
          	title:'Attendence Status'

          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
</script>