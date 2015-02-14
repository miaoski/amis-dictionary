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
    <form class="navbar-form" role="search" method="get">
      <div class="input-group col-md-10">
        <input name="query" type="text" class="form-control" placeholder="請輸入阿美語、英文或漢文，再按 [Enter]"/>
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <span class="sr-only">Search</span>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>

<?php
if(isset($_GET['query'])) {
  $query = trim($_GET['query']);
  $q = substr($query, 2);
} else {
  $query = '';
  $q     = '';
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
<?php
$ord = array('a', 'c', 'd', 'f', 'h', 'i', 'k', 'l', 'm', 'n', 'ng', 'o', 'p', "'", 'r', 's', 't', 'w', 'y');
foreach($ord as $o) {
  $b = ($o === $q) ? 'alpha-chosen' : '';
  print "<a href=\"?query=__$o\" class=\"$b\">".strtoupper($o)."</a>&nbsp;&nbsp;\n";
}
?>
    </div>
  </div>
</div>
<?php
// $path = "http://localhost:8888/";
$path = "https://amis.moedict.tw/word.php";
if(!empty($query)) {
  $query = str_replace('ng', 'g', $query);
  $pdo = new PDO("sqlite:dict-amis.sq3");

  function query_dict($sql, $head = false) {
    global $query, $path, $pdo;
    $st = $pdo->prepare($sql);
    if($head === true) {
      $q = substr($query, 2, 1);
      $st->execute(array(':q' => "$q%"));
    } else {
      $st->execute(array(':q' => "%$query%"));
    }
    $result = $st->setFetchMode(PDO::FETCH_NUM);
    $ret = array();
    while($row = $st->fetch()) {
      $ret[] = "<a href=\"$path?$row[0]\">".str_replace('g', 'ng', $row[0])."</a>";
    }
    return $ret;
  }
  if(substr($query, 0, 2) == '__') {
    $ret = query_dict("SELECT DISTINCT title FROM amis WHERE title LIKE :q ORDER BY title", true);
  } else {
    $ret1 = query_dict("SELECT DISTINCT title FROM amis WHERE title LIKE :q ORDER BY title");
    $ret2 = query_dict("SELECT DISTINCT title FROM amis WHERE example LIKE :q OR en LIKE :q OR cmn LIKE :q LIMIT 100");
    $ret = array_merge($ret1, $ret2);
  }
  $percol = ceil(count($ret) / 3);
?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
<?php for($i = 0; $i < $percol; $i++) { echo $ret[$i]."<br />\n"; } ?>
    </div>
    <div class="col-md-3">
<?php for($i = $percol; $i < $percol*2; $i++) { echo $ret[$i]."<br />\n"; } ?>
    </div>
    <div class="col-md-3">
<?php for($i = $percol*2; $i < count($ret); $i++) { echo $ret[$i]."<br />\n"; } ?>
    </div>
  </div>
</div>
<?php
}
?>
</body>
</html>
