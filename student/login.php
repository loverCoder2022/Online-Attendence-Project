<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<title>student Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

 <link rel="stylesheet" href="../plugins/date/bootstrap-datepicker.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script type="text/javascript" src=" ../plugins/date/bootstrap-datepicker.min.js"></script>
<style type="text/css">
	#mainbody{

  background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet); 
}
	
</style>
</head>
<body id="mainbody">
<div class="container">
	<div class="row">
	   <div class="col-md-4"></div>
	   <div class="col-md-4">
	   	  <div class="card" style="margin-top: 200px;">
	   	  	  <div class="card-header"><h4>Student Login</h4></div>
                
	   	  	  	<div class="card-body">
	   	  	  		<form method="post" id="student_login_form">
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter Roll_no</label>
	   	  	  				<input type="text" name="student_rollno" id="student_rollno" class="form-control"/>
	   	  	  				<span id="error_student_rollno" class="text-danger"></span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter DOB </label>
	   	  	  				<input type="text" name="student_dob" id="student_dob" class="form-control " readonly="readonly" />
	   	  	  				<span id="error_student_dob" class="text-danger"></span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				 
	   	  	  				<center><input type="submit" name="student_login" id="student_login" class="  btn btn-success " value="Login" /></center>
	   	  	  			 <input type="hidden" name="student_name" id="student_name"/>
	   	  	  			 
                             
	   	  	  				 
	   	  	  			</div>
	   	  	  		</form>
	   	  	  	</div>
	   	  	  </div>
	   	  </div>
	    
	   <div class="col-md-4"></div>
	</div>
	
</div>
 
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		 $("#student_dob").datepicker({
         
        format:'yyyy-mm-dd',
        autoclose:true,
        container:'#student_login_form'


      });


       function clear_field()
       {
       	$('#student_login_form')[0].reset();
       	$('#error_student_dob').text('');
       	$('#error_student_rollno').text('');
       }
       $('#student_login_form').on('submit',function(event){
          event.preventDefault();
          $.ajax({
            url :'login_action.php',
            method:'POST',
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function()
            {
            	$('#student_login').val('validate..');
            	$('#student_login').attr('disabled','disabled');
            },
            success:function(data)
            {
            	$('#student_login').attr('disabled',false);
            	$('#student_login').val('Login');
            	if(data.success)
            	{
            		//var student_name=$('#student_name').val(data.student_name);
            		location.href='index.php';
            	}

            	if(data.error)
            		{
                        
            			$('#admin_login').val('login');
            			$('#admin_login').attr('disabled',false);
            			if(data.error_student_rollno != '')
            			{
            				$('#error_student_rollno').text(data.error_student_rollno); 
            			} 
            			else 
            			{
            				$('#error_student_rollno').text('');
            			}
            			if(data.error_student_dob!='')
            			{
            				$('#error_student_dob').text(data.error_student_dob); 
            			}
            			else
            			{
            				$('#error_student_dob').text('');
            			}
            		}
            }

          });
       });
	});
</script>