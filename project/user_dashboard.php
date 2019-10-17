<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="user")
{
  $user_id=$_SESSION["user_id"];
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Dashboard</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="user_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view_doctors.php">Search Doctor</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="user_profile.php">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item">
        <span style="color:white">Welcome : <?php echo $user_id ?></span>
    </li>
  </ul>
</nav>
<h4>Doctor's Visited</h4>
 <table class="table table-hover">
   <thead>
     <tr>
       <th>Doctor ID</th>
       <th>Date</th>
       <th>Doctor Comments</th>
       <th>Action</th>
     </tr>
   </thead>
   <tbody>
   <?php
      $query = "SELECT ID,DOCTOR_ID,APPOINTMENT_DATE,DOCTOR_COMMENTS,REPORT_ID FROM user_doctor_appointments where USER_ID='".$user_id."'";
      mysqli_query($db, $query) or die('Error querying database.');
      $result = mysqli_query($db, $query);
      
      // var_dump($row);
      while ($row = mysqli_fetch_array($result))
      {
        echo "<tr>";
        echo "<td>"  . $row['DOCTOR_ID'] . "</td>";
        echo "<td>"  . $row['APPOINTMENT_DATE'] . "</td>";
        echo "<td>"  . $row['DOCTOR_COMMENTS'] . "</td>";
        echo "<td><input type='button' value='view' onclick='location.href=\"view_report.php?report_id=".$row['REPORT_ID']."&user_id=".$user_id."&doctor_id=".$row['DOCTOR_ID']."&id=".$row['ID']."\"')></td";
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
