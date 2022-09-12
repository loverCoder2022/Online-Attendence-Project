<?php
try
{
$con=new PDO('mysql:host=localhost;dbname=attendence;','root','');
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $e)
{
   echo "Could not connect ".$e->getMessage();	
}
  $base_url="https://localhost/project/attendence/";
  function get_table_data($con,$table_name)
  {
  	$query="SELECT * FROM $table_name";
  	$statement=$con->prepare($query);
  	$statement->execute();
  	return $statement->rowCount(); 

  }

function get_ocption_list($connect)
  {
  	$query="SELECT * FROM grade ORDER BY grade_id ASC ";
  	$statement=$connect->prepare($query);
  	$statement->execute();
  	$result=$statement->fetchAll();
  	$output='';
  	foreach($result as $row) 
  	{
  	  $output .='<option value='.$row["grade_id"].'>'.$row["grade_name"].'</option>';
  	 } 
    return $output;
  }
  function attendence_percentage($connect,$student_id)
  {
    $query = "
    SELECT
     ROUND((SELECT COUNT(*) FROM  attendence WHERE attendence_status='Present' AND 
     student_id='".$student_id."')*100/COUNT(*)) AS percentage FROM attendence WHERE student_id='".$student_id."'";
      $statement=$connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach ($result as $row) 
    {
       if ($row['percentage'] > 0) 
       {
          return $row['percentage']. '%';
       }
       else
       {
        return 'NA';
       }
    }
  }

  function get_student_name($con,$student_id)
  {
    $query="SELECT student_name FROM student WHERE student_id='".$student_id."'";
    $statement=$con->prepare($query);
    $statement->execute();
     $result= $statement->fetchAll(); 
     foreach ($result as $row) 
     {
        return $row['student_name'];
     }
  }
   function get_grade_name($con,$student_id)
  {
    $query="SELECT grade.grade_name FROM student
     INNER JOIN grade ON student.student_grade_id=grade.grade_id
     WHERE student.student_id='".$student_id."'";
    $statement=$con->prepare($query);
    $statement->execute();
     $result= $statement->fetchAll(); 
     foreach ($result as $row) 
     {
        return $row['grade_name'];
     }
  }
  function get_teacher_name($con,$student_id)
  {
    $query="SELECT teacher.teacher_name FROM student
     INNER JOIN grade ON student.student_grade_id=grade.grade_id
     INNER JOIN teacher ON teacher.teacher_grade_id=grade.grade_id
     WHERE student.student_id='".$student_id."'";
    $statement=$con->prepare($query);
    $statement->execute();
     $result= $statement->fetchAll(); 
     foreach ($result as $row) 
     {
        return $row['teacher_name'];
     }
  }
  
?>