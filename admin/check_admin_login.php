<?php
 
include_once('db.php');
//ini_set("display_errors", 0);
session_start();
 
$admin_user_name='';
$admin_password='';
$error_admin_user_name='';
$error_admin_password='';
$error=0;
if(empty($_POST["admin_user_name"]))
{
	$error_admin_user_name='Username is required';
	$error++;  
}
else
{
	$admin_user_name=$_POST["admin_user_name"];
}
if(empty($_POST["admin_password"]))
{
	$error_admin_password='password is required';
	$error++;  
}
else
{  
	$admin_password=$_POST["admin_password"];
}



if($error==0)
{
	$query="SELECT * FROM admin WHERE admin_user_name='".$admin_user_name."'";
	 
	  
	$run=$con->prepare($query);
	if($run->execute())
	{ 
		 $pass=md5($admin_password);

		$total_row=$run->rowCount();
		if($total_row > 0)
		{
			$result=$run->fetchAll();
			foreach($result as $row) {
				  if( $pass == $row['admin_password'])
				  {
				  	$_SESSION['admin_id']=$row['admin_id'];
				  }
				  else
				  {
				  	$error_admin_password="wrong password";
				  	$error++;
				  }
			}

		}  
		else
		{
			$error_admin_user_name='wrong Username';
			$error++;

		}
	}
}

if($error > 0)
{
	$output=array(
    'error'                => true,
    'error_admin_user_name'=> $error_admin_user_name,
    'error_admin_password' =>  $error_admin_password 
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
