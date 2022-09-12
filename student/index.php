<?php 
session_start();
if(!isset($_SESSION['student_id']))
{
	header('location:login.php');
}
include_once('../admin/db.php');
 

 $present=0;
 $absent=0;
 $present_percentage=0;
 $absent_percentage=0;
 $output='';
 $sub_query="SELECT attendence_date,attendence_status FROM attendence WHERE student_id='".$_SESSION['student_id']."'";
 $run=$con->prepare($sub_query);
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
 <!DOCTYPE html>
 <html>
 <head>
 	<title>student</title>
 </head>
 <meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
 
 

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

 <body>
 <div class="jumbotron text-center">
 	<h1 class="text-primary">WELCOME : <?php echo get_student_name($con,$_SESSION['student_id']);   ?></h1>
 	 <h3 class="float-right text-success">BRANCH: <?php echo get_grade_name($con,$_SESSION['student_id']); ?></h3>
 	 <a href="logout.php" class="float-left"><h2>Logout</h2></a>
 </div>
  


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

