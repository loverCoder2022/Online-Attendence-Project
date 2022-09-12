<?php
include_once('../admin/db.php');
session_start();
ini_set('display_errors',0);
 
$output='';
 
	if($_POST['action']=='Fetch')
	{
		$query1=" SELECT * FROM attendence INNER JOIN student ON student.student_id=attendence.student_id INNER JOIN grade ON grade.grade_id=student.student_grade_id WHERE attendence.teacher_id='".$_SESSION['teacher_id']."'";
		 
		if(isset($_POST["search"]["value"]))
		{
           /* $query1 .=" WHERE student.student_name LIKE '%".$_POST['search']['value']."%'
            OR student.student_rollno LIKE '%".$_POST['search']['value']."%'
            OR attendence.attendence_date LIKE '%".$_POST['search']['value']."%'";
        */
		}
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .='ORDER BY attendence.attendence_id DESC ';

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
			$status='';
			 if($row['attendence_status']=='Present')
			 {
                $status='<label class="badge badge-success">Present</label>';
			 }
			  if($row['attendence_status']=='Absent')
			 {
                $status='<label class="badge badge-danger">Absent</label>';
			 }
			$sub_array[]=$row["student_name"];
			$sub_array[]=$row["student_rollno"];
			$sub_array[]=$row["student_email"];
			$sub_array[]=$row["grade_name"];
			
			
			$sub_array[]=$status;
			
			$sub_array[]=$row["attendence_date"];
		 
			$data[]=$sub_array;
		}
		$output=array(
          "draw"=>intval($_POST["draw"]),
          "recordsTotal" => $filtered_rows,
          "recordsFiltered" =>get_table_data($con,'attendence'),
          "data"=> $data
		);

     echo json_encode($output);
     }

     // attendence add
     if ($_POST['action']=='Add') 
     {
     	 $todayDate='';
     	 $error=0;
     	 $error_td='';
     	 $count=0;
     	 if (empty($_POST['todayDate'])) 
     	 {
     	 	 $error_td='Date is required';
     	 	 $error++;
     	 }
     	 else
     	 {
            $todayDate=$_POST['todayDate'];
     	 }
     	 if ($error==0) 
     	 {
     	 	    $student_id=$_POST['student_id'];
     	 	    $query="SELECT attendence_date FROM attendence WHERE attendence_date='".$todayDate."' AND teacher_id='".$_SESSION['teacher_id']."'"; 
     	 	    $statement=$con->prepare($query);
        	      $statement->execute(); 
        	      $row=$statement->rowCount();
        	      if ($row > 0) 
        	      {  
        	      	$output=array(
                     'error'=>true,
                     'error_td'=>'Attendence Date allready Exists on this Date'
        	      	);
        	         
        	        }
        	        else
        	        {
                        for ($count=0; $count < count($student_id); $count++ )
                        { 
                        	 $data=array(
                        	 	':student_id' => $student_id[$count],
                        	 ':attendence_status' =>$_POST['attendence_status'.$student_id[$count].''],
                        	 ':attendence_date'=>$todayDate,
                        	 ':teacher_id'=> $_SESSION['teacher_id']
                        	);
                         $query="INSERT INTO attendence (student_id,attendence_status,attendence_date,teacher_id)VALUES(:student_id,:attendence_status,:attendence_date,:teacher_id) ";
        	               $statement=$con->prepare($query);
        	               if($statement->execute($data))
        	               {
        	               	$output=array(
                                 'success'=>true,
                                 "messege"=>'Data successful added'
        	               	);
        	               }
                        }

        	        	
        	        }
        	
     	 }
     	 else
     	 {
     	 	$output=array(
            'error'=>true,
            'error_td'=>$error_td
     	 	);
     	 }
     	 echo json_encode($output);
     }
?>