<?php
include_once('db.php');
require_once '../teacher/pdf.php';
 
ini_set('display_errors',0);
 
$output='';
 
	if($_POST['action']=='index_fetch')
	{
		$query1=" SELECT * FROM student 
		    LEFT JOIN attendence ON attendence.student_id=student.student_id 
		     INNER JOIN grade ON grade.grade_id=student.student_grade_id 
		     INNER JOIN teacher ON teacher.teacher_grade_id=grade.grade_id";
		 
		if(isset($_POST["search"]["value"]))
		{
            $query1 .=" WHERE student.student_name LIKE '%".$_POST['search']['value']."%'
            OR student.student_rollno LIKE '%".$_POST['search']['value']."%'
            OR grade.grade_name LIKE '%".$_POST['search']['value']."%'
            OR teacher.teacher_name LIKE '%".$_POST['search']['value']."%'";
        
		}
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .='ORDER BY student.student_name ASC ';

		}
		if($_POST["length"] != -1)
		{
			$query1 .=" LIMIT ".$_POST['start']."  ,".$_POST['length'];
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
			$sub_array[]=$row["student_rollno"];
		     $sub_array[]=$row["grade_name"];
             $sub_array[]= attendence_percentage($con,$row['student_id']);
			$sub_array[]=$row["teacher_name"];
		     $sub_array[]='<button type="button" name="student_report" id="'.$row["student_id"].'" class="btn btn-info btn-sm student_report">Report</button>
		      ';
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

     if (isset($_GET['action'])) {
 
  require_once '../pdf.php';
  
  if ($_GET['action']=='report_action') 
  { 

  	session_start();
  	 if (isset($_GET['fromdate'],$_GET['todate'],$_GET['student_id'])) 
  	 {

  	     $pdf =new pdf();
  	     $query="SELECT * FROM student 
  	     INNER JOIN grade ON grade.grade_id=student.student_grade_id WHERE student.student_id='".$_GET['student_id']."'";
  	     $run=$con->prepare($query);
  	     $run->execute();
  	     $result=$run->fetchAll();
 
  	     foreach ($result as  $row) 
  	     {
  	     	$output.='
                <style>
           @page{
           	margin:20px;
           }
           </style>
           <p>&nbsp;</p>
           <h3 align="center">Attendence Report</h3></br>
  	     
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
               <td width="25%"><b>Student Name</b></td>
                <td width="75%"><b>'.$row['student_name'].'</b></td>
              </tr>
              <tr>
               <td width="25%"><b>Student Rollno</b></td>
                <td width="75%"><b>'.$row['student_rollno'].'</b></td>
              </tr>
              <tr>
               <td width="25%"><b>Grade</b></td>
                <td width="75%"><b>'.$row['grade_name'].'</b></td>
              </tr>
              <tr>
               <td colspan="2">
                <table width="100%" border="1" cellpadding="5" cellspacing="0">

              <tr>
              <td><b>Attendence Date:</b></td>
              <td><b>Attendence status:</b></td>
              </tr>
              
  	     	';
  	     	$sub_query=
            " SELECT * FROM attendence  WHERE student_id='".$_GET['student_id']."'
            AND(attendence_date BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."') ORDER BY attendence_date ASC
            ";
  	        $run=$con->prepare($sub_query);
  	           $run->execute();
  	           $result=$run->fetchAll();
              
  	           foreach ($result as $row) 
  	           {
  	           	 $output.='
                  <tr>
                  <td>'.$row['attendence_date'].'</td>
                  <td>'.$row['attendence_status'].'</td>
                  
                  </tr>
  	           	 ';
  	           }
  	           $output.='
                 </table>  
               </td>
              </tr>
            </table>
  	           '; 
  	     }
  	     $file_name='attendence Report.pdf';
  	     $pdf->loadHtml($output);
        // $pdf->setPaper('A4', 'landscape'); 
  	     $pdf->render();
  	     $pdf->stream($file_name,array("Attachment"=>false));
  	     exit(0);

  	 }
  }
}


?>