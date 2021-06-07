
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
$sb="اختيار";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

$theunitz[]="";
$thenamez[]="";




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



//////////-------------------------------------------------------





$ou=$on="";
//////////////////--------------------------------------------------------------------------------------------------
if(isset($_GET["submit"])){

  $sb="رجوع";

  $ncodey = $scodey = 0;
  $sname = $sunit = "";
  $qname = $qunit = "";
  $qdname = $qdunit = "";

  //  echo $_GET['itemname'];
//itemname unitname outdate

  if (  empty($_GET["itemname"])  && empty($_GET["unitn"]) ) {
    $sqle = "SELECT * FROM stockout ";
    $sb="اختيار";
  }
  else{
    
    if(!empty($_GET["itemname"])){
      $sname = $_GET['itemname'];
      $sqlcc = "SELECT * FROM items WHERE itemname = '$sname' ";
      $resultcc = mysqli_query($conn, $sqlcc);
      if (mysqli_num_rows($resultcc) > 0) {
      $rowcc = mysqli_fetch_assoc($resultcc); 
      $scodey = $rowcc['itemid'];
      } else {
       $scodey=0;
      }
      //$scodey
      $qname = " WHERE itemid = ". $scodey;
      $qdname = " AND itemid = " . $scodey;
    }
    if(!empty($_GET["unitn"])){
      $sunit = $_GET['unitn'];
      // echo $_GET["unitn"];
      $sqlccs = "SELECT * FROM units WHERE unitname = '$sunit' ";

     // echo $sqlccs;

      $resultccs = mysqli_query($conn, $sqlccs);
      if (mysqli_num_rows($resultccs) > 0) {
      $rowccs = mysqli_fetch_assoc($resultccs); 
      $ncodey = $rowccs['unitcode'];
      } else {
       $ncodey=0;
      }
      //$ncodey
      //$sunit = $ncodey;
      if($sname==""){
        $qunit = " WHERE unitcode = ".$ncodey;
        $qdunit = " AND unitcode = ". $ncodey;
      }else{
        $qunit = " AND unitcode = ". $ncodey;
        $qdunit = " AND unitcode = ". $ncodey;
      }
    }
    $sqle ="SELECT * FROM stockout"." ".$qname." ".$qunit;
  }






//-----------------------------------------------------------------
echo "<h2>تقرير ما تم صرفه سابقا </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
$sql = $sqle;

                //get data from the stock
                 $sql = "SELECT * FROM stockout WHERE NOT outdate = '$today' "." ".$qdname." ".$qdunit;
                 //echo  $sql;
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 

                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
              
                // if($ou != $rowzs["unitname"]){
                //   $theunitz[] = $rowzs["unitname"];
                //   $ou = $rowzs["unitname"];
                //   }
              
              }
                
                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            
                // if($on!=$rowzs["unitname"]){
                //   $thenamez[] = $rowz["itemname"];
                //   $on = $rowzs["unitname"];
                // }

                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname  AND  NOT outdate = '$today' ";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td>".$theunit."</td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                } else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------


//-----------------------------------------------------------------
echo "<h2>تقرير ما تم صرفه اليوم </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
                //get data from the stock
                  $sql = "SELECT itemid,unitcode FROM stockout WHERE outdate = '$today'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 
                    
                    
                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
              
                // if($ou!=$rowzs["unitname"]){
                //   $theunitz[] = $rowzs["unitname"];
                //   $ou = $rowzs["unitname"];
                //   }
              
              
              }

                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            

                // if($on!=$rowzs["unitname"]){
                //   $thenamez[] = $rowz["itemname"];
                //   $on = $rowzs["unitname"];
                // }


                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname AND outdate = '$today' ";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td>".$theunit."</td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                  }else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------

