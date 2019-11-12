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
     $query_r = "SELECT USER_ID,TECHNICIAN_NAME,APPOINTMENT_DATE,DOCTOR_COMMENTS,REPORTS_DETAILS,FEES FROM user_doctor_appointments where DOCTOR_ID='".$doctor_id."'";
     $result_r = mysqli_query($db, $query_r);
     $row_r = mysqli_fetch_array($result_r);
     
     if(mysqli_num_rows($result_r) > 0)
     {
          $output .= '
          <table class="table" bordered="1">  
                              <tr>  
                                   <th>Patient Id</th>  
                                   <th>Patient Name</th>  
                                   <th>Date Attended</th>
                                   <th>Comments</th>  
                                   <th>Reports given</th>  
                                   <th>Fee\'s</th>  
                              </tr>
          ';
          while($row = mysqli_fetch_array($result_r))
          {
          $query_u = "SELECT USER_ID,USER_NAME,USER_GENDER,USER_BLOOD_GROUP,USER_MOBILE,USER_EMAIL,USER_ADDRESS FROM user_details where USER_ID='".$row['USER_ID']."'";
          $result_u = mysqli_query($db, $query_u);
          $row_u = mysqli_fetch_array($result_u);

          $query_d = "SELECT DOCTOR_ID,DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST FROM doctor_details where DOCTOR_ID='".$doctor_id."'";
          $result_d = mysqli_query($db, $query_d);
          $row_d = mysqli_fetch_array($result_d);

          if($row["REPORTS_DETAILS"] == 'Y'){
               $reports_given = "Yes";
          }else{
               $reports_given = "No";
          }
          $output .= '
          <tr>  
                                   <td>'.$row["USER_ID"].'</td>  
                                   <td>'.$row_u["USER_NAME"].'</td>  
                                   <td>'.$row["APPOINTMENT_DATE"].'</td> 
                                   <td>'.$row["DOCTOR_COMMENTS"].'</td>  
                                   <td>'.$reports_given.'</td>  
                                   <td>'.$row["FEES"].'</td>  
                              </tr>
          ';
          }
     }
     $output .= '</table>';
     header('Content-Type: application/xls');
     header('Content-Disposition: attachment; filename='.$filename.'.xls');
     echo $output;
}else{
     header('location:logout.php');
 }

?>