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
  <link rel="stylesheet" href="css/bootstrap.css">
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
        echo "<td><input type='button' value='view' onclick='location.href=\"view_report.php?report_id=".$row['REPORT_ID']."&user_id=".$row['USER_ID']."&doctor_id=".$doctor_id."&id=".$row['ID']."\"'</td>";
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
