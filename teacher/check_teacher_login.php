<?php
 
include_once('../admin/db.php');
//ini_set("display_errors", 0);
session_start();
 
$teacher_email='';
$teacher_password='';
$error_teacher_email='';
$error_teacher_password='';
$error=0;
if(empty($_POST["teacher_email"]))
{
	$error_teacher_email='Email is required';
	$error++;  
}
else
{
	$teacher_email=$_POST["teacher_email"];
}
if(empty($_POST["teacher_password"]))
{
	$error_teacher_password='password is required';
	$error++;  
}
else
{  
	$teacher_password=$_POST["teacher_password"];
}



if($error==0)
{
	$query="SELECT * FROM teacher WHERE teacher_email='".$teacher_email."'";
	 
	  
	$run=$con->prepare($query);
	if($run->execute())
	{ 
		 $pass=md5($teacher_password);

		$total_row=$run->rowCount();
		if($total_row > 0)
		{
			$result=$run->fetchAll();
			foreach($result as $row) {
				  if( $pass == $row['teacher_password'])
				  {
				  	$_SESSION['teacher_id']=$row['teacher_id'];
				  }
				  else
				  {
				  	$error_teacher_password="wrong password";
				  	$error++;
				  }
			}

		}  
		else
		{
			$error_teacher_email='wrong Email';
			$error++;

		}
	}
}

if($error > 0)
{
	$output=array(
    'error'                => true,
    'error_teacher_email'=> $error_teacher_email,
    'error_teacher_password' =>  $error_teacher_password 
	);
}
else
{
	$output=array(
		'success'  => true
	);
}

echo json_encode($output);

?>
 