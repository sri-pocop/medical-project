<?php  
session_start();
//export.php  
include 'dbconnection.php';
$output = '';
if($_POST["user"]=="doctor" && isset($_POST["filename"]))
{
     $doctor_id=$_POST["doctor_id"];
     if($_POST["filename"] != ''){
          $filename=$_POST["filename"];
     }
     else{
          $filename=$doctor_id;
     }
     
     $query = "SELECT TECHNICIAN_NAME,CONTACT_NUMBER,DETAILS FROM technician_details";
     $result = mysqli_query($db, $query);
     if(mysqli_num_rows($result) > 0)
     {
     $output .= '
     <table class="table" bordered="1">  
                         <tr>  
                              <th>Name</th>  
                              <th>Address</th>  
                              <th>City</th>  
                         </tr>
     ';
     while($row = mysqli_fetch_array($result))
     {
     $output .= '
     <tr>  
                              <td>'.$row["TECHNICIAN_NAME"].'</td>  
                              <td>'.$row["CONTACT_NUMBER"].'</td>  
                              <td>'.$row["DETAILS"].'</td>  
                         </tr>
     ';
     }
     $output .= '</table>';
     header('Content-Type: application/xls');
     header('Content-Disposition: attachment; filename='.$filename.'.xls');
     echo $output;
     }
     // header('location:doctor_dashboard.php');
}else{
     header('location:logout.php');
 }

?>