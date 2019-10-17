<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="user")
{
  $user_id=$_SESSION["user_id"];
  $doctor_id="";
  if(isset($_POST['search']))
  {
  $doctor_id = $_POST['doctor_search'];
  }
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Reports</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="user_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item active">
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
<form method="post" name="search_doctor">
  <table class="table table-condensed">
  <thead>
    <tr>
      <th>
        Doctor Details
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Doctor ID / Doctor Name</td>
      <td><input type="text" name="doctor_search" id="doctor_search" value=""></td>
    </tr>
  </tbody>
  </table>

  <input type="submit" name="search" value="Search">
</form>
<?php
  if($doctor_id!="")
  {
      $query = "SELECT DOCTOR_ID,DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST FROM doctor_details where DOCTOR_ID='".$doctor_id."' or DOCTOR_NAME='".$doctor_id."'";
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
        <td><?php echo $row['DOCTOR_NAME']  ?></td>
      </tr>
      <tr>
        <td>Mobile</td>
        <td><?php echo $row['DOCTOR_MOBILE'] ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo $row['DOCTOR_EMAIL'] ?></td>
      </tr>
      <tr>
        <td>Specialist</td>
        <td><?php echo $row['SPECIALIST'] ?></td>
      </tr>
    </table>
    <?php
      }
      if($rowcount=mysqli_num_rows($result)=='0')
        echo "No Details Available";
    }
     ?>
</div>
</body>
</html>
<?php 
}else{
    header('location:logout.php');
}
?>
