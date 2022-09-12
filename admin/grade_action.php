<?php 
include_once('db.php');
session_start();
ini_set('display_errors',0);
$messege='';
$output='';
 
	if($_POST['action']=='fetch')
	{
		$query1=" SELECT * FROM grade ";
		 
		if(isset($_POST["search"]["value"]))
		{
            $query1.= "  WHERE grade_name LIKE '%".$_POST["search"]["value"]."%'";
        
		}
		if(isset($_POST["order"]))
		{
			$query1 .='ORDER BY' .$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query1 .='ORDER BY grade_id DESC ';

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
		foreach ($result as $row) {
			$sub_array= array();
			$sub_array[]=$row["grade_name"];
			$sub_array[]='<button type="button" name="edit_grade" id="'.$row["grade_id"].'" class="btn btn-primary btn-sm edit_grade" ><i class="fas fa-edit"></i></button>';
			$sub_array[]='<button type="button" name="delete_grade" id="'.$row["grade_id"].'" class="btn btn-danger btn-sm delete_grade"><i class="fas fa-trash-alt"></i></button>';
			$data[]=$sub_array;
		}
		$output=array(
          "draw"=>intval($_POST["draw"]),
          "recordsTotal" => $filtered_rows,
          "recordsFiltered" =>get_table_data($con,'grade'),
          "data"=> $data
		);

     echo json_encode($output);
     }

         if($_POST['action']=='Add' || $_POST['action']=='Edit')
      {
       
      	$error=0;
      	$grade_name='';
      	$error_grade_name='';
      	
      	if(empty($_POST['grade_name']))
      	{
           $error_grade_name='grade name is required..';
           $error++;
      	}
      	else
      	{
           $grade_name=trim($_POST['grade_name']);
      	}
       

     

        if($error==0)

        {  
       if($_POST['action']=='Edit')
      {
      
            $grade_id=$_POST['grade_id'];
          // $grade_name=trim($_POST['grade_name']);
      
           $query="UPDATE grade SET grade_name='$grade_name' WHERE grade_id='$grade_id'";
           $messege='grade successful update';
           $statement=$con->prepare($query);
          if($statement->execute())
          {
            $output=array(

                'success'=>true,
                'messege' =>$messege
            );
             
          }
         
     }
           if($_POST['action']=='Add')
           {
          $query2="SELECT * FROM grade WHERE grade_name='".$grade_name."'";
             $statement=$con->prepare($query2);
        	$statement->execute();
        	$total_row=$statement->rowCount();
        	if($total_row >0)
        	{    $error++;
        		$error_grade_name="this grade allready exists";
        		$output=array(
               
                 'error'=>true,
                 'error_grade_name' => $error_grade_name   
        		);
        	}
        	else
         {
         

                
        	$query="INSERT INTO grade (grade_name)VALUES('$grade_name') ";
        	$statement=$con->prepare($query);
        	$statement->execute();
        	 
        	$messege="grade successful add"; 
        	 
        }	
        	
        }
      }
         if($error>0)
        {
        	
        	$output=array(
             'error' => true,
             'error_grade_name' => $error_grade_name
        	);
        }
        else
        {
        	$output=array(
              'success'=>true,
              'messege'=>$messege
        	);
        
        }
    
  
    
        
        echo json_encode($output);
      }
    
        	 
	// edit grade code

    if($_POST["actions"]=='edit_grade')
        {
        	$query="SELECT * FROM grade WHERE grade_id='".$_POST['grade_id']."'";
        	$statement=$con->prepare($query);
        	if($statement->execute())
        	{ 
        		$output=array();
        		$result=$statement->fetchAll();
        		foreach ($result as $row) 
        		{
        			$output["grade_name"]=$row['grade_name'];
        			$output["grade_id"]=$row['grade_id'];

        		}
        	 echo json_encode($output);	
        	}
        }
        	    
    
          

        


        // delete grade code

        if($_POST['action']=='Delete')
        {
        	$query="DELETE  FROM grade WHERE grade_id='".$_POST['grade_id']."'";
        	$statement=$con->prepare($query);
        	if($statement->execute($data))
        	{
        		$output=array(

                'success'=> true,
                'messege' => 'data successful delete'
        		);
        	}
        	echo json_encode($output);

        }
      
        

?>