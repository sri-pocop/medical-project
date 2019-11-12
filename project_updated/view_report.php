<?php
session_start();
include 'dbconnection.php';
if($_SESSION["loginUser"]!="")
{
    // var_dump($_POST);
    $report_id=$_POST["report_id"];
    $user_id=$_POST["user_id"];
    $doctor_id=$_POST["doctor_id"];
    $user_doctor_id=$_POST["id"];
?>
<html>
 <head>
 <meta charset="UTF-8">
<title>Reports</title>
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
      <a class="nav-link" href="user_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
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
 <?php } ?>
 <?php
 if($_SESSION["loginUser"]=="doctor")
 {
 ?>
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
    <li class="nav-item">
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
 <?php } ?>
<table class="table table-condensed">
<tr>
    <td>
        <?php
        $query = "SELECT USER_ID,USER_NAME,USER_GENDER,USER_BLOOD_GROUP,USER_MOBILE,USER_EMAIL,USER_ADDRESS FROM user_details where USER_ID='".$user_id."'";
        mysqli_query($db, $query) or die('Error querying database.');
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        $query_d = "SELECT DOCTOR_ID,DOCTOR_NAME,DOCTOR_MOBILE,DOCTOR_EMAIL,SPECIALIST FROM doctor_details where DOCTOR_ID='".$doctor_id."'";
        mysqli_query($db, $query_d) or die('Error querying database.');
        $result_d = mysqli_query($db, $query_d);
        $row_d = mysqli_fetch_array($result_d);
        
        $query_r = "SELECT TECHNICIAN_NAME,APPOINTMENT_DATE,DOCTOR_COMMENTS,REPORTS_DETAILS,FEES FROM user_doctor_appointments where ID='".$user_doctor_id."'";
        mysqli_query($db, $query_r) or die('Error querying database.');
        $result_r = mysqli_query($db, $query_r);
        $row_r = mysqli_fetch_array($result_r);
        
        ?>
        <table class="table table-condensed">
        <thead>
        <tr>
        <th>
            Patient Details
        </th>
        <th>
        </th>
        </tr>
        </thead>
        <tr>
            <td>ID</td>
            <td><?php echo $row['USER_ID'] ?></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><?php echo $row['USER_NAME']  ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php echo $row['USER_GENDER']  ?></td>
        </tr>
        <tr>
            <td>Blood Grooup</td>
            <td><?php echo $row['USER_BLOOD_GROUP']  ?></td>
        </tr>
        <tr>
            <td>Mobile</td>
            <td><?php echo $row['USER_MOBILE'] ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $row['USER_EMAIL'] ?></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><?php echo $row['USER_ADDRESS'] ?></td>
        </tr>
        </table>
        
    </td>
    <td>
    <table class="table table-condensed">
        <thead>
                <tr>
                    <th>
                        Doctor Details
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
    <tr>
        <td>ID</td>
        <td><?php echo $row_d['DOCTOR_ID'] ?></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?php echo $row_d['DOCTOR_NAME']  ?></td>
    </tr>
    <tr>
        <td>Mobile</td>
        <td><?php echo $row_d['DOCTOR_MOBILE'] ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo $row_d['DOCTOR_EMAIL'] ?></td>
    </tr>
    <tr>
        <td>Specialist</td>
        <td><?php echo $row_d['SPECIALIST'] ?></td>
    </tr>
    </table>
    
    <td>
        
    </td>
<tr>
<tr>
<td>
        <table class="table table-condensed">
        <thead>
            <tr>
                <th colspan="2">
                    Appointment Details
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Technician Name</td>
                <td><?php echo $row_r['TECHNICIAN_NAME'] ?></td>
            </tr>
            <tr>
                <td>Appoinment Date</td>
                <td><?php echo $row_r['APPOINTMENT_DATE'] ?></td>
            </tr>
            <tr>
                <td>Report Attached</td>
                <td><?php if($row_r['REPORTS_DETAILS']=="Y"){echo "Yes";}
                        else {echo "No";} 
                    ?>
                </td>
            </tr>
        </tbody>
        </table>
    </td>
    <td>
        <table class="table table-condensed">
        <thead>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Comments</td>
                <td><?php echo $row_r['DOCTOR_COMMENTS'] ?></td>
            </tr>
            <tr>
                <td>Fee's </td>
                <td>Rs. <?php echo $row_r['FEES'] ?></td>
            </tr>
        </tbody>
        </table>
    </td>
    
    
</tr>
<tr>
    <td>
        <?php
        if($report_id!="" && $row_r['REPORTS_DETAILS']=="Y"){
            // $target_open_location = "uploads/4002/";
            $target_open_location = "uploads/".$report_id."/";
            // $myfile = fopen($target_open_location, "r") or die("Unable to open file!");
            // echo fread($myfile,filesize("webdictionary.txt"));
            // fclose($myfile);
            // $files = scandir($target_open_location);
            $files = array_diff(scandir($target_open_location), array('.', '..'));
            echo "<table class='table table-condensed'>";
            echo "<thead><tr><th>Attached Report</th></tr></thead>";
            foreach($files as $file) {
                $target_open_location_file = "uploads/".$report_id."/".$file;
                // $myfile = fopen($target_open_location_file, "r") or die("Unable to open file!");
                // fclose($myfile);
                // $handle = fopen($target_open_location_file, "r"); 
                // echo file_get_contents($target_open_location_file);
                echo "<tr><td>".$file."</td>";
                echo "<td><a href='".$target_open_location_file."'>Click to View</a></td>";
                echo "<td><a href='".$target_open_location_file."'download>Click to Download</a></td></tr>";
            //do your work here
            }
            echo "</table>";
        }
        else{
            echo "No Reports Uploaded";
        }
        
        ?>
    </td>
</tr>
</table>
</div>
</body>
</html>
<?php 
}else{
    header('location:logout.php');
}
?>