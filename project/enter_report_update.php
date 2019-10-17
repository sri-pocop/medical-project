<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="doctor")
{
  $doctor_id=$_SESSION["doctor_id"];
  if(isset($_POST['insert']))
  {
      $patient_id=$_POST['patient_id'];
      $patient_name=$_POST['patient_name'];
      $patient_comments=$_POST['patient_comments'];
      $report_available=$_POST['report_available'];
      if($patient_id != '')
      {
        $query_insert = "INSERT INTO user_doctor_appointments(USER_ID,USER_NAME,DOCTOR_ID,DOCTOR_COMMENTS,REPORTS_DETAILS) VALUES('".$patient_id."','".$patient_name."','".$doctor_id."','".$patient_comments."','".$report_available."')";
        mysqli_query($db, $query_insert) or die('Error querying database.');
        //$result_insert = mysqli_query($db, $query_insert);
      }
      // $query_insert = "INSERT INTO doctor_details(DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST) VALUES($doctor_name,$doctor_mobile,$doctor_email,$doctor_specialist) where DOCTOR_ID='".$doctor_id."'";
      // $query_insert = "UPDATE doctor_details set DOCTOR_NAME='".$doctor_name."',DOCTOR_MOBILE='".$doctor_mobile."',DOCTOR_EMAIL='".$doctor_email."',SPECIALIST='".$doctor_specialist."' where DOCTOR_ID='".$doctor_id."'";
      //
      header('location:enter_report.php');
  }
  mysqli_close($db);
}else{
    header('location:logout.php');
}
?>
