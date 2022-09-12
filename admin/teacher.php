<?php
include_once 'header.php';
 
if(!isset($_SESSION['admin_id']))
{
  header('location:login.php');
}
?>

<div class="container" style="margin-top: 100px;">
  <div  id="messege"></div>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					 Grade List
				</div>
				<div class="col-md-3" align="right">
				<button type="button" class="btn btn-success btn-md" id="add_button"><i class="fas fa-user-plus"></i></button>
				</div>  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="teacher_table">
					<thead>
						<tr>
							<th>Image</th>
							<th>Teacher Name</th>
							<th>Email</th>
							<th>Mobile no</th>

							  <th>Grade</th>
							  <th>View</th>
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
    <div class="modal fade" id="teacher_modal">
  <div class="modal-dialog" >
    <form method="post" id="teacher_form">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
        <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
       
      </div>
    <div class="modal-body">
        
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-4 text-right">Teacher Name<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     			<input type="text" name="teacher_name" id="teacher_name" class="form-control"/>
     			<span id="error_teacher_name" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-4 text-right">Email:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     			<input type="text" name="teacher_email" id="teacher_email" class="form-control"/>
     			<span id="error_teacher_email" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-4 text-right">Mobile no:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     			<input type="text" name="mobile" id="mobile" class="form-control"/>
     			<span id="error_mobile" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-4 text-right">Address:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		    <textarea name="teacher_address" id="teacher_address" class="form-control"></textarea>
     			<span id="error_address" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-4 text-right">Qualification:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		    <input type="text" name="teacher_qualification" id="teacher_qualification" class="form-control"/> 
     			<span id="error_qualification" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-4 text-right">Password:<span class="text-danger">*</span></label>
     		<div class=" col-md-8">
     		 <i class="fas fa-eye faeye" id="eye" ></i>
          <input type="password" name="teacher_password" class="sign form-control 
          "id="teacher_password"/>
              <span id="error_password" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-4 text-right">Grade:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		     <select name="teacher_grade_id" id="teacher_grade_id" class="form-control">
     		     	<option value="">Select Grade:</option>
     		     	<?php echo get_ocption_list($con); ?>
     		     </select>
     		     <span id="error_teacher_grade_id" class="text-danger"></span>
     			 
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-4 text-right">Date of joining:<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     		                  
            <input type="text" name="doj"  class="form-control"   id="doj" readonly="readonly" />
            

                            
     		    <span id="error_doj" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-4 text-right">Image<span class="text-danger">*</span></label>
     		<div class="col-md-8"> 
     			<input type="file" name="teacher_image" id="teacher_image" class="form-control-file" />
     			<span class="text-muted">Only .jpg and .png allowed</span>
     		    <span id="error_image" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     
 
  
    <div class="modal-footer">
       <input type="hidden" name="teacher_id" id="teacher_id"/>
     <input type="hidden" name="hide_teacher_image" id="hide_teacher_image" /> 
       <input type="hidden" name="action" id="action" value="Add"/>
       <input type="submit" name="button_action" id="button_action" class="btn btn-info  " value="Add" align="left" />
      <button type="button" data-dismiss="modal" class="btn btn-danger dismiss">Close</button>

      
      
      </div>

       
      
    </div><!-- /.modal-content -->
  </div>
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal" id="teacher_view">
  <div class="modal-dialog" style="font-weight: bold;">
    
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"> View Teacher</h4>
        <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
       
      </div>
    
    <div class="modal-body" id="teacher_deatils">

    </div>
    <div class="modal-footer">
       
      <button type="button" data-dismiss="modal" class="btn btn-danger dismiss">Close</button>

      
      
      </div>
  </div>
 
</div>
</div>
</body>
</html>
<script type="text/javascript">
	
$(document).ready(function()
	{
      var dataTable=$("#teacher_table").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"teacher_action.php",
      		method:"POST",
      		data:{action:'get'},

      		 
      	},
      	"columnDefs":[
      	{
         "targets":[0,1,2],
         "orderable":false,
     },
      	],
      });

// toggle eye
$('#eye').on('click',function(){
    
    if($('#teacher_password').attr('type','password'))
    {
        $('#eye').css("color","red");
      $('#teacher_password').attr('type','text');
       
    }
   else
   {
     $('#teacher_password').attr('type','password');
     $('#eye').css("color","black");
   }
});
 

     
  $("#doj").datepicker({
        format:'yyyy-mm-dd',
       
        container:'#teacher_modal'

      }); 
        
     function clear_field()
      {
      	$('#teacher_form')[0].reset();
      	$('#error_image').text('');
        $('#error_doj').text('');
      	$('#error_qualification').text('');
      	$('#error_password').text('');
      	$('#error_teacher_email').text('');
      	$('#error_teacher_name').text('');
      	$('#error_mobile').text('');
      	$('#error_address').text('');
        $('#error_teacher_grade_id').text('');
      }
       //$('.dismiss').click(function(){
         //$('#teacher_modal').modal('hide');
       //});
       
         // input only digits
       $('#mobile').on('blur',function(){

          var mobile_len=$('#mobile').val();
               
           if (mobile_len.length != 10) 
           {   $('#mobile').focus();
               $('#error_mobile').text("Enter 10 digit mobile number");

             }
             else
             {
              $('#error_mobile').text(" ");
             }
              });

       $('#teacher_email').on('blur',function(){
          var teacher_email=$('#teacher_email').val();

           var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
          if(teacher_email.length ==' ')
          {
             $('#teacher_email').focus();
          }
          else
          {
          if(!emailReg.test(teacher_email))
          {   $('#teacher_email').focus();
             $('#error_teacher_email').text("enter valid email");
             
          }
          else
          {   
             $('#error_teacher_email').text(" ");
             
          }
          }
       });
    
     $('#mobile').keypress(function(re){
       var char= re.which;
  
     if (char>=48 && char<=57)
      {
        return true;

       }
         return false;
           });

     $('#teacher_name').keypress(function(re){
       var char= re.which;
  
    if (char>31 && char!=32 && (char<65||char>90)&&(char<97||char>122))
       {
         return false;
        }
         return true;
           });

