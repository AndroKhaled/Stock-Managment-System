
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


$code = $id = 0;
$name ="";
$codeErr = $idErr = $nameErr = "";
$done= "";

//drop list select the category name--------
$rowset[]="";
$sql = "SELECT * FROM catcode";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  $rowset[]=$row["catname"];  
}
}
////////////////////////////////////////////////

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (empty($_POST["itemcode"])) {
        $codeErr = "حقل فارغ";
      } else {
        $itemzcode = $_POST["itemcode"];
        $sql = "SELECT * FROM catcode WHERE catname = '$itemzcode' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); 
        $code = $row['catcode'];
        } else {
        // $codyy=0;
        }
    }

    // if (empty($_POST["itemcode"])) {
    //     $codeErr = "*";
    //   } else {
    //     $sql = "SELECT catcode FROM catcode ";
    //     $result = mysqli_query($conn, $sql);
        
    //     if(!$result || mysqli_num_rows($result) == 0)
    //       {$codeErr = "كود ليس موجود";}
    //     else{
    //         while($row = mysqli_fetch_assoc($result)) {
    //             if($_POST["itemcode"] == $row["catcode"]){
    //               $codeErr="";
    //               break;
    //           }
    //           else{
    //               $codeErr = "كود ليس موجود";}
    //           }
    //     }

    //     if($codeErr==""){
    //     $code = $_POST["itemcode"];}
    //   }

    
//////////////////////////////////////////////////

  if (empty($_POST["itemid"])) {
    $idErr = "حقل فارغ";
  }
  else if((!is_numeric($_POST["itemid"]))){
    $idErr = "ادخل قيم صحيحه";
  } 
  else{
    //compare the id with the otherz
    $sql = "SELECT itemid FROM items";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($_POST["itemid"] == $row["itemid"]){
        $idErr = "قيمة مكررة";
        break;
    }else{
      $idErr = "";
      }
  }
    }}
    if($idErr==""){
        $id = $_POST["itemid"];}

    //////////////////////////////////////////////////

  if (empty($_POST["itemname"])) {
    $nameErr = "حقل فارغ";
  } else {
    $name = $_POST["itemname"];
  }


    if($codeErr == ""  && $nameErr == ""  && $idErr == "" ){
    $sql = "INSERT INTO items (itemcode,itemid,itemname) VALUES ($code,$id,'$name')" ;
    if (mysqli_query($conn, $sql)) {
        $done="تم الادخال بنجاح";
    }else {
       //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }   
}
}
mysqli_close($conn);

?>

<form  action="entitems.php" method="post">

  <label> النوع : </label>
   <select id="itemcode" name="itemcode">
  <?php
    foreach($rowset as $row) {
        echo "<option value=".$row.">$row</option>";}
  ?>
  </select>
  <!-- <input type="number" id="itemcode" name="itemcode"> -->
  <span class="error"><?php echo $codeErr;?></span><br><br>

  <label>الكود : </label>
  <input type="number" id="itemid" name="itemid">
  <span class="error"><?php echo $idErr;?></span><br><br>
  
  <label>الاسم : </label>
  <input type="text" id="itemname" name="itemname">
  <span class="error"><?php echo $nameErr;?></span><br><br>
  
  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>