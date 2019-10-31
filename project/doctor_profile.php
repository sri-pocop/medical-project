<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="doctor")
{
  $doctor_id=$_SESSION["doctor_id"];
  if(isset($_POST['update']))
  {
      $doctor_name=$_POST['doctor_name'];
      $doctor_mobile=$_POST['doctor_mobile'];
      $doctor_email=$_POST['doctor_email'];
      $doctor_specialist=$_POST['doctor_specialist'];
      // $query_insert = "INSERT INTO doctor_details(DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST) VALUES($doctor_name,$doctor_mobile,$doctor_email,$doctor_specialist) where DOCTOR_ID='".$doctor_id."'";
      $query_insert = "UPDATE doctor_details set DOCTOR_NAME='".$doctor_name."',DOCTOR_MOBILE='".$doctor_mobile."',DOCTOR_EMAIL='".$doctor_email."',SPECIALIST='".$doctor_specialist."' where DOCTOR_ID='".$doctor_id."'";
      //mysqli_query($db, $query_insert) or die('Error querying database.');
      $result_insert = mysqli_query($db, $query_insert);
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
    <li class="nav-item active">
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
<form method="post" name="doctor_detail">
<?php
  $query = "SELECT DOCTOR_ID,DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST FROM doctor_details where DOCTOR_ID='".$doctor_id."'";
  mysqli_query($db, $query) or die('Error querying database.');
  $result = mysqli_query($db, $query);
  while ($row = mysqli_fetch_array($result))
  {
?>
<table class="table table-condensed">
  <tr>
    <td>ID</td>
    <td><?php echo $row['DOCTOR_ID'] ?></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="doctor_name" value="<?php echo $row['DOCTOR_NAME']  ?>"></td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td><input type="text" name="doctor_mobile" value="<?php echo $row['DOCTOR_MOBILE'] ?>"></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="doctor_email" value="<?php echo $row['DOCTOR_EMAIL'] ?>"></td>
  </tr>
  <tr>
    <td>Specialist</td>
    <td><input type="text" name="doctor_specialist" value="<?php echo $row['SPECIALIST'] ?>"></td>
  </tr>
</table>
<?php
  }
?>
<input type="submit" name="update" value="Update">
</form>
  <a href="change_password.php">ChangePassword</a>
</div>
</body>
</html>
<?php 
}else{
    header('location:logout.php');
}
?>
