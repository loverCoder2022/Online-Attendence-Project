<?php 

include_once('../admin/db.php');
session_start();
if(!isset($_SESSION['teacher_id']))
{
	header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Attendence</title>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
 
 

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>  
         
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
<link rel="stylesheet" href="../plugins/date/bootstrap-datepicker.css">
     <script type="text/javascript" src="../plugins/date/bootstrap-datepicker.js"></script>
 <link rel="stylesheet" href="../font/css/all.min.css">
  <script type="text/javascript" src="../font/js/all.min.js"></script>
	 
</head>
<body>
 
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-bottom fixed-top" style="font-weight: bold;">
        <a href="index.php" class="navbar-brand">Attendence</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#mynav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynav" >
            <ul class="navbar-nav ml-auto text-center">
              <li class="nav-item "><a href="index.php" class="nav-link active">Home</a></li>
                <li class="nav-item "><a href="profile.php" class="nav-link">Profile</a></li>
                
                <li class="nav-item"><a href="attendence.php" class="nav-link">Attendence</a></li>
                  
                <li class="nav-item"><a href="logout.php " class="nav-link" > Logout</a></li>
                     
                  
            </ul>
        </div>
    </nav>

     
        
 