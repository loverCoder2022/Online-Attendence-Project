<?php
 include('header.php');
 /*$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
*/
?>
<div class="container" style="margin-top: 100px;">
  
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					Overall attendence status
				</div>
         
			  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="all_attendence">
					<thead>
						<tr>
							 
							<th>Student Name</th>
							 
							<th>student-rollno</th>
                                
							    <th>Grade</th>
							   
							  <th>Attendence Percentage</th>
							  <th>Teacher</th>
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


<!--  report model  -->
<div class="modal fade" id="allreportmodal">
  <div class="modal-dialog"  style=" ">
   
    <div class="modal-content">
      
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
         <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
      </div>
           
         
          <div class="modal-body">
          	 <div class=" form-group ">

            
            <select class="form-control" id="chart__pdf_report" name="chart__pdf_report">
            	<option value="pdf_report">PDF Report</option>
            	<option value="chart_report">Chart Report</option>
            </select>
            
        
           </div>
           <div class=" form-group ">
           <input type="text" name="fromdate" placeholder="FROM DATE"  id="fromdate" class=" form-control input_date" readonly="readonly" /> 
           <span id="error_fromdate" class="text-danger"></span>
       
           
           </div>
           <div class=" form-group ">

            
           <input type="text" name="todate" placeholder="TO DATE" id="todate" class=" form-control input_date" readonly="readonly" /> 
           <span id="error_todate" class="text-danger"></span>
        
           </div>
           
   
     <div class="modal-footer">
     	 <input type="hidden" name="student_id" id="student_id"/>
         <button type="button" id="report_button" name="report_button" class="btn btn-primary btn-sm">Create Report</button>
         <button type="button" data-dismiss="modal" class="  btn btn-danger dismiss">Close</button>

           
           </div>
            
         </div>
      
        
    </div>
 
  </div>
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){

     var dataTable=$("#all_attendence").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"index_action.php",
      		method:"POST",
      		data:{action:'index_fetch'},

      		 
      	},
      	/*"columnDefs":[
      	{
         "targets":[0,1,2],
         "orderable":false,
     },
      	],*/
      });

     $(".input_date").datepicker({
         
            toDayBtn:'linked',
            format:'yyyy-mm-dd',
            autoclose:true,
             container:'#allreportmodal'
       

      });

   $(document).on('click','.student_report',function(){
     var student_id=$(this).attr('id');
      
     $('#student_id').val(student_id);
    $('#allreportmodal').modal('show');
     $('#title').text('Report');
   });


       //report modal
       $('#report_button').on('click',function(){

      var fromdate=$('#fromdate').val();
      var student_id=$('#student_id').val();
      var todate=$('#todate').val();
      var report=$('#chart__pdf_report').val();
      var error=0;
      
      if(fromdate=='')
      {
        $('#error_fromdate').text('From date is required');
        error++;
      }
      else
      {
        $('#error_fromdate').text('');
      }
       if(todate=='')
      {
        $('#error_todate').text('To date is required');
        error++;
      }
      else
      {
        $('#error_todate').text('');
      }

      if(error==0)
      {
          $('#fromdate').val('');
          $('#todate').val('');
           
          $('#allreportmodal').modal('hide');
          if (report=='pdf_report') 
          {
          window.open("index_action.php?action=report_action&fromdate="+fromdate+"&todate="+todate+"&student_id="+student_id);
      }
        if (report=='chart_report') 
          {
          window.open("chart.php?action=report_action&fromdate="+fromdate+"&todate="+todate+"&student_id="+student_id);
      }
      }
  }); 


	});
</script>
<?php
/*$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
*/
?>