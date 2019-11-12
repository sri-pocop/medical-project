<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="doctor")
{
  $doctor_id=$_SESSION["doctor_id"];
  if(isset($_POST['insert']))
  {
      $technician_name=$_POST['tech_name'];
      $technician_mobile=$_POST['tech_mobile'];
      $technician_details=$_POST['tech_details'];
      $query_insert = "INSERT INTO technician_details(TECHNICIAN_NAME,CONTACT_NUMBER,DETAILS) VALUES('".$technician_name."','".$technician_mobile."','".$technician_details."')";
      mysqli_query($db, $query_insert) or die('Error querying database.');
      // $result_insert = mysqli_query($db, $query_insert);
  }
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Profile</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="doctor_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="enter_report.php">Enter Report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="doctor_profile.php">Profile</a>
    </li>
    <li class="nav-item active">
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
<form method="post" name="doctor_detail">
<table class="table table-condensed">
    <td>Technician Name</td>
    <td><input type="text" name="tech_name" value=""></td>
  </tr>
  <tr>
  <td>Contact Number</td>
    <td><input type="text" name="tech_mobile" value=""></td>
  </tr>
  <tr>
  <td>Details</td>
    <td><input type="text" name="tech_details" value=""></td>
  </tr>
</table>
<input type="submit" name="insert" value="Add">
</form>
</div>
</body>
</html>
<?php 
}else{
    header('location:logout.php');
}
?>
