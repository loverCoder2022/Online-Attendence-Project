<?php 
 include_once('db.php');
 
session_start();
if(isset($_SESSION['admin_id']))
{
	header('location:index.php');
}

?> 

<!DOCTYPE html>
<html>
<head>
	<title>student Attendence</title>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
	   	  	  <div class="card-header">
	   	  	  	<div class="cad-body">
	   	  	  		<form method="post" id="admin_login_form">
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter Username</label>
	   	  	  				<input type="text" name="admin_user_name" id="admin_user_name" class="form-control"/>
	   	  	  				<span id="error_admin_user_name" class="text-danger">
                                  
                            </span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				<label>Enter Paaswod </label>
	   	  	  				<input type="password" name="admin_password" id="admin_password" class="form-control "/>
	   	  	  				<span id="error_admin_password" class="text-danger"></span>
	   	  	  			</div>
	   	  	  			<div class="form-group">
	   	  	  				 
	   	  	  				<center><input type="submit" name="admin_login" id="admin_login" class="  btn btn-success " value="Login" /></center>
                             
	   	  	  				 
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
         
       // var admin_user_name=$('#admin_user_name').val();
        //var admin_password=$('#admin_password').val();

        $('#admin_user_name').on('focus',function(){
           $('#error_admin_user_name').text('');
        }) ;
         $('#admin_password').on('focus',function(){
           $('#error_admin_password').text('');
        }) ;
       $('#admin_login_form').on('submit',function(event)
       {   
        
            
            event.preventDefault();
             
            $.ajax({
            	url : "check_admin_login.php",
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
                             location.href="<?php echo $base_url;?>admin";
                        }
            		
            		if(data.error)
            		{
                        
            			$('#admin_login').val('login');
            			$('#admin_login').attr('disabled',false);
            			if(data.error_admin_user_name != '')
            			{
            				$('#error_admin_user_name').text(data.error_admin_user_name); 
                          /*  $('#admin_user_name').tooltip({
                                html:true,
                                container:'body',
                                placement:'right',
                                title:function()
                                {
                                    return $('#error_admin_user_name').html(data.error_admin_user_name);
                                }
                            });*/
            			} 
            			else 
            			{
            				$('#error_admin_user_name').text('');
            			}
            			if(data.error_admin_password!='')
            			{
            				$('#error_admin_password').text(data.error_admin_password); 
            			}
            			else
            			{
            				$('#error_admin_password').text('');
            			}
            		}
            	}
            });
       });
	});
</script>