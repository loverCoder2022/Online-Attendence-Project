<?php 
include_once('db.php');
session_start();
ini_set('display_errors',0);
$messege='';
$output='';
 
	if($_POST['action']=='get')
	{
		$query1=" SELECT * FROM teacher INNER JOIN grade ON teacher.teacher_grade_id=grade.grade_id ";
		 
		if(isset($_POST["search"]["value"]))
		{
            $query1.= "  WHERE teacher.teacher_name LIKE '%".$_POST["search"]["value"]."%'
            OR teacher.teacher_email LIKE '%".$_POST["search"]["value"]."%'
            OR teacher.teacher_grade_id LIKE '%".$_POST["search"]["value"]."%'";
        
		}
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .='ORDER BY teacher.teacher_id DESC ';

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
			$sub_array[]='<img src="teacher_image/'.$row["teacher_image"].'"class="img-thumbnail" width="75" height="75" >';
			$sub_array[]=$row["teacher_name"];
			$sub_array[]=$row["teacher_email"];
			$sub_array[]=$row["teacher_mobile"];
			$sub_array[]=$row["grade_name"];
			
			$sub_array[]='<button type="button" name="teacher_view" id="'.$row["teacher_id"].'" class="btn btn-primary btn-sm view_btn"><i class="fas fa-eye"></i></button>';
			$sub_array[]='<button type="button" name="edit_teacher" id="'.$row["teacher_id"].'" class="btn btn-primary btn-sm edit_teacher"><i class="fas fa-edit"></i></button>';
			$sub_array[]='<button type="button" name="delete_teacher" id="'.$row["teacher_id"].'" class="btn btn-danger btn-sm delete_teacher" value="'.$row["teacher_id"].'"><i class="fas fa-trash-alt"></i></button>';
			$data[]=$sub_array;
		}
		$output=array(
          "draw"=>intval($_POST["draw"]),
          "recordsTotal" => $filtered_rows,
          "recordsFiltered" =>get_table_data($con,'teacher'),
          "data"=> $data
		);

     echo json_encode($output);
     }
     if ($_POST['action']=='Add' || $_POST['action']=='Update') 
     {
        
     	$error=0;
     	$output='';
     	$error_teacher_name='';
     	$error_teacher_email='';
     	$error_mobile='';
     	$error_address='';
     	$error_qualification='';
     	$error_password='';
     	$error_image='';
     	$error_doj='';
        $error_teacher_grade_id='';
      
     	
         $teacher_image=$_POST['hide_teacher_image'];
         


     	if ($_FILES['teacher_image']['name'] != '') 
     	{
          $image=$_FILES['teacher_image']['name'];
          
     	  $tmp_image=$_FILES['teacher_image']['tmp_name'];
     	  $size=$_FILES['teacher_image']['size'];
     	  $extension=explode('.', $image);
     	  $extension_allowed=strtolower(end($extension));
     	   
     	 
     	  if ($extension_allowed=='jpg' || $extension_allowed=='jpeg' | $extension_allowed=='png') 
     		{
     			 
     			  if ($size > 512000)
                {
                     $error_image=' file size not large than 100 kb';
                      $error++;
                }
                 
                     else
                     {
                        $teacher_image=uniqid().'.'.$extension_allowed;

                    $location="teacher_image/".$teacher_image;
                    move_uploaded_file($tmp_image,$location);
                     }
     			 
     		}
     		else
     		{
     			$error_image=' jpeg or png type file allow';
                 $error++;
     		}
     	}
     	else
     	{
     		 
     			$error_image='please select image file';
     		     $error++;
     			 
     		
     		
     		
     	}

     	if(empty($_POST['teacher_name']))
     	{
     		$error_teacher_name=   'Name is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_name=$_POST['teacher_name'];
     	}
     	if(empty($_POST['teacher_email']))
     	{
     		$error_teacher_email=   'Email is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_email=$_POST['teacher_email'];
     	}
      
     	 
     	if(empty($_POST['mobile']))
     	{
     		$error_mobile=   'Mobile is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_mobile=$_POST['mobile'];
     	}
     	if(empty($_POST['teacher_address']))
     	{
     		$error_address=   'Address is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_address=$_POST['teacher_address'];
     	}
     	if(empty($_POST['teacher_qualification']))
     	{
     		$error_qualification=   'Qualification is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_qualification=$_POST['teacher_qualification'];
     	}
     		if(empty($_POST['teacher_password']))
     	{
     		$error_password=   'Password is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_password =md5($_POST['teacher_password']);
     	}
     		if(empty($_POST['teacher_grade_id']))
     	{
     		$error_teacher_grade_id= 'Grade is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_grade_id=$_POST['teacher_grade_id'];
     	}

     		if(empty($_POST['doj']))
     	{
     		$error_doj= 'DOJ is required';
     		$error++;
     	}
     	else
     	{
     		$teacher_doj=$_POST['doj'];
     	}

        if ($error==0) 
        {
            // update teacher
            if($_POST['action']=='Update')
            {
               $query="UPDATE teacher SET teacher_name='$teacher_name',teacher_qualification='$teacher_qualification',teacher_image='$teacher_image',teacher_address='$teacher_address' WHERE teacher_id='$teacher_id'";
                $statement=$con->prepare($query);
                   $statement->execute();
        
                 $messege='Data successful update';
           }
            else
            {


            $query="SELECT * FROM teacher WHERE teacher_email='".$_POST['teacher_email']."'";
            $statement=$con->prepare($query);
             $statement->execute();
             $row=$statement->rowCount();
             if($row > 0)
             {
                $output=array(
                 'error'=> true,
                 'messege' => 'this email already exists.'
                );
             }
             else
              {
        	$query="INSERT INTO teacher (teacher_name,teacher_email,teacher_mobile,teacher_qualification,teacher_address,teacher_password,teacher_doj,teacher_image,teacher_grade_id)VALUES('$teacher_name','$teacher_email','$teacher_mobile','$teacher_qualification','$teacher_address','$teacher_password','$teacher_doj','$teacher_image','$teacher_grade_id') ";
        	$statement=$con->prepare($query);
        	$statement->execute();
            $messege='Data successful insert';
        }
        }
        }
         if($error>0)
        {
        	
        	$output=array(
             'error' => true,
             'error_teacher_name' => $error_teacher_name,
             'error_teacher_email' => $error_teacher_email,
             'error_mobile' => $error_mobile,
             'error_qualification' => $error_qualification,
             'error_address' => $error_address,
             'error_image' => $error_image,
             'error_doj' => $error_doj,
             'error_password' => $error_password,
             'error_teacher_grade_id' => $error_teacher_grade_id
        	);
        }
        else
        {
        	$output=array(
              'success'=>true,
              'messege'=> $messege
        	);
        
        }
        echo json_encode($output);
     }
     // code for teacher record view

     if ($_POST['action']=='teacher_fetch') 
     {
        $teacher_id=$_POST['teacher_id'];
        $query=" SELECT * FROM teacher INNER JOIN grade ON teacher.teacher_grade_id=grade.grade_id WHERE teacher.teacher_id='".$teacher_id."'";
        $run=$con->prepare($query);
        if ($run->execute()) 
        {
             $total_row=$run->fetchAll();
             $outpout='<div class="col-md-3">';
             foreach ($total_row as  $row) 
             {
                $output .='<div class="col-md-3">
                <img src="teacher_image/'.$row["teacher_image"].'" class="img-thumbnail"></div>
                <div class="col-md-9">
                 <table class="table">
                <tr>
                  <th>Name</th>
                  <td>'.$row["teacher_name"].'</td>
                </tr>
                <tr>
                  <th>email:</th>
                  <td>'.$row["teacher_email"].'</td>
                </tr>
                <tr>
                  <th>Mobile:</th>
                  <td>'.$row["teacher_mobile"].'</td>
                </tr>
                <tr>
                  <th>Qualification</th>
                  <td>'.$row["teacher_qualification"].'</td>
                </tr>
                <tr>
                  <th>Grade</th>
                  <td>'.$row["grade_name"].'</td>
                </tr>
                

                 </table>
                </div>


                ';
             }
             $output .='</div>';
             echo json_encode($output);
        }

     }

     // delete teacher

     if($_POST['action']=='Delete_teacher')
        {
            $teacher_id=$_POST['teacher_id'];
            $query="SELECT * FROM teacher WHERE teacher_id='".$teacher_id."'";
            $statement=$con->prepare($query);
            if($statement->execute())
            { 
                $result=$statement->fetchAll();
                foreach ($result as $row) 
                {
                    $img=$row['teacher_image'];
                    unlink('teacher_image/'.$img);
                }
            }
            $query=" DELETE  FROM teacher WHERE  teacher_id='".$teacher_id."'";
            $statement=$con->prepare($query);
             if($statement->execute())
            {

                $output=array(

                'success'=> true,
                'messege' => 'data successful delete'
                );
            }
            echo json_encode($output);

        }
    // code for edit teacher details

        if($_POST['update']=='edit_teacher')
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
                    $output["teacher_name"]=$row['teacher_name'];
                    $output["teacher_email"]=$row['teacher_email'];
                    $output["teacher_password"]=$row['teacher_password'];
                     $output["teacher_doj"]=$row['teacher_doj'];
                    $output["teacher_qualification"]=$row['teacher_qualification'];
                    $output["teacher_mobile"]=$row['teacher_mobile'];
                    $output["teacher_address"]=$row['teacher_address'];
                    $output["teacher_grade_id"]=$row['teacher_grade_id'];
                    $output["teacher_image"]=$row['teacher_image'];
                    $output['status']=1;


                }
             echo json_encode($output); 
            }
        }

        // code for teacher detail update
        