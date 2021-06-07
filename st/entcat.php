
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
    
  if (empty($_POST["catcode"])) {
    $codeErr = "حقل فارغ";
  }
  else if((!is_numeric($_POST["catcode"]))){
    $codeErr = "ادخل قيم صحيحه";
  } 
  else{
    //compare the id with the otherz
    $sql = "SELECT catcode FROM catcode";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($_POST["catcode"] == $row["catcode"]){
        $codeErr = "قيمة مكررة";
    }
    }}
    if($codeErr==""){
        $code = $_POST["catcode"];}}

  if (empty($_POST["catname"])) {
    $nameErr = "حقل فارغ";
  } else {
    $name = $_POST["catname"];
  }


    if($codeErr == ""  && $nameErr == "" ){
    $sql = "INSERT INTO catcode (catcode,catname) VALUES ($code,'$name')" ;
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

<form  action="entcat.php" method="post">

  <label>الكود : </label>
  <input type="number" id="catcode" name="catcode">
  <span class="error"><?php echo $codeErr;?></span><br><br>

  <label>الاسم : </label>
  <input type="text" id="catname" name="catname">
  <span class="error"><?php echo $nameErr;?></span><br><br>
  
  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>