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
      $technician_name=$_POST['technician_name'];
      $patient_comments=$_POST['patient_comments'];
      $report_available=$_POST['report_available'];
      $doctor_fee=$_POST['doctor_fee'];
      
      $query_select = "SELECT MAX(REPORT_ID) as MAX_REPORT_ID FROM user_doctor_appointments";
      mysqli_query($db, $query_select) or die('Error querying database.');
      $result_select = mysqli_query($db, $query_select);
      $row = mysqli_fetch_array($result_select);
      if($row['MAX_REPORT_ID']==null)
      {
        $max_report_id='4000';
        // echo "<script>alert('".$max_report_id."');</script>";
      }
      else{
        $max_report_id=$row['MAX_REPORT_ID']+1;
        // echo "<script>alert(".$max_report_id.");</script>";        
      }
      
      if($patient_id != '')
      {
        $query_insert = "INSERT INTO user_doctor_appointments(USER_ID,USER_NAME,DOCTOR_ID,TECHNICIAN_NAME,DOCTOR_COMMENTS,REPORTS_DETAILS,REPORT_ID,FEES) VALUES('".$patient_id."','".$patient_name."','".$doctor_id."','".$technician_name."','".$patient_comments."','".$report_available."','".$max_report_id."','".$doctor_fee."')";
        mysqli_query($db, $query_insert) or die('Error querying database.');
      }
      $target_dir = "uploads/".$max_report_id."/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // // Check if image file is a actual image or fake image
      // if(isset($_POST["submit"])) {
      //     $check = getimagesize($_FILES["attachment"]["tmp_name"]);
      //     if($check !== false) {
      //         echo "File is an image - " . $check["mime"] . ".";
      //         $uploadOk = 1;
      //     } else {
      //         echo "File is not an image.";
      //         $uploadOk = 0;
      //     }
      // }
      // // Check if file already exists
      // if (file_exists($target_file)) {
      //     echo "Sorry, file already exists.";
      //     $uploadOk = 0;
      // }
      // // Check file size
      // if ($_FILES["attachment"]["size"] > 500000) {
      //     echo "Sorry, your file is too large.";
      //     $uploadOk = 0;
      // }
      // // Allow certain file formats
      // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      // && $imageFileType != "gif" ) {
      //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      //     $uploadOk = 0;
      // }
      // // Check if $uploadOk is set to 0 by an error
      // if ($uploadOk == 0) {
      //     echo "Sorry, your file was not uploaded.";
      // // if everything is ok, try to upload file
      // } else {
        if($report_available=='Y')
        {
          if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
              // echo "The file ". basename( $_FILES["attachment"]["name"]). " has been uploaded.";
          } else {
              echo "<script>alert('Sorry, there was an error uploading the file.');</script>";
          }
        }
      // }
  }
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Enter Report</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 <script src="script/javascripts.js"></script>
 <script src="script/jquery.js"></script>
 <script>
    function radio_on_change()
    {
      if($('#doctor_report_y').prop("checked"))
      {
        document.getElementById("report_available").value="Y";
        document.getElementById("report_span").style.display="";
      }
      if($('#doctor_report_n').prop("checked"))
      {
        document.getElementById("report_available").value="N";
        document.getElementById("report_span").style.display="none";
      }
    }

 </script>
 </head>
 <body>
 <div class="container" align="center">
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="doctor_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="enter_report.php">Enter Report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="doctor_profile.php">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_technician.php">Add Technician</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item">
        <span style="color:white">Welcome : <?php echo $doctor_id ?></span>
    </li>
  </ul>
</nav>
<form method="post" name="doctor_detail" enctype="multipart/form-data">
<?php
  $query = "SELECT DOCTOR_ID,DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST FROM doctor_details where DOCTOR_ID='".$doctor_id."'";
  mysqli_query($db, $query) or die('Error querying database.');
  $result = mysqli_query($db, $query);
  while ($row = mysqli_fetch_array($result))
  {
?>
<table class="table table-condensed">
  <tr>
    <td>Select Patient</td>
    <td>
      <select name="select_patient" onchange="autofillpatient(this)">
        <option value="">Select</option>
        <?php
          $select_patient_query = "SELECT USER_ID,USER_NAME FROM user_details";
          mysqli_query($db, $select_patient_query) or die('Error querying database.');
          $select_patient_result = mysqli_query($db, $select_patient_query);
          while ($select_patient_row = mysqli_fetch_array($select_patient_result))
          {
            echo "<option value='".$select_patient_row['USER_ID']."' p_name='".$select_patient_row['USER_NAME']."'>".$select_patient_row['USER_ID']." ".$select_patient_row['USER_NAME']."</option>";
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Patient ID</td>
    <td><input type="text" name="patient_id" id="patient_id" value=""></td>
  </tr>
  <tr>
    <td>Patient Name</td>
    <td><input type="text" name="patient_name" id="patient_name" value=""></td>
  </tr>
  <tr>
    <td>Technician Name</td>
    <td>
      <input type="text" name="technician_name" id="technician_name" value="">&nbsp;
      <select name="select_technician" onchange="autofilltechnician(this)">
        <option value="">Select</option>
        <?php
          $select_technician_query = "SELECT TECHNICIAN_NAME,CONTACT_NUMBER,DETAILS FROM technician_details";
          mysqli_query($db, $select_technician_query) or die('Error querying database.');
          $select_technician_result = mysqli_query($db, $select_technician_query);
          while ($select_technician_row = mysqli_fetch_array($select_technician_result))
          {
            echo "<option value='".$select_technician_row['TECHNICIAN_NAME']."'>".$select_technician_row['TECHNICIAN_NAME']."</option>";
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Fees</td>
    <td><input type="text" name="doctor_fee" id="doctor_fee" value=""></td>
  </tr>
  <tr>
    <td>Test Results</td>
    <td><textarea name="patient_comments" value=""></textarea></td>
  </tr>
  <tr>
    <td>Reports Available</td>
    <td>
        Yes <input type="radio" id="doctor_report_y" name="doctor_report" onchange="radio_on_change()">
        No <input type="radio" id="doctor_report_n" name="doctor_report" onchange="radio_on_change()">
        <input type="hidden" name="report_available" id="report_available" value="">
    </td>
  </tr>
  <tr id="report_span" style="display:none">
    <td>Attachment</td>
    <td><input type="file" name="attachment" id="attachment"></td>
  </tr>
</table>
<?php
  }
?>
<input type="submit" name="insert" value="Add">
</form>
</div>
</body>
</html>
<?php 
mysqli_close($db);
}else{
    header('location:logout.php');
}
?>
