<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]=="user")
{
  $user_id=$_SESSION["user_id"];
  if(isset($_POST['update']))
  {
      $user_name=$_POST['user_name'];
      $user_gender=$_POST['user_gender'];
      $user_blood_group=$_POST['user_blood_group'];
      $user_mobile=$_POST['user_mobile'];
      $user_email=$_POST['user_email'];
      $user_address=$_POST['user_address'];
      $query_insert = "UPDATE user_details set USER_NAME='".$user_name."',USER_GENDER='".$user_gender."',USER_BLOOD_GROUP='".$user_blood_group."',USER_MOBILE='".$user_mobile."',USER_EMAIL='".$user_email."',USER_ADDRESS='".$user_address."' where USER_ID='".$user_id."'";
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
      <a class="nav-link" href="user_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view_doctors.php">Search Doctor</a>
    </li>
    <li class="nav-item active">
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
<form method="post" name="user_detail">
<?php
  $query = "SELECT USER_ID,USER_NAME,USER_GENDER,USER_BLOOD_GROUP,USER_MOBILE,USER_EMAIL,USER_ADDRESS FROM user_details where USER_ID='".$user_id."'";
  mysqli_query($db, $query) or die('Error querying database.');
  $result = mysqli_query($db, $query);
  while ($row = mysqli_fetch_array($result))
  {
?>
<table class="table table-condensed">
  <tr>
    <td>ID</td>
    <td><?php echo $row['USER_ID'] ?></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="user_name" value="<?php echo $row['USER_NAME']  ?>"></td>
  </tr>
  <tr>
    <td>Gender</td>
    <td><input type="text" name="user_gender" value="<?php echo $row['USER_GENDER']  ?>"></td>
  </tr>
  <tr>
    <td>Blood Grooup</td>
    <td><input type="text" name="user_blood_group" value="<?php echo $row['USER_BLOOD_GROUP']  ?>"></td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td><input type="text" name="user_mobile" value="<?php echo $row['USER_MOBILE'] ?>"></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="user_email" value="<?php echo $row['USER_EMAIL'] ?>"></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="user_address" value="<?php echo $row['USER_ADDRESS'] ?>"></td>
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
