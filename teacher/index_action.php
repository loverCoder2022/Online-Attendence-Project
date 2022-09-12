<?php
 
include_once('../admin/db.php');
require_once 'pdf.php';
session_start();
ini_set('display_errors',0);

$output='';
 
	if($_POST['action']=='Fetch')
	{ 
		$query1=" SELECT * FROM attendence INNER JOIN student ON student.student_id=attendence.student_id INNER JOIN grade ON grade.grade_id=student.student_grade_id WHERE attendence.teacher_id='".$_SESSION['teacher_id']."' AND (";
		 
		if(isset($_POST["search"]["value"]))
		{
            $query1 .=" student.student_name LIKE '%".$_POST['search']['value']."%'
            OR student.student_rollno LIKE '%".$_POST['search']['value']."%'
            OR grade.grade_name LIKE '%".$_POST['search']['value']."%' )";
        
		}
		$query1 .= " GROUP BY student.student_id";
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .= ' ORDER BY student.student_rollno DESC ';

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
			$sub_array[]=$row["student_rollno"];
			 
			$sub_array[]=$row["grade_name"];
			
			 $sub_array[]=attendence_percentage($con,$row['student_id']);
			
			$sub_array[]='<button type="button" name="student_id" id="'.$row['student_id'].'" class="btn btn-sm btn-info report">Report</button>';
		 
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

     // every student report card in pdf
     if (isset($_GET['action'])) 
     {
     	 if ($_GET['action']=='student_report') 
     	 {

     	 	$student_id=$_GET['student_id'];
     	 	    $pdf =new pdf();
  	     $query="SELECT  * FROM attendence WHERE teacher_id='".$_SESSION['teacher_id']."' AND(student_id='".$student_id."') GROUP BY attendence_date ORDER BY attendence_date ASC
  	     ";
  	     $run=$con->prepare($query);
  	     $run->execute();
  	     $result=$run->fetchAll();

  	     $output='
           <style>
           @page{
           	margin:20px;
           }
           </style>
           <p>&nbsp;</p>
           <h3 align="center">Attendence Report</h3></br>
  	     ';
  	     foreach ($result as  $row) 
  	     {
  	     	$output.='

            <table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
               <td><b>Date-'.$row['attendence_date'].'</b></td>

              </tr>
              <tr>
               <td>
                <table width="100%" border="1" cellpadding="5" cellspacing="0">

              <tr>
              <td><b>Student Name:</b></td>
              <td><b>Roll number:</b></td>
              <td><b>Grade:</b></td>
              <td><b>Attendence status:</b></td>
              </tr>
              
  	     	';
  	     	$sub_query=
            " SELECT * FROM attendence INNER JOIN student ON student.student_id=attendence.student_id INNER JOIN grade ON grade.grade_id=student.student_grade_id WHERE attendence.teacher_id='".$_SESSION['teacher_id']."' AND student.student_id='".$row['student_id']."'";
  	        $run=$con->prepare($sub_query);
  	           $run->execute();
  	           $result=$run->fetchAll();
              
  	           foreach ($result as $row) 
  	           {
  	           	 $output.='
                  <tr>
                  <td>'.$row['student_name'].'</td>
                  <td>'.$row['student_rollno'].'</td>
                  <td>'.$row['grade_name'].'</td>'
                  
                 ;
  	           	 if ($row['attendence_status']=='Present') 
  	           	 {
  	           	 	$output .='<td style="background-color:green;">'.$row['attendence_status'].'</td>
                  </tr>' ;
  	           	 }
  	           	 else
  	           	 {
  	           	 	$output .='<td style="background-color:red;">'.$row['attendence_status'].'</td>
                  </tr>' ;
  	           	 }
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
?>