
<?php
session_start();
?>

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


$code = $id = $num = 0;
$date=0;
$codeErr = $idErr = $numErr = "";
$done= "";



$thecode = $_SESSION["sss"];
$scodey="";
    $sql = "SELECT * FROM catcode WHERE catname = '$thecode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); 
    $scodey = $row['catcode'];
    } else {
     $scodey=0;
    }
     //echo $scodey;

//drop list select the item name--------
$rowseti[]="";
$sql = "SELECT * FROM items WHERE itemcode = '$scodey' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  $rowseti[]=$row["itemname"];  
}
}

//////////------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["catcode"])) {
    $codeErr = "حقل فارغ";
  } else {
    $itemzcode = $_POST["catcode"];
    $sql = "SELECT * FROM catcode WHERE catname = '$itemzcode' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); 
    $code = $row['catcode'];
    } else {
    // $codyy=0;
    }
}


 if (empty($_POST["itemid"])) {
  $idErr = "حقل فارغ";
} else {
  $itemzid = $_POST["itemid"];
  $sql = "SELECT * FROM items WHERE itemname = '$itemzid' ";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result); 
  $id = $row['itemid'];
  } else {
  // $codyy=0;
  }
}
    

  if (empty($_POST["num"])) {
    $numErr = "حقل فارغ";
  } else {
    $num = $_POST["num"];
  }

///////////////////////////////////////////////////


    if($codeErr == ""  && $idErr == ""  && $numErr == ""  ){

   //hydwr 3la l item lw mwgoda aw l2
   $old=0;
   $sql = "SELECT catcode,itemid FROM res WHERE catcode = $code AND itemid = $id";
             $result = mysqli_query($conn, $sql);
             //lw l2aha hy3ml get lel number l adim w y3mlo sum w update --------
             if (mysqli_num_rows($result) > 0) {
               
               //get lel rakam l adiim----------
               $sql = "SELECT num FROM res WHERE catcode = $code AND itemid = $id ";
               $result = mysqli_query($conn, $sql);
               if (mysqli_num_rows($result) > 0) {
                   // output data of each row
                   $row = mysqli_fetch_assoc($result); 
                   $old = $row['num'];
               }

               //sum l rakm l adim bl gdidd-----------
               $total = $old + $num;

               //update l number
               $sql = "UPDATE res SET num= $total WHERE catcode = $code AND itemid = $id";
               if (mysqli_query($conn, $sql)) {
                 //echo "Record updated successfully"; 
               }
                    //insert l data fil stock report
                 $sql = "INSERT INTO stock (catcode,itemid,num) VALUES ($code,$id,$num)" ;
                 if (mysqli_query($conn, $sql)) {
                  $done="تم الادخال بنجاح";
                 }else {
                   //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                  }
          
             }else{
                 //if ml2ash l idz wl code hy3ml w7da  gdidaa---------
                 //insert l values fl realtime stock--------
               $sql = "INSERT INTO res (catcode,itemid,num) VALUES ($code,$id,$num)" ;
               if (mysqli_query($conn, $sql)) {
               //$done="تم الادخال بنجاح";
               }else{
               echo "";
               }
                      //insert l data fil stock report
                 $sql = "INSERT INTO stock (catcode,itemid,num) VALUES ($code,$id,$num)" ;
                 if (mysqli_query($conn, $sql)) {
                 $done="تم الادخال بنجاح";
                 }else {
                  //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                 }
             }

                }
    else {
        echo "";
    }
}

mysqli_close($conn);


?>

<form  action="entres.php" method="post">

  <label>النوع : </label>
  <select id="catcode" name="catcode">
  <!-- <?php
    foreach($rowset as $row) {
        echo "<option value=".$row.">$row</option>";}
  ?> -->
   
   <?php
   echo "<option value=".$thecode.">$thecode</option>";
   ?>
  </select>
  <!-- <input type="number" id="catcode" name="catcode"> -->
  <span class="error"><?php echo $codeErr;?></span><br><br>


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

  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>