
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
//-----------pastttt prod---------
$sql = "SELECT SUM(num) AS num_sum FROM stock WHERE NOT entdate = '$today' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $last = $row['num_sum'];
} else {
     $last=0;
}


//-----------todayyyyy prod---------
$sql = "SELECT SUM(num) AS num_sum_to FROM stock WHERE entdate = '$today' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $day = $row['num_sum_to'];
} else {
     $day=0;
}

//-----------ALL prod---------
$sql = "SELECT SUM(num) AS num_sum_all FROM stock ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result); 
    $all = $row['num_sum_all'];
} else {
     $all=0;
}

// //-----------3ohdaa prod---------
// $sql = "SELECT SUM(num) AS num_sum_all FROM stock WHERE itemid =  ";
// $result = mysqli_query($conn, $sql);
// if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     $row = mysqli_fetch_assoc($result); 
//     $ixed = $row['num_sum_all'];
// } else {
//      $ixed=0;
// }
$ixed=0;

//-----------------------------------------------------------------
echo "<h2>تقرير المنتج  </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>التاريخ</th>";
echo"</tr>";

                //get data from the stock
                  $sql = "SELECT itemid,num,entdate FROM stock";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 
                    $datez = $row["entdate"];
                    $numz = $row["num"];
                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];   
                    }

                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$numz. "</td>";
                echo "<td>" .$datez. "</td>";
                echo "</tr>";

                   }
                } else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------


mysqli_close($conn);
?>

</body>
</html>