/////////////////////////////////////
          $('#add_button').on('click',function(){
           
        
        $('#title').text('Add Teacher');
         $('#teacher_modal').modal('show');
        $('#action').val('Add');
       $('#button_action').val('Add');
       
        clear_field();

      });

       
          


          $('#teacher_form').on('submit',function(event){
          event.preventDefault();
          $.ajax({
            url:"teacher_action.php",
            method:"POST",
            data: new FormData(this),

            dataType:"json",
            contentType:false,
            processData:false,
            beforeSend:function()
            {  $('#button_action').val('Check...');
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
              $('#teacher_modal').modal('hide');

            	if(data.messege !=' ')
            	{
            	  $('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);
            	}
            	 
            }
             
            if(data.error)
            {
            	
               if(data.error_teacher_name !=' ')
               {
                
                  $('#error_teacher_name').text(data.error_teacher_name);

               }
               else
               {
                $('#error_teacher_name').text(' ');
               }
                
                if(data.error_teacher_email !=' ')
                {
                  $('#error_teacher_email').text(data.error_teacher_email);
                }

               
               else
               {
                $('#error_teacher_email').text(' ');
               }
               if(data.error_mobile !=' ')
                {
                  $('#error_mobile').text(data.error_mobile);
                }

               
               else
               {
                $('#error_mobile').text(' ');
               }
               if(data.error_mobile !=' ')
                {
                  $('#error_mobile').text(data.error_mobile);
                }
                else
               {
                $('#error_mobile').text(' ');
               }

                if(data.error_address !=' ')
                {
                  $('#error_address').text(data.error_address);
                }
                else
               {
                $('#error_address').text(' ');
               }

                if(data.error_image != ' ')
                {
                  $('#error_image').text(data.error_image);
                }
                else
               {
                $('#error_image').text(' ');
               }

               if(data.error_doj !=' ')
                {
                  $('#error_doj').text(data.error_doj);
                }
                else
               {                $('#error_doj').text(' ');
               }

               if(data.error_password !=' ')
                {
                  $('#error_password').text(data.error_password);
                }
                else
               {
                $('#error_password').text(' ');
               }

               if(data.error_qualification !=' ')
                {
                  $('#error_qualification').text(data.error_qualification);
                }
                else
               {
                $('#error_qualification').text(' ');
               }
                if(data.error_teacher_grade_id !='')
                {
                  $('#error_teacher_grade_id').text(data.error_teacher_grade_id);
                }
                else
               {
                $('#error_teacher_grade_id').text(' ');
               }

          }
            
        }

          });
      });

        // view button code
        $(document).on('click','.view_btn',function(){
         var teacher_id=$(this).attr('id');
         $.ajax({
           url:"teacher_action.php",
           method:"POST",
           data:{action:'teacher_fetch',teacher_id:teacher_id},
           dataType:'json',
           success:function(data)
           {
            $('#teacher_deatils').html(data);
            $('#teacher_view').modal('show');
           }

         });
        });


        // delete teacher
        $(document).on('click','.delete_teacher',function(){
         var teacher_id=$(this).attr('id');
          
         $.ajax({
           url:'teacher_action.php',
           method:'POST',
           data:{action:'Delete_teacher',teacher_id:teacher_id},
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
        
        // edit teacher


      $(document).on('click','.edit_teacher',function(){
         var teacher_id =$(this).attr('id');
          
            
          $('#title').text('Edit  Teacher'); 
           $('#teacher_modal').modal('show');
            
          ;
          $.ajax({
              url:"teacher_action.php",
              type:"POST",
              data:{update:'edit_teacher',teacher_id:teacher_id},
              dataType:"json",
              success:function(data)
              {
                
                   dataTable.ajax.reload();
                  $('#teacher_id').val(data.teacher_id);
                  $('#teacher_name').val(data.teacher_name);
                   $('#teacher_email').val(data.teacher_email);
                   $('#teacher_password').val(data.teacher_password);
                  $('#teacher_address').val(data.teacher_address);
                  $('#teacher_qualification').val(data.teacher_qualification);
                  $('#mobile').val(data.teacher_mobile);
                  $('#teacher_grade_id').val(data.teacher_grade_id);
                  $('#error_image').html('<img src="teacher_image/'+data.teacher_image+'" class="img-thumnail" width="100" />');
                  $('#hide_teacher_image').val(data.teacher_image);
                  $('#doj').val(data.teacher_doj);
                  
                   if(data.status==1)
                  { 
                     
                    $('#teacher_email').attr('readonly',true);
                    $('#teacher_password').attr('readonly',true);
                    $('#doj').attr('disabled',true);

                  }
                  $('#action').val('Update');

                    $('#button_action').val($('#action').val());

              }
          });   

      });

      $('.dismiss').click(function(){
         $('#teacher_modal').modal('hide');
          $('#teacher_password').attr('readonly',false);
          $('#teacher_email').attr('readonly',false);
          $('#doj').attr('disabled',false);
          clear_field();
       });

  });
 

</script>