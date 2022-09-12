<?php  
include_once 'header.php';
?>
 
<div class="container" style="margin-top: 130px;">
  <div id="messege"> </div> 
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					 Grade List
				</div>
				<div class="col-md-3" align="right">
					<button type="button" class="btn btn-success btn-lg" id="add_button"><i class="fas fa-user-plus"></i></button>
				</div>  
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-borderd" id="grade_table">
					<thead>
						<tr>
							<th>Grade Name</th>
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

<div class="modal fade" id="formmodal">
  <div class="modal-dialog" style="font-weight: bold;">
  	<form method="post" id="grade_form">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title text-center text-dark" id="title"></h4>
        <button type="button" class="close dismiss" data-dismiss="modal">&times;</button>
       
      </div>
    
    <div class="modal-body">
        
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-4 text-right">Grade name<span class="text-danger">*</span></label>
     		<div class="col-md-8">
     			<input type="text" name="grade_name" id="grade_name" class="form-control"/>
     			<span id="error_grade_name" class="text-danger"></span>
     		</div>
     	</div>
     </div>
    </div>
  
    <div class="modal-footer">
       <input type="hidden" name="grade_id" id="grade_id"/>
       <input type="hidden" name="action" id ="action" value="Add"/>
      
       <input type="submit" name="button_action" id="button_action" class="btn btn-info  " value="Add"/>
      <button type="button" data-dismiss="modal" class="btn btn-danger dismiss">Close</button>

      
      
      </div>
       
      
    </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</body>
</html>
<script type="text/javascript">
	$(document).ready(function()
	{
      var dataTable=$("#grade_table").DataTable({
      	"processing":true,
      	"serverSide":true,
      	"order":[],
      	"ajax":{
      		url:"grade_action.php",
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


 

      // add grade data
      $('#add_button').on('click',function(){
        var status=1;
        $('#action').val('Add');
        $('#title').text('Add grade');
        $('#button_action').val($('#action').val( ));
        $('#formmodal').modal('show');
        clear_field();

      });
      function clear_field()
      {
      	$('#grade_form')[0].reset();
      	$('#error_grade_name').text('');
      }
      $('#grade_form').on('submit',function(event){
          //var grade_name=$('#grade_name').val();

           
          event.preventDefault();
          $.ajax({
            url:"grade_action.php",
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
            	;
            	
            if(data.success)
            {     
            	$('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);
                
                clear_field();
                $('#formmodal').modal("hide");
              dataTable.ajax.reload();
              }
             
            if(data.error)
            {
            	
               if(data.error_grade_name !=' ')
                
                  $('#error_grade_name').text(data.error_grade_name);

               }
               else
               {
                $('#error_grade_name').text(' ');
               }

            
        }

          });
      });
      //edit section
      
      $(document).on('click','.edit_grade',function(){
         var grade_id =$(this).attr('id');
          
         clear_field();
         
          $('#action').val('Edit');   
          $('#title').text('Edit grade'); 
           $('#formmodal').modal('show');
           $('#button_action').val($('#action').val());
          
          $.ajax({
              url:"grade_action.php",
              type:"POST",
              data:{actions:'edit_grade',grade_id:grade_id},
              dataType:"json",
              success:function(data)
              {
                
              	   dataTable.ajax.reload();
                  $('#grade_id').val(data.grade_id);
                  $('#grade_name').val(data.grade_name);
                  
                   
              }
          });   

      });


      // delete grade
      $(document).on('click','.delete_grade',function(){
         var grade_id=$(this).attr('id');
          
         $.ajax({
           url:'grade_action.php',
           type:'POST',
           data:{action:'Delete',grade_id:grade_id},
           dataType:"json",
           success:function(data)
           {
            if(data.success)
            {
            	 $('#messege').html('<div class="alert alert-warning">'+data.messege+'</div>');
                $('#messege').fadeOut(3000);;
            	 dataTable.ajax.reload();
            }
           }
         });
      });

  });
     

	
</script>