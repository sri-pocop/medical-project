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
 <body>
 <div class="container" align="center">
 <table>
    <tr>
        <td>
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="assets/user.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">User Login</h4>	
                
			</div>
			<div class="modal-body">
				<form  name="userLogin" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="user_id" id="user_id" placeholder="Username" required="required">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" required="required">	
					</div>        
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-btn" name="user_submit" id="user_submit">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>

</div>  
        </td>
        <td>&nbsp;</td>
        <td>
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="assets/doctor.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">Admin Login</h4>	
                
			</div>
			<div class="modal-body">
				<form name="adminLogin" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="admin_id" id="admin_id" placeholder="Username" required="required">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Password" required="required">	
					</div>        
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-btn" name="admin_submit" id="admin_submit">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>

</div>  
        </td>
    </tr>
    </table>
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