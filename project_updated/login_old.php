<?php
include 'dbconnection.php';
$db = mysqli_connect('localhost:3308','test','test','medical')
 or die('Error connecting to MySQL server.');
?>

<html>
 <head>
 <meta charset="UTF-8">
<title>Login</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <form name="userLogin" method="post">
 <h3>User Login</h3>
 <input type="text" name="user_id" id="user_id" value="10001" >
 <input type="password" name="user_password" id="user_password" value="t@123" >
 <input type="submit" name="user_submit" id="user_submit">
 </form>
 <br>
 <form name="adminLogin" method="post">
 <h3>Doctor Login</h3>
 <input type="text" name="admin_id" id="admin_id" value="20001" >
 <input type="password" name="admin_password" id="admin_password" value="d@123" >
 <input type="submit" name="admin_submit" id="admin_submit">
 </form>
 </div>
 </body>
 </html>
<?php
//Step2
if(isset($_POST['user_id']) && isset($_POST['user_password']))
{
    $username=$_POST['user_id'];
    $userpassword=$_POST['user_password'];
    $query = "SELECT USER_PASSWORD,USER_ID FROM user_login_details where USER_ID='".$username."'";
    // mysqli_query($db, $query) or die('Error querying database.');
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    if ($row!=null)
    {
        if($row['USER_PASSWORD']==$userpassword)
        {
            var_dump($row);
            session_start();
            $_SESSION["loginUser"]="user";
            $_SESSION["user_id"]=$row['USER_ID'];
            $_SESSION["loginid"]=$username;
            header('location:user_dashboard.php');
        }
    }
}
if(isset($_POST['admin_id']) && isset($_POST['admin_password']))
{
    $username=$_POST['admin_id'];
    $userpassword=$_POST['admin_password'];
    $query = "SELECT DOCTOR_PASSWORD,DOCTOR_ID FROM doctor_login_details where DOCTOR_ID='".$username."'";
    mysqli_query($db, $query) or die('Error querying database.');
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    if ($row!=null)
    {
        if($row['DOCTOR_PASSWORD']==$userpassword)
        {
            var_dump($row);
            session_start();
            $_SESSION["loginUser"]="doctor";
            $_SESSION["doctor_id"]=$row['DOCTOR_ID'];
            $_SESSION["loginid"]=$username;
            header('location:doctor_dashboard.php');
        }
    }
}

mysqli_close($db);
?>