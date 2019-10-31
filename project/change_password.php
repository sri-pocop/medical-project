<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]!="")
{
    if($_SESSION["loginUser"]=="user")
    {
        $user_id=$_SESSION["user_id"];
    }
    if($_SESSION["loginUser"]=="doctor")
    {
        $user_id=$_SESSION["doctor_id"];
        $doctor_id=$_SESSION["doctor_id"];
    }
    if(isset($_POST['change_submit']))
    {
        $user_name=$user_id;
        $old_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        if($_SESSION["loginUser"]=="user")
        {
            $query_update = "UPDATE user_login_details set USER_PASSWORD='".$new_password."' where USER_ID='".$user_name."' and USER_PASSWORD='".$old_password."'";
            $result_update = mysqli_query($db, $query_update);
            header('location:user_profile.php');
        }
        else if($_SESSION["loginUser"]=="doctor")
        {
            $query_update = "UPDATE doctor_login_details set DOCTOR_PASSWORD='".$new_password."' where DOCTOR_ID='".$user_name."' and DOCTOR_PASSWORD='".$old_password."'";
            $result_update = mysqli_query($db, $query_update);
            header('location:doctor_profile.php');
        }
    }
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Change Password</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <?php
 if($_SESSION["loginUser"]=="user")
 {
 ?>
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="user_profile.php">Cancel</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item">
        <span style="color:white">Welcome : <?php echo $user_id ?></span>
    </li>
  </ul>
</nav>
 <?php } ?>
 <?php
 if($_SESSION["loginUser"]=="doctor")
 {
 ?>
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="doctor_profile.php">Cancel</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item">
        <span style="color:white">Welcome : <?php echo $doctor_id ?></span>
    </li>
  </ul>
</nav>
 <?php } ?>
 <form method="post" name="password_form">
  <table class="table table-condensed">
  <thead>
    <tr>
      <th>
        Change Password
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>  
      <td>User ID</td>
      <td><input type="text" name="user_id" id="user_id" value="<?php echo $user_id ?>" readonly></td>
    </tr>
    <tr>
      <td>Old Password</td>
      <td><input type="password" name="old_password" id="old_password" value=""></td>
    </tr>
    <tr>
      <td>New Password</td>
      <td><input type="password" name="new_password" id="new_password" value=""></td>
    </tr>
  </tbody>
  </table>

  <input type="submit" name="change_submit" value="Change Password">
</form>
</div>
</body>
</html>
<?php 
}else{
    header('location:logout.php');
}
?>