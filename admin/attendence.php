<?php
include("header.php");
include_once('db.php');
?>
<div class="container" style="margin-top: 100px;">
  <div  id="messege">
   
    
</div>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					 Attendence
				</div>
         
				<div class="col-md-3" align="right">
          <button type="button" id="report" name="report" class="btn btn-success btn-sm">report</button>
			 
				</div>  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="attendence_table">
					<thead>
						<tr>
							 
							<th>Student Name</th>
							 
							<th>student-rollno</th>
                                
							    <th>Grade</th>
							   
							  <th>Attendence status</th>
							  <th>Attendence Date</th>
							  <th>Teacher</th>
							 
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
<div class="modal fade" id="reportmodal">
  <div class="modal-dialog"  style=" ">
   
    <div class="modal-content">
      
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
         <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
      </div>
       
     <div class="modal-body">
            <div class=" form-group ">

           <div class="row">
             <div class="col-md-4 ">
            <label for="#fromdate" class="text-right">Grade:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <select name="grade" id="grade" class="form-control">
     		     	<option value="">Select Grade:</option>
     		     	<?php echo get_ocption_list($con); ?>
     		     </select>
           <span id="error_grade" class="text-danger"></span>
       </div>
           </div>
           </div>

           <div class=" form-group ">

           <div class="row">
             <div class="col-md-4 ">
            <label for="#fromdate" class="text-right">FROM:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <input type="text" name="fromdate"   id="fromdate" class=" form-control input_date" readonly="readonly" /> 
           <span id="error_fromdate" class="text-danger"></span>
       </div>
           </div>
           </div>
           <div class=" form-group ">

           <div class="row">
             <div class="col-md-4 ">
            <label for="#todate" class="text-right">To:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <input type="text" name="todate"  id="todate" class=" form-control input_date" readonly="readonly" /> 
           <span id="error_todate" class="text-danger"></span>
       </div>
           </div>
           </div>
           
   
     <div class="modal-footer">
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

      var dataTable=$("#attendence_table").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"attendence_action.php",
      		method:"POST",
      		data:{action:'Fetch'},

      		 
      	}
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
             container:'#reportmodal'
       

      });

       $('#report').click(function(){
     $('#reportmodal').modal('show');
     $('#title').text('Report');
      
   });


       //report modal
       $('#report_button').on('click',function(){

      var fromdate=$('#fromdate').val();
      var grade=$('#grade').val();
      var todate=$('#todate').val();
      var error=0;
      if (grade=='') 
      {
      	$('#error_grade').text('grade is required');
        error++;
      }
      else
      {
      	$('#error_grade').text('');
      }
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
          $('#grade').val('');
          $('#reportmodal').modal('hide');
          window.open("attendence_action.php?action=report_action&fromdate="+fromdate+"&todate="+todate+"&grade="+grade);
      }
  }); 


	});
</script>