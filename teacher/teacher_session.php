<?php
if (!isset($_SESSION['teacher_id'])) 
{
	header("location:login.php");
}
?>