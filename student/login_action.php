<?php
 
include_once('../admin/db.php');
//ini_set("display_errors", 0);
session_start();
 
$student_rollno='';
$student_name='';
$student_dob='';
$student_id='';
$error_student_rollno='';
$error_student_dob='';
$error=0;
if(empty($_POST["student_rollno"]))
{
	$error_student_rollno='rollno is required';
	$error++;  
}
else
{
	$student_rollno=$_POST["student_rollno"];
}
if(empty($_POST["student_dob"]))
{
	$error_student_dob='dob is required';
	$error++;  
}
else
{  
	$student_dob=$_POST["student_dob"];
}



if($error==0)
{
	$query="SELECT * FROM student WHERE student_rollno='".$student_rollno."'";
	 
	  
	$run=$con->prepare($query);
	if($run->execute())
	{ 
		  
        
		$total_row=$run->rowCount();
		if($total_row > 0)
		{
			$result=$run->fetchAll();
			foreach($result as $row) {
				  if( $student_rollno == $row['student_rollno'])
				  {
				  	$_SESSION['student_id']=$row['student_id'];
				  	 
				  }
				  else
				  {
				  	$error_student_rollno="wrong rollno";
				  	$error++;
				  }
			}

		}  
		else
		{
			$error_student_dob='wrong dob';
			$error++;

		}
	}
}

if($error > 0)
{
	$output=array(
    'error'                => true,
    'error_student_rollno'=> $error_student_rollno,
    'error_student_dob' =>  $error_student_dob 
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
 