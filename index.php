<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>阿美語萌典 - 查詢</title>
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
</style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">阿美語萌典</a>
    </div>
    <form class="navbar-form" role="search" method="get" action="#">
      <div class="input-group col-md-10">
        <input type="text" class="form-control" placeholder="請輸入阿美語、英文或漢文，再按 [Enter]"/>
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <span class="sr-only">Search</span>
            <span class="glyphicon glyphicon-search"aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>


<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
<?php
$ord = array('a', 'c', 'd', 'f', 'h', 'i', 'k', 'l', 'm', 'n', 'ng', 'o', 'p', "'", 'r', 's', 't', 'w', 'y');
foreach($ord as $o) {
  print "<a href=\"?query=__$o\">".strtoupper($o)."</a>&nbsp;&nbsp;\n";
}
?>
    </div>
  </div>
</div>
<?php
// $path = explode('/', $_SERVER['PHP_SELF']);
// array_pop($path);
// $path = implode('/', $path);
// $path = "http://localhost:8888/";
$path = "https://amis.moedict.tw/";
if(isset($_GET['query']) && !empty($_GET['query'])) {
  $query = $_GET['query'];
  $pdo = new PDO("sqlite:dict-amis.sq3");

?>
<div class="container">
  <table class="table">
    <thead>
      <tr><th>單詞</th><th>例句</th><th>英文解釋</th><th>漢文解釋</th></tr>
    </thead>
    <tbody>
<?php
  function query_and_show($sql, $head = false) {
    global $query, $path, $pdo;
    $st = $pdo->prepare($sql);
    if($head === true) {
      if($query == '__n') {
        $st = $pdo->prepare("SELECT * FROM amis WHERE title LIKE 'n%' AND title NOT LIKE 'ng%' ORDER BY title");
        $st->execute();
      } elseif($query == '__ng') {
        $st->execute(array(':q' => "ng%"));
      } else {
        $q = substr($query, 2, 1);
        $st->execute(array(':q' => "$q%"));
      }
    } else {
      $st->execute(array(':q' => "%$query%"));
    }
    $result = $st->setFetchMode(PDO::FETCH_NUM);
    while($row = $st->fetch()) {
      $amis = "<a href=\"$path#;$row[0]\">$row[0]</a>";
      print "<tr><td>$amis</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";
    }
  }
  if(substr($query, 0, 2) == '__') {
    query_and_show("SELECT * FROM amis WHERE title LIKE :q ORDER BY title", true);
  } else {
    query_and_show("SELECT * FROM amis WHERE title LIKE :q ORDER BY title");
    query_and_show("SELECT * FROM amis WHERE example LIKE :q OR en LIKE :q OR cmn LIKE :q LIMIT 100");
  }
?>
    </tbody>
  </table>
</div>
<?php
}
?>
</body>
</html>
