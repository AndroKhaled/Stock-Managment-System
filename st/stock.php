
<?php
session_start();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8">
</head>
<body>

<!-- <script>
function run() {
    document.getElementById("selectedcat").innerHTML = document.getElementById("catcode").value;
}
</script> -->

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
$numres=0;

//total l mwgod fil resources..
$totalzi="";

//drop list select the category name--------
// $rowset[]="";
// $sql = "SELECT * FROM catcode";
// $result = mysqli_query($conn, $sql);
// if (mysqli_num_rows($result) > 0) {
// while($row = mysqli_fetch_assoc($result)) {
//   $rowset[]=$row["catname"];  
// }
// }


//get the selected cat to specify the names list------
// $scode='<p id="selectedcat"></p>';

$thecode = $_SESSION["sss"];
$rowseti[]="";
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

     //get itemid from res 
$sql = "SELECT * FROM res WHERE catcode = $scodey";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($rowx = mysqli_fetch_assoc($result)) {
    $codf = $rowx["itemid"];
  
  
    //drop list select the item name--------
    $sql = "SELECT * FROM items WHERE itemcode = '$codf' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
      $rowseti[]=$row["itemname"];  
    }


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
    //               {
    //                 $idErr = "رقم ليس موجود";
    //               }
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


if (empty($_POST["entdate"])) {
    $dateErr = "حقل فارغ";
  }
  else {
    $sql = "SELECT entdate FROM stock ";
    $result = mysqli_query($conn, $sql);
    
    if(!$result || mysqli_num_rows($result) == 0)
      {$dateErr == "";}
      else{
        while($row = mysqli_fetch_assoc($result)) {

            if($_POST["entdate"] == $row["entdate"]){
                $dateErr = "تم التسجيل بهذا التاريخ من قبل ";
                break;}
          else{
            }
          }
    }

    if($dateErr==""){
        $date = $_POST["entdate"];}
  }


    if($codeErr == ""  && $idErr == ""  && $numErr == ""  && $dateErr == "" ){

      $thetotalz=0;

      //get num of itemid in res => numres
      //if numres >= num update l num ...
      //else echo la yogd yakfi aksa 3add fl mward = numres
    
      //get num of itemid in res => numres
    $sql = "SELECT * FROM res WHERE itemid = '$id' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
      $numres=$row["num"];  
    }


    if($numres >= $num){

                  //sub l rkm l adim wl gded
                  $thetotalz = $numres - $num;
                  //update l number
                  $sql = "UPDATE res SET num= $thetotalz WHERE catcode = $code AND itemid = $id";
                  if (mysqli_query($conn, $sql)) {
                    //echo "Record updated successfully"; 
                  }

                          //hydwr 3la l item lw mwgoda aw l2
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
                  $total = $old + $num;

                  //update l number
                  $sql = "UPDATE rtstock SET num= $total WHERE catcode = $code AND itemid = $id";
                  if (mysqli_query($conn, $sql)) {
                    //echo "Record updated successfully"; 
                  }
                       //insert l data fil stock report
                    $sql = "INSERT INTO stock (catcode,itemid,num,entdate) VALUES ($code,$id,$num,'$date')" ;
                    if (mysqli_query($conn, $sql)) {
                     $done="تم الادخال بنجاح";
                    }else {
                      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                     }
             
                }else{
                    //if ml2ash l idz wl code hy3ml w7da  gdidaa---------
                    //insert l values fl realtime stock--------
                  $sql = "INSERT INTO rtstock (catcode,itemid,num) VALUES ($code,$id,$num)" ;
                  if (mysqli_query($conn, $sql)) {
                  //$done="تم الادخال بنجاح";
                  }else{
                  echo "";
                  }
                         //insert l data fil stock report
                    $sql = "INSERT INTO stock (catcode,itemid,num,entdate) VALUES ($code,$id,$num,'$date')" ;
                    if (mysqli_query($conn, $sql)) {
                    $done="تم الادخال بنجاح";
                    }else {
                     //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
    }else{

      $numErr=" لا يوجد موارد تكفي,, اقصي عدد يساوي $numres";
    }
    }
    else {
        echo "";
    }
}

mysqli_close($conn);


?>

<form  action="stock.php" method="post">

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
  <span class="numb"><?php echo $totalzi;?></span>
  <span class="error"><?php echo $numErr;?></span><br><br>

  <label>التاريخ : </label>
  <input type="date" id="entdate" name="entdate">
  <span class="error"><?php echo $dateErr;?></span><br><br>
  
  <input type="submit">

</form>
<label> <?php echo $done;?> </label>

</body>
</html>