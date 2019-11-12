<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="doctor")
{
  $doctor_id=$_SESSION["doctor_id"];
?>
  <html>
  <head>
  <meta charset="UTF-8">
 <title>Doctor Dashboard</title>
 <script src="script/javascripts.js"></script>
 <script>
 function generate_excel()
  {
    var excel_name=$('#excel_name').val();
    params = {user:'doctor',doctor_id:<?php echo $doctor_id ?>,filename : excel_name };
    path = "excel_generation.php";
    post(path,params);
  }
  function viewdynamicpost(d_id,a_id)
{
    path = "edit_report.php";
    // params = "report_id="+r_id+"&user_id="+p_id+"&doctor_id="+d_id+"&id="+a_id;
    params = {doctor_id:d_id,id:a_id};
    post(path,params);
}
 </script>
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="script/javascripts.js"></script>
 <script src="script/jquery.js"></script>
  </head>
  <body>
  <div class="container" align="center">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
   <ul class="navbar-nav mr-auto">
     <li class="nav-item active">
       <a class="nav-link" href="doctor_dashboard.php">Dashboard</a>
     </li>
     <li class="nav-item">
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
 <h4>Patients Attended</h4>
 <div align="right">File Name:&nbsp;<input type="text" name="excel_name" id="excel_name" placeholder="optional">&nbsp;<input type="button" value="Export to Excel" onclick="generate_excel()"><br></div>
 <table class="table table-hover">
   <thead>
     <tr>
       <th>Patient ID</th>
       <th>Patient Name</th>
       <th>Date</th>
       <th>Action</th>
     </tr>
   </thead>
   <tbody>
   <?php
      $query = "SELECT ID,USER_ID,USER_NAME,APPOINTMENT_DATE,REPORT_ID FROM user_doctor_appointments where DOCTOR_ID='".$doctor_id."'";
      mysqli_query($db, $query) or die('Error querying database.');
      $result = mysqli_query($db, $query);
      
      // var_dump($row);
      while ($row = mysqli_fetch_array($result))
      {
        echo "<tr>";
        echo "<td>"  . $row['USER_ID'] . "</td>";
        echo "<td>"  . $row['USER_NAME'] . "</td>";
        echo "<td>"  . $row['APPOINTMENT_DATE'] . "</td>";
        // echo "<td><input type='button' value='view' onclick='location.href=\"view_report.php?report_id=".$row['REPORT_ID']."&user_id=".$row['USER_ID']."&doctor_id=".$doctor_id."&id=".$row['ID']."\"'></td>";
        echo "<td>";
        echo "<input type='button' value='View' onclick=\"dynamicpost('".$row['REPORT_ID']."','".$row['USER_ID']."','".$doctor_id."','".$row['ID']."')\">&nbsp;";
        echo "</td>";
        echo "</tr>";        
      }
    ?>
   </tbody>
 </table>
 </div>
 </body>
 </html>
<?php 
}else{
    header('location:logout.php');
}
?>
