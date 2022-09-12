<?php
include_once('../admin/db.php');
 if($_POST['action']=='fetch')
        {
            $query="SELECT * FROM teacher WHERE teacher_id='".$_POST['teacher_id']."'";
            $statement=$con->prepare($query);
            if($statement->execute())
            { 
                $output=array();
                $result=$statement->fetchAll();
                foreach ($result as $row) 
                {
                    $output["teacher_id"]=$row['teacher_id'];
                    $output["teacher_password"]=$row['teacher_password'];
                    $output["teacher_email"]=$row['teacher_email'];
                    $output["teacher_name"]=$row['teacher_name'];
                    $output["teacher_qualification"]=$row['teacher_qualification'];
                    $output["teacher_mobile"]=$row['teacher_mobile'];
                    $output["teacher_address"]=$row['teacher_address'];
                    $output["teacher_grade_id"]=$row['teacher_grade_id'];
                    $output["teacher_image"]=$row['teacher_image'];


                }
             echo json_encode($output); 
            }
        }

           // code for teacher detail update
        if($_POST['action']=='Edit')
     {
        
        $teacher_id=$_POST['teacher_id'];
      $teacher_name=$_POST['teacher_name'];

        $teacher_email=$_POST['teacher_email'];
      $teacher_qualification=$_POST['teacher_qualification'];

        $teacher_mobile=$_POST['teacher_mobile'];
      $teacher_password=$_POST['teacher_password'];

        $teacher_address=$_POST['teacher_address'];
      $teacher_grade_id=$_POST['teacher_grade_id'];
        
           $query="UPDATE grade SET grade_name='$grade_name' WHERE grade_id='$grade_id'";
           $statement=$con->prepare($query);
            if($statement->execute())
            {
                $output=array(

                'success'=>true,
                'messege' => 'Data successful update'
                );
                echo json_encode($output);
            }
         
     }
?>