
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


$code = $id = $num = $unitcode = 0;
$date=0;
$name ="";
$codeErr = $idErr = $numErr = $dateErr = $unitErr = "";
$done= "";


//get the selected cat to specify the names list------
// $scode='<p id="selectedcat"></p>';

$thecode = $_SESSION["sss2"];
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

    // echo '<a href=stock.php/>Reset and start again</a>';


    //drop list select the unit name--------
$rowsetiunit[]="";
$sql = "SELECT * FROM units ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  $rowsetiunit[]=$row["unitname"];  
}
}



//drop list select the item name--------
$rowseti[]="";
$sql = "SELECT * FROM items WHERE itemcode = '$scodey' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  $rowseti[]=$row["itemname"];  
}
}


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
  // if (empty($_POST["catcode"])) {
  //   $codeErr = "*";
  // }
  // else if((!is_numeric($_POST["catcode"]))){
  //   $codeErr = "ادخل قيم صحيحه";
  // } 
  //  else {
  //           $sql = "SELECT itemcode FROM items ";
  //           $result = mysqli_query($conn, $sql);
            
  //           if(!$result || mysqli_num_rows($result) == 0)
  //             {$codeErr = "كود ليس موجود";}
  //           else{
  //               while($row = mysqli_fetch_assoc($result)) {
  //                   if($_POST["catcode"] == $row["itemcode"]){
  //                     $codeErr="";
  //                     break;
  //                 }
  //                 else{
  //                     $codeErr = "كود ليس موجود";}
  //                 }
  //           }
    
  //           if($codeErr==""){
  //           $code = $_POST["catcode"];}
  //         }

 ///////////////////////////////////////////////////

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


    // if (empty($_POST["itemid"])) {
    //     $idErr = "*";
    //   }
    //   else if((!is_numeric($_POST["itemid"]))){
    //     $idErr = "ادخل قيم صحيحه";
    //   } 
    //    else {
    //             $sql = "SELECT itemid FROM items ";
    //             $result = mysqli_query($conn, $sql);
                
    //             if(!$result || mysqli_num_rows($result) == 0)
    //               {$idErr = "رقم ليس موجود";}
    //             else{
    //                 while($row = mysqli_fetch_assoc($result)) {
    //                     if($_POST["itemid"] == $row["itemid"]){
    //                       $idErr="";
    //                       break;
    //                   }
    //                   else{
    //                       $idErr = "رقم ليس موجود";}
    //                   }
    //             }
        
    //             if($idErr==""){
    //             $id = $_POST["itemid"];}
    //           }
              

///////////////////////////////////////////////////

  if (empty($_POST["num"])) {
    $numErr = "حقل فارغ";
  } else {
    $num = $_POST["num"];
  }

///////////////////////////////////////////////////


if (empty($_POST["outdate"])) {
    $dateErr = "حقل فارغ";
  }
  else {
    $sql = "SELECT outdate FROM stockout ";
    $result = mysqli_query($conn, $sql);
    
    if(!$result || mysqli_num_rows($result) == 0)
      {$dateErr == "";}
      else{
        while($row = mysqli_fetch_assoc($result)) {

            if($_POST["outdate"] == $row["outdate"]){
                $dateErr = "تم الصرف بهذا التاريخ من قبل ";
                break;}
          else{
            }
          }
    }

    if($dateErr==""){
        $date = $_POST["outdate"];}
  }
///////////////////////////////////////////////////


if (empty($_POST["unitcode"])) {
    $unitErr = "حقل فارغ";
  }
   else {

    $uc=0;
    $unitzid = $_POST["unitcode"];
    $sql = "SELECT * FROM units WHERE unitname = '$unitzid' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); 
    $uc = $row['unitcode'];
    } else {
    // $codyy=0;
    }
    
            $sql = "SELECT unitcode FROM units ";
            $result = mysqli_query($conn, $sql);
            if(!$result || mysqli_num_rows($result) == 0)
              {$unitErr = "رقم ليس موجود";}
            else{
                while($row = mysqli_fetch_assoc($result)) {
                    if($uc == $row["unitcode"]){
                      $unitErr="";
                      break;
                  }
                  else{
                      $unitErr = "رقم ليس موجود";}
                  }
            }
    
            if($unitErr==""){
            $unitcode = $uc;}

          }

    if($codeErr == ""  && $idErr == ""  && $numErr == ""  && $dateErr == "" ){

      $old=0;
      $sql = "SELECT catcode,itemid FROM rtstock WHERE catcode = $code AND itemid = $id";
                $result = mysqli_query($conn, $sql);
                
                //lw l2aha hy3ml get lel number l adim w y3mlo sum w update --------
                if (mysqli_num_rows($result) > 0) {
                  
                  //get lel rakam l adiim----------
                  $sql = "SELECT num FROM rtstock WHERE catcode = $code AND itemid = $id ";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      $row = mysqli_fetch_assoc($result); 
                      $old = $row['num'];
                  }

                  //sum l rakm l adim bl gdidd-----------
                  $total = $old - $num;
                  if($total < 0){
                    $done="العدد في المخزن لا يكفي";
                  }
                  else{

                       //update l number
                  $sql = "UPDATE rtstock SET num= $total WHERE catcode = $code AND itemid = $id";
                  if (mysqli_query($conn, $sql)) {
                    //echo "Record updated successfully";
                  }
                      //insert l data fil stockout report
                    $sql = "INSERT INTO stockout (catcode,itemid,num,outdate,unitcode) VALUES ($code,$id,$num,'$date',$unitcode)" ;
                    if (mysqli_query($conn, $sql)) {
                     $done="تم الادخال بنجاح";
                     }else {
                     //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                      }
                  }
                }else{
                  $done="لا يوجد بالمخزن";
                }
  
  } else {
        echo "";
    }
}

mysqli_close($conn);
?>

<form  action="out.php" method="post">

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

  <label>التاريخ : </label>
  <input type="date" id="outdate" name="outdate">
  <span class="error"><?php echo $dateErr;?></span><br><br>

  <!-- <label>كود الوحدة : </label>
  <input type="number" id="unitcode" name="unitcode">
 -->
<label>اسم الوحدة : </label>
    <select id="unitcode" name="unitcode" >
  <?php
    foreach($rowsetiunit as $row) {
        echo "<option value='".$row."'>$row</option>";}
  ?>
  </select>
  <span class="error"><?php echo $unitErr;?></span><br><br>
  

  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>