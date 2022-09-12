<?php
include_once('header.php');
?>
<div class="container" style="margin-top: 100px;">
  <div  id="messege">
   
    
</div>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					 Student
				</div>
				<div class="col-md-3" align="right">
				<button type="button" id="add" name="add" class="btn btn-success btn-lg"><i class="fas fa-user-plus"></i></a>
				</div>  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="student_table">
					<thead>
						<tr>
							 
							<th>Student Name</th>
							<th>Email</th>
							<th>student_rollno</th>
                        
							  <th>Grade</th>
							   
							  <th>Edit</th>
							  <th>Delete</th>
							 
						</tr>
						<tbody>
							
						</tbody>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="student_modal">
	<div class="modal-dialog"  style=" ">
 	<form method="post" id="student_form">
    <div class="modal-content">
    	
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
         <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
      </div>
       
     <div class="modal-body">
           
           <div class=" form-group ">

           <div class="row">
           	 <div class="col-md-4 ">
           	<label for="#student_name" class="text-right">Name:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <input type="text" name="student_name"   id="student_name" class=" form-control  input"/> 
           <span id="error_student_name" class="text-danger"></span>
       </div>
           </div>
           </div>
           <div class=" form-group ">

           <div class="row">
           	 <div class="col-md-4 ">
           	<label for="#student_email" class="text-right">Email:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <input type="text" name="student_email"  id="student_email" class=" form-control  input" /> 
           <span id="error_student_email" class="text-danger"></span>
       </div>
           </div>
           </div>
           <div class=" form-group ">
           	<div class="row">
           	 <div class="col-md-4 ">
           	<label for="#student_rollno" class="text-right">Roll_no:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8">
           <input type="text" name="student_rollno"  id="student_rollno" class=" form-control  input" />
           <span id="error_student_rollno" class="text-danger"></span> 
           </div>
           </div>
           </div>
           <div class=" form-group ">
           	<div class="row">
           	 <div class="col-md-4 ">
           	<label for="#student_dob" class="text-right">DOB:<span class="text-danger">*</span></label>
            </div>
           <div class="col-md-8 ">
           <input type="text" name="student_dob"  id="student_dob" class=" form-control   " readonly="readonly" /> 
           <span id="error_student_dob" class="text-danger"></span>
           </div>
           </div>
           </div>
            <div class="form-group">
     <div class="row">
     	<div class="col-md-4">
     		<label class=" text-right">Grade:<span class="text-danger">*</span></label>
     	</div>
     		<div class="col-md-8">
     		     <select name="student_grade_id" id="student_grade_id" class="form-control">
     		     	<option value="">Select Grade:</option>
     		     	<?php echo get_ocption_list($con); ?>
     		     </select>
     		     <span id="error_student_grade" class="text-danger"></span>
     			 
     		</div>
     	</div>
     </div>
   
     <div class="modal-footer">
     	    <input type="hidden" name="student_id" id="student_id"/>
           <input type="hidden" name="action" id="action" value="Add"/>
           <input type="submit" name="button_action" id="button_action" class="btn btn-info  " value="Add" align="left" />
         <button type="button" data-dismiss="modal" class="  btn btn-danger dismiss">Close</button>

           
           </div>
            
         </div>
      
        
    </div>
</form>
  </div>
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function()
	{
      var dataTable=$("#student_table").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"student_action.php",
      		method:"POST",
      		data:{action:'fetch'},
      		 

      		 
      	},
      	"columnDefs":[
      	{
         "targets":[0,1,2],
         "orderable":false,
     },
      	],
      });
       // student add code
     $("#student_dob").datepicker({
         
        format:'yyyy-mm-dd',
        container:'#student_modal'
      }); 
       $('.dismiss').click(function(){
         $('#student_modal').modal('hide');
          $('#student_name').attr('readonly',false);
          $('#student_dob').attr('disabled',false);
          $('#student_rollno').attr('readonly',false);
       });
       function clear_field()
      {
      	$('#student_form')[0].reset();
      	$('#error_student_name').text('');
        $('#error_student_rollno').text('');
      	$('#error_student_email').text('');
      	$('#error_student_dob').text('');
      	$('#error_student_grade').text('');
      	 
      }
       
       $('#add').on('click',function(){
       	
      $('#title').text('ADD STUDENT');
      $('#student_modal').modal('show');
      $('#action').val('Add');
      $('#button_action').val('Add');
      
      clear_field();

       });
    
      $('#student_form').on('submit',function(event){
         
         
          event.preventDefault();
          $.ajax({
            url:"student_action.php",
            method:"POST",
            data:$(this).serialize(),

            dataType:"json",
            
            beforeSend:function()
            {  $('#button_action').val('Check...');
               $('#button_action').attr('disabled','disabled');
            	
            },
              
           
            success:function(data)
            {
            	 
            	$('#button_action').attr('disabled',false);
                 $('#button_action').val($('#action').val());
            	 
            	
            	 

            	
            if(data.success)
            {     clear_field();
            	
            	dataTable.ajax.reload();
                 $('#student_modal').modal('hide');
                $('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);
            }
             
            if(data.error)
            {
            	if(data.messege)
            	{
            		alert(data.messege);
            		clear_field();
            	}
            	
               if(data.error_student_name !=' ')
               {
                
                  $('#error_student_name').text(data.error_student_name);

               }
               else
               {
                $('#error_student_name').text(' ');
               }
               if(data.error_student_email !=' ')
               {
                
                  $('#error_student_email').text(data.error_student_email);

               }
               else
               {
                $('#error_student_email').text(' ');
               }
               if(data.error_student_rollno !=' ')
               {
                
                  $('#error_student_rollno').text(data.error_student_rollno);

               }
               else
               {
                $('#error_student_rollno').text(' ');
               }
               if(data.error_student_dob !=' ')
               {
                
                  $('#error_student_dob').text(data.error_student_dob);

               }
               else
               {
                $('#error_student_dob').text(' ');
               }

               if(data.error_student_grade !=' ')
               {
                
                  $('#error_student_grade').text(data.error_student_grade);

               }
               else
               {
                $('#error_student_grade').text(' ');
               }
           }
       }
         });
      });
      // student delete
      //$('#messege').hide();
       $(document).on('click','.delete_student',function(){
         var student_id=$(this).attr('id');
          
         $.ajax({
           url:'student_action.php',
           method:'POST',
           data:{action:'Delete',student_id:student_id},
           dataType:"json",
           success:function(data){
            if(data.success)
            {    
                $('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);

               dataTable.ajax.reload();
            }
           }
         });
      });

       // edit student

       $(document).on('click','.edit_student',function(){
         var student_id =$(this).attr('id');
        //..alert(student_id);
             $('#title').text("Edit student");
         	  $.ajax({
          	
              url:"student_action.php",
              type:"POST",
              data:{update:'edit_student',student_id:student_id},
              dataType:"json",
              success:function(data)
              {
                
                   
                  $('#student_id').val(data.student_id);
                  $('#student_name').val(data.student_name);
                   
                  $('#student_email').val(data.student_email);
                  $('#student_grade_id').val(data.student_grade_id);
                  $('#student_rollno').val(data.student_rollno);
                  $('#student_dob').val(data.student_dob);
                  if(data.status==1)
                  { 
                  	 
                  	$('#student_name').attr('readonly',true);
                  	$('#student_dob').attr('disabled',true);
                  	$('#student_rollno').attr('readonly',true);

                  }
                  
                     $('#student_modal').modal('show');
         
          	        $('#action').val('Update');
            
                       
                  
                   $('#button_action').val($('#action').val());  
                   
              }
          }); 
         
      });

  });

</script>