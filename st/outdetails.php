
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
/////////////////////////////////////////////////////////
             
                //       //get data from the stock
                //   $sql = "SELECT * FROM stockout";
                //     $result = mysqli_query($conn, $sql);
                //     if (mysqli_num_rows($result) > 0) {
                //   while($row = mysqli_fetch_assoc($result)) {
                 

                //     //get the name of the selected unit
                // $unitname = $row["unitcode"];
                // //$theunit[]="";
                //  $sqlzs = "SELECT unitname FROM units WHERE unitcode = $unitname ";
                //     $resultzs = mysqli_query($conn, $sqlzs);
                //     if (mysqli_num_rows($resultzs) > 0) {
                //         $rowzs = mysqli_fetch_assoc($resultzs);
                //           $theunitz = $rowzs["unitname"];}

                   
                // //get the name of the selected item id
                // $idname = $row["itemid"];
                // //$thename[]="";
                //  $sqlz = "SELECT itemname FROM items WHERE itemid = $idname ";
                //     $resultz = mysqli_query($conn, $sqlz);
                //     if (mysqli_num_rows($resultz) > 0) {
                //        $rowz = mysqli_fetch_assoc($resultz);
                //         $thenamez = $rowz["itemname"];}

                //    }
                // } else {
                //    echo "0 results";
                //     }



//////////////////////////////////////////////////////////



// echo "<form action=outdetails.php method=get>";
// echo " <label>الصنف :</label>";
// echo " <select id=itemname name=itemname>";
// foreach($thenamez as $row) 
// {
//   echo "<option value=".$row.">$row</option>";
// }
// echo " </select>";
  
// echo " <label>الوحدة :</label>";
// echo " <select id=unitname name=unitname>";
// foreach($theunitz as $row)
//  {
//    echo "<option value=$row>$row</option>";
//  } 
// echo "</select>";

// echo "  <label>التاريخ : </label>";
// echo "  <input type=date id=outdate name=outdate> ";
 
// echo "  <input type=submit value=اختيار >";
// echo "</form>";

                    

/////////////////////////////////////////////////////////
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
$sqle="";
//////////////////--------------------------------------------------------------------------------------------------
if(isset($_GET["submit"])){

  $sb="رجوع";

  $ncodey = $scodey = 0;
  $sname = $sunit = $sdate = "";
  $qname = $qunit = $qdate = "";
  $ssdate=date("Y");
  //  echo $_GET['itemname'];
//itemname unitname outdate

  if (  empty($_GET["itemname"])  && empty($_GET["unitn"])  && empty($_GET["outdate"])  ) {
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
      $qname = "WHERE itemid = ". $scodey;
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
      }else{
        $qunit = " AND unitcode = ". $ncodey;
      }
    }
    if(!empty($_GET["outdate"])){
      $sdate = $_GET['outdate'];
      $ssdate="'$sdate'";
      if($sname=="" && $sunit=="" ){
      //  echo "'$sdate'";
        $qdate = " WHERE outdate = ". $ssdate;
      }else{
        $qdate = " AND outdate = " . $ssdate;
      }
    }
    $sqle ="SELECT * FROM stockout"." ".$qname." ".$qunit." ".$qdate;
  }

//-------------------------------------------------------------------------------------------
echo "<h2>تقرير الاجمالي المنصرف  </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"<th>التاريخ</th>";
echo"</tr>";

$oldy="";
$ou=$on="";
$sql = $sqle;
//echo $sql;
                //get data from the stock
                  //$sql = "SELECT itemid,unitcode,num,outdate FROM stockout";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {

                    $datez = $row["outdate"];
                    $numz = $row["num"];


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

                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$numz. "</td>";
                echo "<td>".$theunit."</td>";
                echo "<td>" .$datez. "</td>";
                echo "</tr>";

                   }
                } else {
                   //echo "0 results";
                    }
echo "</table>";
//-------------------------------------------------------------------------------------------------------------

}
else{

  $sb="اختيار";


//-------------------------------------------------------------------------------------------
echo "<h2>تقرير الاجمالي المنصرف  </h2>";
//Open the table and its first row
echo "<table>";

echo"<tr>";
echo"<th>الاسم</th>";
echo"<th>العدد</th>";
echo"<th>الوحدة</th>";
echo"<th>التاريخ</th>";
echo"</tr>";

$oldy="";
$ou=$on="";
$sql = $sqle;
echo $sql;
                //get data from the stock
                  $sql = "SELECT itemid,unitcode,num,outdate FROM stockout";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {

                    $datez = $row["outdate"];
                    $numz = $row["num"];


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

                //show the table
                echo "<tr>";
                echo "<td>". $thename ."</td>";
                echo "<td>" .$numz. "</td>";
                echo "<td>".$theunit."</td>";
                echo "<td>" .$datez. "</td>";
                echo "</tr>";

                   }
                } else {
                   //echo "0 results";
                    }
echo "</table>";
//-------------------------------------------------------------------------------------------------------------



  }

mysqli_close($conn);





?>
<br><br>
<form action="outdetails.php" method="get">
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

<label>التاريخ : </label>
<input type=date id=outdate name=outdate>
 
<input type=submit value=<?php echo $sb ?> name = "submit" >
</form>


</body>
</html>