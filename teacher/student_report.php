<?php
// every student report card in pdf
include_once('../admin/db.php');
require_once 'pdf.php';
     if (isset($_GET['action'])) 
     {

     	 if ($_GET['action']=='student_report') 
     	 {
        session_start();
     	 	echo "string";
     	 	die();

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
                  <td>'.$row['grade_name'].'</td>
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
     ?>