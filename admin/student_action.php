<?php
include_once('db.php');
session_start();
ini_set('display_errors',0);
$messege='';
$output='';
 
	if($_POST['action']=='fetch')
	{
		$query1=" SELECT * FROM student INNER JOIN grade ON student.student_grade_id=grade.grade_id ";
		 
		if(isset($_POST["search"]["value"]))
		{
            $query1.= "  WHERE student.student_name LIKE '%".$_POST["search"]["value"]."%'
            OR student.student_rollno LIKE '%".$_POST["search"]["value"]."%'
            OR student.student_grade_id LIKE '%".$_POST["search"]["value"]."%'";
        
		}
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .='ORDER BY student.student_id DESC ';

		}
		if($_POST["length"] != -1)
		{
			$query1 .=" LIMIT ".$_POST['start']."  ,".$_POST['length']."  ";
		} 
		$statement= $con->prepare($query1);
		$statement->execute();
		$result=$statement->fetchAll();
        $data=array();
        $filtered_rows=$statement->rowCount();
		foreach ($result as $row) 
		{
			$sub_array= array();
			 
			$sub_array[]=$row["student_name"];
			$sub_array[]=$row["student_email"];
			$sub_array[]=$row["student_rollno"];
			$sub_array[]=$row["grade_name"];
			
		
			$sub_array[]='<button type="button" name="edit_student" id="'.$row["student_id"].'" class="btn btn-primary btn-md edit_student"><i class="fas fa-edit"></i></button>';
			$sub_array[]='<button type="button" name="delete_student" id="'.$row["student_id"].'" class="btn btn-danger btn-md delete_student" ><i class="fas fa-trash-alt"></i></button>';
			$data[]=$sub_array;
		}
		$output=array(
          "draw"=>intval($_POST["draw"]),
          "recordsTotal" => $filtered_rows,
          "recordsFiltered" =>get_table_data($con,'student'),
          "data"=> $data
		);

     echo json_encode($output);
     }

     // code for student add
     if($_POST['action']=='Add')
      {
       
      	$error=0;
      	$student_name='';
      	$student_email='';
      	$student_rollno='';
      	$student_grade_id='';
      	$student_dob='';
      	$error_student_name='';
      	$error_student_email='';
      	$error_student_rollno='';
      	$error_student_dob='';
      	$error_student_grade='';
      	$messege='';
      	
      	if(empty($_POST['student_name']))
      	{
           $error_student_name=' name is required..';
           $error++;
      	}
      	else
      	{
           $student_name=$_POST['student_name'];
      	}
      	if(empty($_POST['student_email']))
      	{
           $error_student_email='email is required..';
           $error++;
      	}
      	else
      	{
           $student_email=$_POST['student_email'];
      	}
      	if(empty($_POST['student_dob']))
      	{
           $error_student_dob=' dob is required..';
           $error++;
      	}
      	else
      	{
           $student_dob=$_POST['student_dob'];
      	}
      	if(empty($_POST['student_rollno']))
      	{
           $error_student_rollno='rollno is required..';
           $error++;
      	}
      	else
      	{
           $student_rollno=$_POST['student_rollno'];
      	}
      		if(empty($_POST['student_grade_id']))
      	{
           $error_student_grade='grade is required..';
           $error++;
      	}
      	else
      	{
           $student_grade_id=$_POST['student_grade_id'];
      	}
       
        if($error==0)

        {    $query2="SELECT * FROM student WHERE student_email='".$student_email."'";
             $statement=$con->prepare($query2);
        	$statement->execute();
        	$total_row=$statement->rowCount();
        	if($total_row >0)
        	{    $error++;
        		 $status=1;
        		 
        	}
        	else
         {
        

                
        	$query="INSERT INTO student (student_name,student_email,student_rollno,student_dob,student_grade_id)VALUES('$student_name','$student_email','$student_rollno','$student_dob','$student_grade_id') ";
        	$statement=$con->prepare($query);
        	$statement->execute();
        	 
        	 
        	 
        }	
        	
        }
         if($error>0)
        {
        	if($status==1)
        	{
        		$output=array(
                 
                 'error'=>true,
                 'messege' => 'this student allready exists' 
        		);
        		
        	}
        	else
        	{
        	$output=array(
             'error' => true,
             'error_student_name' => $error_student_name,
             'error_student_email' => $error_student_email,
             'error_student_rollno' => $error_student_rollno,
             'error_student_dob' => $error_student_dob,
             'error_student_grade' => $error_student_grade,

        	);
        }
        }
        else
        {
        	$output=array(
              'success'=>true,
              'messege'=>'student successful insert'
        	);
        
        }
    
  
  
         
        echo json_encode($output);
      }
      // delete student

           if($_POST['action']=='Delete')
        {
            $student_id=$_POST['student_id'];
            
            
             
            $query=" DELETE  FROM student WHERE  student_id='".$student_id."'";
            $statement=$con->prepare($query);
             if($statement->execute())
            {

                $output=array(

                'success'=> true,
                'messege' => 'student successful delete'
                );
            }
            echo json_encode($output);

        }

        if($_POST['update']=='edit_student')
        {
            $query="SELECT * FROM student WHERE student_id='".$_POST['student_id']."'";
            $statement=$con->prepare($query);
            if($statement->execute())
            { 
                $output=array();
                $result=$statement->fetchAll();
                foreach ($result as $row) 
                {
                    $output["student_id"]=$row['student_id'];
                    $output["student_name"]=$row['student_name'];
                    $output["student_email"]=$row['student_email'];
                    $output["student_dob"]=$row['student_dob'];
                    $output["student_rollno"]=$row['student_rollno'];
                    $output["student_grade_id"]=$row['student_grade_id'];
                  


                }
                $output['status']=1;
               echo json_encode($output); 
            }
        }
          // code for student detail update
        if($_POST['action']=='Update')
     {
        
           $student_id=$_POST['student_id'];
            $student_name=$_POST['student_name'];
            $student_rollno=$_POST['student_rollno'];
            $student_email=$_POST['student_email'];
            $student_grade_id=$_POST['student_grade_id'];
            $student_dob=$_POST['student_dob'];
        
           $query="UPDATE student SET student_name='$student_name',student_rollno='$student_rollno',student_email='$student_email',student_grade_id='$student_grade_id',student_dob='$student_dob' WHERE student_id='$student_id'";
           $statement=$con->prepare($query);
            if($statement->execute())
            {
                $output=array(

                'success'=>true,
                'messege' => 'student successful update'
                );
                echo json_encode($output);
            }
         
     }
?>