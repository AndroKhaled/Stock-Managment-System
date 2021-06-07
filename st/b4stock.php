<?php
session_start();
try {
  $_SESSION["sss"] =  $_GET["catcode"];
} catch (Exception $e) {
  throw $e;
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8">
<script>
function run() {
    document.getElementById("selectedcat").innerHTML = document.getElementById("catcode").value;
   // $_SESSION["sss"] = '<p id="selectedcat"></p>';

}
</script>
</head>
<body>
<?php
 
$servername = "localhost";
$username = "";
$password = "";
$dbname = "st";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");



$code = $id = $num = 0;
$date=0;
$codeErr = $idErr = $numErr = $dateErr = "";
$done= "";
$codf = 0;
$rowset[]="";


//get catcode from res 
$sql = "SELECT * FROM res";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($rowx = mysqli_fetch_assoc($result)) {
    $codf = $rowx["catcode"];
    
    
    $sql = "SELECT * FROM catcode WHERE catcode = $codf";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
        $rowset[]=$row["catname"];
    }

}   
}


//  $scode ='<p id="selectedcat"></p>';
//  echo $scode;

//get the selected cat to specify the names list------
// $scode='<p id="selectedcat"></p>';

$scodey="";
    // $sql = "SELECT * FROM catcode WHERE catname = '$scode' ";
    // $result = mysqli_query($conn, $sql);
    // if (mysqli_num_rows($result) > 0) {
    // $row = mysqli_fetch_assoc($result); 
    // $scodey = $row['catcode'];
    // } else {
    //  $scodey=0;
    // }

//  $_SESSION["selectcode"] = '<p id="selectedcat"></p>';

//  $_SESSION["aa"] ="aaabc";
//  echo $_SESSION["selectcode"];


?>


<form action="b4stock.php" method="get">
<label>النوع :</label>
  <select id="catcode" name="catcode" onChange="run()">
  <?php
     foreach($rowset as $row) {
         echo "<option value=".$row.">$row</option>";}
  ?>
  </select>
  <!-- <input type="number" id="catcode" name="catcode"> -->
  <span class="error"><?php echo $codeErr;?></span>
  
  <!-- <button onclick="location.href='stock.php'">تأكيد</button> -->
  <a href='stock.php'> تأكيد <a/>

  <input type="submit" value="اختيار" >
  <br><br>

    <label>العنصر : </label>

<select id="itemid" name="itemid" >
<?php
  foreach($rowseti as $row) {
      echo "<option value=".$row.">$row</option>";}
      
?>
</select>

<!-- <input type="number" id="itemid" name="itemid"> -->
<span class="error"><?php echo $idErr;?></span><br><br>

<label>العدد : </label>
<input type="number" id="num" name="num">
<span class="error"><?php echo $numErr;?></span><br><br>

<label>التاريخ : </label>
<input type="date" id="entdate" name="entdate">
<span class="error"><?php echo $dateErr;?></span><br><br>

</form>

</body>
</html>