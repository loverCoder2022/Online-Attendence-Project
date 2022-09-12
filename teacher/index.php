<?php
 include('header.php');
 
 
 include("teacher_session.php");
?>
<div class="container" style="margin-top: 100px;">
  <div  id="messege">
   
    
</div>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					Student Attendence Report
				</div>
            </div>

		</div>
		<div class="card-body">
			<div class="table-responsive">
              
				<table class="table table-striped table-borderd" id="attendence_report">
					<thead>
						<tr>
							 
							<th>Student Name</th>
							 
							<th>Student-Rollno</th>
                            
							  <th>Grade</th>
							   
							  <th>Attendence Percentage</th>
							  <th>Report</th>
							 
						</tr>
						<tbody>
							
						</tbody>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>
 <script type="text/javascript">
	$(document).ready(function()
	{
      var dataTable=$("#attendence_report").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"index_action.php",
      		method:"POST",
      		data:{action:'Fetch'},

      		 
      	},
      	"columnDefs":[
      	{
         "targets":[0,1,2],
         "orderable":false,
     },
      	],
      });

      // report every student 
	$(document).on('click','.report',function()
	{
       var student_id=$(this).attr('id');
       window.open("index_action.php?action=student_report&student_id="+student_id);
        
	});
  });


</script>