
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8">
<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 5px solid #dddddd;
  /* text-align: left; */
  padding: 8px;
}

</style>
</head>
<body>
<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "st";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");


$today = date("Y-m-d");
//-----------pastttt out---------
$sql = "SELECT SUM(num) AS num_sum FROM stockout WHERE NOT outdate = '$today' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $last = $row['num_sum'];
} else {
     $last=0;
}


//-----------todayyyyy out---------
$sql = "SELECT SUM(num) AS num_sum_to FROM stockout WHERE outdate = '$today' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $day = $row['num_sum_to'];
} else {
     $day = 0;
}

//-----------todayyyyy unit---------
$sql = "SELECT unitcode FROM stockout WHERE outdate = '$today' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $uni = $row['unitcode'];
} else {
     $uni = "";
}

//-----------ALL out---------
$sql = "SELECT SUM(num) AS num_sum_all FROM stockout ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $all = $row['num_sum_all'];
} else {
     $all=0;
}

mysqli_close($conn);
?>

<h2 style="text-align:center" >تقرير المصروفات </h2>

<table style="text-align:center">
  <tr>
    <th style="background-color: #B7D8FF"></th>
    <th style="text-align:center; background-color: #B7D8FF" >العدد</th>
    <th style="text-align:center; background-color: #B7D8FF" >الوحدة</th>
  </tr>
  <tr>
    <td style="text-align:center">ما تم صرفه سابقا</td>
    <td style="text-align:center"><?php echo $last;?></td>
    <td style="text-align:center"></td>
  </tr>
  <tr>
    <td style="text-align:center">ما تم صرفه  اليوم</td>
    <td style="text-align:center"><?php echo $day;?></td>
    <td style="text-align:center"><?php echo $uni;?></td>
  </tr>
  <tr>
    <td style="text-align:center">الاجمالي المنصرف</td>
    <td style="text-align:center"><?php echo $all;?></td>
    <td style="text-align:center"></td>
  </tr>
</table>

</body>
</html>