//-----------------------------------------------------------------
echo "<h2>تقرير الاجمالي المنصرف  </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
$sql = $sqle;
                //get data from the stock
                 //  $sql = "SELECT itemid,unitcode FROM stockout";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 

                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
              
                if($ou!=$rowzs["unitname"]){
                  $theunitz[] = $rowzs["unitname"];
                  $ou = $rowzs["unitname"];
                  }
              
              }
            

                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            


                if($on!=$rowzs["unitname"]){
                  $thenamez[] = $rowz["itemname"];
                  $on = $rowzs["unitname"];
                }



                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td>".$theunit."</td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                } else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------

                  
}else {
  


//-----------------------------------------------------------------
echo "<h2>تقرير ما تم صرفه سابقا </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
                //get data from the stock
                  $sql = "SELECT itemid,unitcode FROM stockout WHERE NOT outdate = '$today'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 


                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
                
                // if($ou!=$rowzs["unitname"]){
                //   $theunitz[] = $rowzs["unitname"];
                //   $ou = $rowzs["unitname"];
                //   }
    
              }


                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            
                // if($on!=$rowzs["unitname"]){
                //   $thenamez[] = $rowz["itemname"];
                //   $on = $rowzs["unitname"];
                // }


                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname  AND  NOT outdate = '$today' ";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td>".$theunit."</td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                  }else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------


//-----------------------------------------------------------------
echo "<h2>تقرير ما تم صرفه اليوم </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
                //get data from the stock
                  $sql = "SELECT itemid,unitcode FROM stockout WHERE outdate = '$today'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 
                    
                    
                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
              
                // if($ou!=$rowzs["unitname"]){
                //   $theunitz[] = $rowzs["unitname"];
                //   $ou = $rowzs["unitname"];
                //   }
              
              

              }

                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            

                // if($on!=$rowzs["unitname"]){
                //   $thenamez[] = $rowz["itemname"];
                //   $on = $rowzs["unitname"];
                // }


                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname AND outdate = '$today' ";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td>".$theunit."</td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                  }
                else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------

//-----------------------------------------------------------------
echo "<h2>تقرير الاجمالي المنصرف  </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"</tr>";

$oldy="";
                //get data from the stock
                  $sql = "SELECT itemid,unitcode FROM stockout";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                 

                    //get the name of the selected unit
                $unitname = $row["unitcode"];
                $theunit="";
                 $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                    $resultzs = mysqli_query($conn, $sqlzs);
                    if (mysqli_num_rows($resultzs) > 0) {
                  $rowzs = mysqli_fetch_assoc($resultzs);
                $theunit = $rowzs["unitname"];
              
                if($ou!=$rowzs["unitname"]){
                  $theunitz[] = $rowzs["unitname"];
                  $ou = $rowzs["unitname"];
                  }
              
              

              }

                   
                //get the name of the selected item id
                $idname = $row["itemid"];
                $thename="";
                 $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                    $resultz = mysqli_query($conn, $sqlz);
                    if (mysqli_num_rows($resultz) > 0) {
                  $rowz = mysqli_fetch_assoc($resultz);
                $thename = $rowz["itemname"];
            
                if($on!=$rowzs["unitname"]){
                  $thenamez[] = $rowz["itemname"];
                  $on = $rowzs["unitname"];
                }


                //sum the rest of the same item
                $sqlss = "SELECT SUM(num) AS num_sum FROM stockout WHERE itemid = $idname";
                $resultss = mysqli_query($conn, $sqlss);
                if (mysqli_num_rows($resultss) > 0) {
                    $rowss = mysqli_fetch_assoc($resultss); 
                    $som = $rowss['num_sum'];
                    }      
                    }
                //compare to dont repeat the rowzz---
                if($row["itemid"] != $oldy){
                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$som. "</td>";
                echo "<td></td>";
                echo "</tr>";
                    }
                $oldy = $idname;

                   }
                  }
                else {
                   //echo "0 results";
                    }
echo "</table>";
//-----------------------------------------------------------







}











mysqli_close($conn);
?>

<!-- <h2 style="text-align:center" >تقرير المصروفات </h2>

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
</table> -->

<form action="outrepdetails.php" method="get">
<label>الصنف :</label>
<select id=itemname name=itemname>
<?php
foreach($thenamez as $row) 
{
  echo "<option value=".$row.">$row</option>";
}
?>
</select>
  
<label>الوحدة :</label>
<select id=unitn name=unitn>
<?php
foreach($theunitz as $row)
 {
   echo "<option value= '".$row."' >$row</option>";
 } 
 ?>
</select>
 
<input type=submit value=<?php echo $sb ?> name = "submit" >
</form>



</body>
</html>