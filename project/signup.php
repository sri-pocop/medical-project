<html>
 <head>
 <meta charset="UTF-8">
<title>Sign Up</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <body>
 <div class="container" align="center">
 <?php
include 'dbconnection.php';
$query = "SELECT MAX(USER_ID) as MAXID FROM user_details";
mysqli_query($db, $query) or die('Error querying database.');
$result = mysqli_query($db, $query);
$row_maxid = mysqli_fetch_array($result);
$insertid = $row_maxid['MAXID']+1;
if(isset($_POST['Submit']))
  {
    $user_name=$_POST['username'];
    $user_gender=$_POST['usergender'];
    $user_blood_group=$_POST['userbloodgroup'];
    $user_mobile=$_POST['usermobile'];
    $user_email=$_POST['useremail'];
    $user_address=$_POST['useraddress'];
    if($user_name != "" && $insertid != "")
    {
        $query_insert_details = "INSERT INTO user_details(USER_ID,USER_NAME,USER_GENDER,USER_BLOOD_GROUP,USER_MOBILE,USER_EMAIL,USER_ADDRESS) VALUES('".$insertid."','".$user_name."','".$user_gender."','".$user_blood_group."','".$user_mobile."','".$user_email."','".$user_address."')";
        mysqli_query($db, $query_insert_details) or die('Error querying database.');
        $query_insert_login_details = "INSERT INTO user_login_details(USER_ID,USER_PASSWORD,USER_EMAIL) VALUES('".$insertid."','".$user_name."','".$user_email."')";
        mysqli_query($db, $query_insert_login_details) or die('Error querying database.');   
    }
    $_POST = array();
    echo "<h4 style='color:green'> Sign Up Successfull</h4><br>";
    echo "<h5>".$insertid." is your User ID<br>";
    echo " Your NAME is your password. <br>";
    echo " Kindly Change password once you Log in.</h5><br>";
    echo "<a href='login.php'>&nbsp;Click here to go to Log in page.</a>";
  }
  else{
?>

<form method="post" name="signup_form">
  <table class="table table-condensed">
  <thead>
    <tr>
      <th>
        Enter Details
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>ID</td>
      <td>
        <input type="text" name="userid" id="userid" value="<?php echo $insertid; ?>" readonly>
      </td>
    </tr>
    <tr>
      <td>NAME <span style="color:red">*</span></td>
      <td><input type="text" name="username" id="username" value=""></td>
    </tr>
    <tr>
        <td>GENDER</td>
        <td><input type="text" name="usergender" value=""></td>
    </tr>
    <tr>
        <td>BLOOD GROUP</td>
        <td><input type="text" name="userbloodgroup" value=""></td>
    </tr>
    <tr>
        <td>MOBILE <span style="color:red">*</span></td>
        <td><input type="text" name="usermobile" value=""></td>
    </tr>
    <tr>
        <td>EMAIL <span style="color:red">*</span></td>
        <td><input type="text" name="useremail" value=""></td>
    </tr>
    <tr>
        <td>ADDRESS</td>
        <td><input type="text" name="useraddress" value=""></td>
    </tr>
  </tbody>
  </table>

  <input type="submit" name="Submit" value="Submit">
</form>
</div>
</body>
</html>
<?php
  }
  ?>