<?php
include_once("header.php");
if (!isset($_SESSION['teacher_id'])) {
	header("location:login.php");
}
?>
<div class="container" style="margin-top: 130px;">
  <div id="messege"> </div> 
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6 text-left">
					 <h4>Teacher profile</h4> 
				</div>
				<div class="col-md-3 ">
					
				</div>  
			</div>
		</div>
		<div class="card-body">
			<form>
	<div class="form-group">
     	<div class="row">
     		<label class="col-md-2 text-center">Teacher Name<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     			<input type="text" name="teacher_name" id="teacher_name" class="form-control"/>
     			<span id="error_teacher_name" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-2 text-center">Email:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     			<input type="text" name="teacher_email" id="teacher_email" class="form-control"/>
     			<span id="error_teacher_email" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-2 text-center">Mobile no:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     			<input type="text" name="mobile" id="mobile" class="form-control"/>
     			<span id="error_mobile" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     	<div class="row">
     		<label class="col-md-2 text-center">Address:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     		    <textarea name="teacher_address" id="teacher_address" class="form-control"></textarea>
     			<span id="error_address" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-2 text-center">Qualification:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     		    <input type="text" name="teacher_qualification" id="teacher_qualification" class="form-control"/> 
     			<span id="error_qualification" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-2 text-center">Password:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     		    <input type="Password" name="teacher_password" id="teacher_password" class="form-control"/> 
     			<span id="error_password" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-2 text-center">Grade:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     		     <select name="teacher_grade_id" id="teacher_grade_id" class="form-control">
     		     	<option value="">Select Grade:</option>
     		     	<?php echo get_ocption_list($con); ?>
     		     </select>
     		     <span id="error_grade" class="text-danger"></span>
     			 
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-2 text-center">Date of joining:<span class="text-danger">*</span></label>
     		<div class="col-md-10">
     		                  
            <input type="text" name="doj" format="  yyyy-mm-dd " class="form-control"   id="doj" readonly="readonly" />
            

                            
     		    <span id="error_doj" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     <div class="form-group">
     <div class="row">
     		<label class="col-md-2 text-center">Image<span class="text-danger">*</span></label>
     		<div class="col-md-10"> 
     			<input type="file" name="teacher_image" id="teacher_image" class="form-control" />
     			<span class="text-muted">Only .jpg and .png allowed</span>
     		    <span id="error_image" class="text-danger"></span>
     		</div>
     	</div>
     </div>
     
 
  
    <div class=" ">
       <input type="hidden" name="teacher_id" id="teacher_id"/>
     <input type="hidden" name="hide_teacher_image" id="hide_teacher_image" /> 
       <input type="hidden" name="action" id="action" value="Add"/>
       <center><input type="submit" name="button_action" id="button_action" class="btn btn-info btn-lg" value="Update" align="left" /></center>

      
      
      </div>

     </div>
			</form> 
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function()
		{

         var teacher_id =<?php echo $_SESSION['teacher_id'] ?>;
          //	alert(teacher_id);
         
            
          
          $.ajax({
              url:"profile_action.php",
              type:"POST",
              data:{action:'fetch',teacher_id:teacher_id},
              dataType:"json",
              success:function(data)
              {
                
                
                  $('#teacher_id').val(data.teacher_id);
                  $('#teacher_name').val(data.teacher_name);
                   $('#teacher_email').val(data.teacher_email);
                   $('#teacher_password').val(data.teacher_password);
                  $('#teacher_address').val(data.teacher_address);
                  $('#teacher_qualification').val(data.teacher_qualification);
                  $('#mobile').val(data.teacher_mobile);
                  $('#teacher_grade_id').val(data.teacher_grade_id);
                  $('#error_image').html('<img src="../admin/teacher_image/'+data.teacher_image+'" class="img-thumnail" width="100" />');
                  $('#hide_teacher_image').val(data.teacher_image);
                  
                   $('#button_action').val('Update');  
              }
          });   

      });

	
</script>