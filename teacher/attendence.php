<?php
 
include_once('header.php');
include_once '../admin/db.php';
$query="SELECT * FROM grade WHERE grade_id=(SELECT teacher_grade_id FROM teacher WHERE 
teacher_id='".$_SESSION['teacher_id']."')";
$execute=$con->prepare($query);
$execute->execute();
$data=$execute->fetchAll();
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
				<button type="button" id="add_attendence" name="add_attendence" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i></a>
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
               <th>Email-address</th>
							  <th>Grade</th>
							   
							  <th>Attendence status</th>
							  <th>Attendence Date</th>
							 
						</tr>
						<tbody>
							
						</tbody>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="attendencemodal">
	<div class="modal-dialog">
 	<form method="post" id="attendence_form">
    <div class="modal-content">
    	
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
         <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
      </div>
       
     <div class="modal-body">
           
          <?php  foreach ($data as $row) 
          {
          	 ?>
              <div class="form-group">
               <div class="row">
     		<label class="col-md-4 text-right">Grade:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		                  
             <?php echo '<label>'.$row['grade_name'].'</label>'; ?>
           </div>
     	</div>
     </div>
     <div class="form-group">
               <div class="row">
        <label class="col-md-4 text-right">Subject:<span class="text-danger">*</span></label>
        <div class="col-md-8">
              <label>DAA</label>
        </div>
      </div>
     </div>
        <div class="form-group">
               <div class="row">
     		<label class="col-md-4 text-right">Date:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		                  
            <input type="text" name="todayDate" format="  yyyy-mm-dd " class="form-control"   id="todayDate" readonly="readonly" />
           <span id="error_td" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group" id="student_details">
     	<div class="table-responsive">
     		<table class="table table-striped table-borderd">
     			<thead>
     				  <tr>
     				  	<th>Roll-no</th>
     				  	<th>Student-Name</th>
     				  	<th>Present</th>
     				  	<th>Absent</th>
     				  </tr>
     			</thead>
     	
          	  <?php
          	  $query1="SELECT * FROM student WHERE student_grade_id='".$row['grade_id']."'";
          	  $execute=$con->prepare($query1);
               $execute->execute();
               $student_data=$execute->fetchAll();
               foreach ($student_data as $student_row) 
               {
                ?>
                  <tr>
                  	<td><?php echo $student_row['student_rollno']; ?></td>
                  	<td><?php echo $student_row['student_name']; ?> 
                  	<input type="hidden" name="student_id[]" value="<?php echo $student_row['student_id'];  ?>"/></td>
                  	<td><input type="radio" name="attendence_status<?php echo $student_row['student_id'];?>" value="Present"/></td>
                  	<td><input type="radio" name="attendence_status<?php echo $student_row['student_id'];?>" value="Absent" checked /></td>
                  </tr>
                 <?php
               }
               ?>
               	</table>
     		
     	           </div>
     	
                 </div>
                 <?php

              } 
              ?>  
         
     <div class="modal-footer">
     	    
           <input type="hidden" name="action" id="action" value="Add"/>
           <input type="submit" name="button_action" id="button_action" class="btn btn-info  " value="Add" align="left" />
         <button type="button" data-dismiss="modal" class="  btn btn-danger dismiss">Close</button>

           
           </div>
            
         </div>
      
        
    </div>
</form>
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
	$(document).ready(function()
	{
      var dataTable=$("#attendence_table").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"attendence_action.php",
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
         
   $('#report').click(function(){
     $('#reportmodal').modal('show');
     $('#title').text('Report');
     clear_field();
   });

    $(".input_date").datepicker({
         
            toDayBtn:'linked',
            format:'yyyy-mm-dd',
            autoclose:true,
             container:'#reportmodal'
       

      });
          
       function clear_field()
      {
      	$('#attendence_form')[0].reset();

      	$('#error_td').text('');
         
        
      //  $('#error_todate').text('');
        //s$('#error_fromdate').text('');
      }
      

       $("#todayDate").datepicker({
        format:'yyyy-mm-dd',
         autoclose:true,
       container:'#attendencemodal'

      }); 
      // atendence Add
	$('#add_attendence').on('click',function(){
		 
       $('#title').text("Today Attendence");
       $('#attendencemodal').modal('show');
	});

  // report button
  $('#report_button').on('click',function(){

      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();
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
          $('#reportmodal').modal('hide');
          window.open("report.php?action=report_action&fromdate="+fromdate+"&todate="+todate);
      }
  }); 

  // add new attendence record
  $('#attendence_form').on('submit',function(event){
         
         
          event.preventDefault();
          $.ajax({
            url:"attendence_action.php",
            method:"POST",
            data:$(this).serialize(),

            dataType:"json",
            
            beforeSend:function()
            { $('#button_action').val('Check...');
               $('#button_action').attr('disabled','disabled');
             },
           
            success:function(data)
            {
               
              $('#button_action').attr('disabled',false);
                 $('#button_action').val($('#action').val());
               
              
               

              
            if(data.success)
            {     
              clear_field();
              
              dataTable.ajax.reload();
                 $('#attendencemodal').modal('hide');
                $('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);
            }
             
            if(data.error)
            {
             
               if(data.error_td !=' ')
               {
                
                  $('#error_td').text(data.error_td);

               }
               else
               {
                $('#error_td').text(' ');
               }
             }
           }
        });

     });
        
});
	
</script>