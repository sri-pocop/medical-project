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
 <link rel="stylesheet" href="css/login.css">
 </head>
 <style>
 body{
	 background: url(assets/background.jpg);
	 background-size: cover;
 }
 </style>
 <body>
 <div class="container" align="center">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="assets/user.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">Login</h4>	
                
			</div>
			<div class="modal-body">
				<form  name="userLogin" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="username" id="username" placeholder="Username" required="required">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="userpassword" id="userpassword" placeholder="Password" required="required">	
					</div>        
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-btn" name="user_submit" id="user_submit">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				New User <a href="signup.php">&nbsp;Sign Up</a>
			</div>
		</div>
	</div>    
</div>
 </body>
 </html>
<?php
//Step2
if(isset($_POST['username']) && isset($_POST['userpassword']))
{
    $username=$_POST['username'];
    $userpassword=$_POST['userpassword'];
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