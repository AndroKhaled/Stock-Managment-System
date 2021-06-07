
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8">
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


$code = 0;
$name ="";
$codeErr = $nameErr = "";
$done= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  if (empty($_POST["unitcode"])) {
    $codeErr = "حقل فارغ";
  }
  else if((!is_numeric($_POST["unitcode"]))){
    $codeErr = "ادخل قيم صحيحه";
  } 
  else{
    //compare the id with the otherz
    $sql = "SELECT unitcode FROM units";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($_POST["unitcode"] == $row["unitcode"]){
        $codeErr = "قيمة مكررة";
    }
    }}
    if($codeErr==""){
        $code = $_POST["unitcode"];}}

    ///////////////////////////////////////////

  if (empty($_POST["unitname"])) {
    $nameErr = "حقل فارغ";
  } else {
    $name = $_POST["unitname"];
  }


    if($codeErr == ""  && $nameErr == "" ){
    $sql = "INSERT INTO units (unitcode,unitname) VALUES ($code,'$name')" ;
    if (mysqli_query($conn, $sql)) {
        $done="تم الادخال بنجاح";
    }else {
       //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    }else {
        echo "";
    }
}

mysqli_close($conn);
?>

<form  action="entunits.php" method="post">

  <label>الكود : </label>
  <input type="number" id="unitcode" name="unitcode">
  <span class="error"><?php echo $codeErr;?></span><br><br>

  <label>الاسم : </label>
  <input type="text" id="unitname" name="unitname">
  <span class="error"><?php echo $nameErr;?></span><br><br>
  
  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>