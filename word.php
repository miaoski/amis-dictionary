<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>阿美語萌典 - 單字</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style type="text/css">
body {
  padding-top: 50px;
}
.starter-template {
  padding: 40px 15px;
  text-align: center;
}
.alpha-chosen {
  background-color: #fd3;
  color: black;
  font-weight: bolder;
  padding-left: 1ex;
  padding-right: 1ex;
}
</style>
<script language="JavaScript">
</script>
</head>
<body>

<?php 
$q = '';
include('header.php');
include('list-alphabet.php');
?>

<!-- Sidebar -->
     <div id="sidebar-wrapper">
         <ul class="sidebar-nav">
             <li class="sidebar-brand">
                 <a href="#">
                     Start Bootstrap
                 </a>
             </li>
             <li>
                 <a href="#">Dashboard</a>
             </li>
             <li>
                 <a href="#">Shortcuts</a>
             </li>
             <li>
                 <a href="#">Overview</a>
             </li>
             <li>
                 <a href="#">Events</a>
             </li>
             <li>
                 <a href="#">About</a>
             </li>
             <li>
                 <a href="#">Services</a>
             </li>
             <li>
                 <a href="#">Contact</a>
             </li>
         </ul>
     </div>
     <!-- /#sidebar-wrapper -->

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
<?php
if(empty($query)) {
  die();
}

$pdo = new PDO("sqlite:dict-amis.sq3");

$sql = "SELECT * FROM amis WHERE title=:q";
$st = $pdo->prepare($sql);
$st->execute(array(':q' => $query));
$result = $st->setFetchMode(PDO::FETCH_NUM);
while($row = $st->fetch()) {
  print_r($row);
}
?>
    </div>
  </div>
</div>
</body>
</html>
