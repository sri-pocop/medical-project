<?php
session_start();
if($_SESSION["loginUser"]=="user")
{
    echo "user login";
}elseif($_SESSION["loginUser"]=="admin")
{
    echo "admin login";
}else{
    header('location:logout.php');
}
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Dashboard</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 </head>
 <?php
 echo $_SESSION["loginid"];
 ?>
 <body>
 </body>
 </html>