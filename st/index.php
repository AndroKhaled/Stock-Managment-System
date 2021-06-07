
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<meta charset="utf-8">
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
</style>
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

mysqli_close($conn);
?>

<ul>
  <!-- <li><a href="default.asp">Home</a></li>
  <li><a href="news.asp">News</a></li>
  <li><a href="contact.asp">Contact</a></li>
  <li><a href="about.asp">About</a></li> -->



</ul>
<br><br>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

<li class="nav-item"><a class="nav-link" href="entcat.php">ادخال انواع</a></li>
<li class="nav-item"><a class="nav-link" href="entitems.php">ادخال اصناف</a></li>
<li class="nav-item"><a class="nav-link" href="entunits.php">ادخال وحدات</a></li>
<li class="nav-item"><a class="nav-link" href="b4res.php?catcode=">ادخال موارد</a></li>
<li class="nav-item"><a class="nav-link" href="b4stock.php?catcode=">تسجيل مخزونات</a></li>
<!-- <a href="stock.php">تسجيل مخزونات</a> -->
<li class="nav-item"><a class="nav-link" href="b4out.php?catcode=">تسجيل مصروفات</a></li>
<li class="nav-item"><a class="nav-link" href="realtime.php">تقرير فعلي للمخزن</a></li>
<li class="nav-item"><a class="nav-link" href="stockdetails.php">الانتاج الكلي</a></li>
<li class="nav-item"><a class="nav-link" href="outdetails.php">المنصرف الكلي</a></li>
<li class="nav-item"><a class="nav-link" href="proddetails.php"> تقرير الانتاج بالتفصيل</a></li>
<li class="nav-item"><a class="nav-link" href="outrepdetails.php">تقرير المنصرف يالتفصيل</a></li>
<li class="nav-item"><a class="nav-link" href="prodrep.php">تقرير الانتاج شامل</a></li>
<li class="nav-item"><a class="nav-link" href="outrep.php">تقرير المنصرف شامل</a></li>


    </ul>
  </div>
</nav>


</body>
</html>