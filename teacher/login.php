<?php 
 include_once('../admin/db.php');
 

?> 

<!DOCTYPE html>
<html>
<head>
	<title>student Attendence</title>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

 
</head>
<body>
     <div class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4 ">Student attendence system</h1>
    
  </div>
</div>
<div class="container">
	<div class="row">
	   <div class="col-md-4"></div>
	   <div class="col-md-4">
	   	  <div class="card" style="margin-top: 50px;">
	   	  	  <div class="card-header"><h4>Teacher login</h4></div>
                
	   	  	  	<div class="cad-body">
	   	  	  		<form method="post" id="teacher_login_form">
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter Email-id</label>
	   	  	  				<input type="text" name="teacher_email" id="teacher_email" class="form-control"/>
	   	  	  				<span id="error_teacher_email" class="text-danger"></span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter Paaswod </label>
	   	  	  				<input type="password" name="teacher_password" id="teacher_password" class="form-control "/>
	   	  	  				<span id="error_teacher_password" class="text-danger"></span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				 
	   	  	  				<center><input type="submit" name="teacher_login" id="teacher_login" class="  btn btn-success " value="Login" /></center>
                             
	   	  	  				 
	   	  	  			</div>
	   	  	  		</form>
	   	  	  	</div>
	   	  	  </div>
	   	  </div>
	    
	   <div class="col-md-4"></div>
	</div>
	
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
        

         
       $('#teacher_login_form').on('submit',function(event)
       {   
        
            
            event.preventDefault();
             
            $.ajax({
            	url : "check_teacher_login.php",
            	method : "POST",
            	data:$(this).serialize(), 
            	dataType: "json",
            	beforeSend:function(){
            	$('#admin_login').val('validate');
            	$('#admin_login').attr('disabled','disabled');
                
            	},
            	success: function(data)
            	{ 
                     
            		 
            			if(data.success)
                        {
                             location.href="index.php";
                        }
            		
            		if(data.error)
            		{
                        
            			$('#admin_login').val('login');
            			$('#admin_login').attr('disabled',false);
            			if(data.error_teacher_email != '')
            			{
            				$('#error_teacher_email').text(data.error_teacher_email); 
            			} 
            			else 
            			{
            				$('#error_teacher_email').text('');
            			}
            			if(data.error_teacher_password!='')
            			{
            				$('#error_teacher_password').text(data.error_teacher_password); 
            			}
            			else
            			{
            				$('#error_teacher_password').text('');
            			}
            		}
            	}
            });
       });
	});
</script>