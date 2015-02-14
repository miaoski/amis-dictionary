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

function tong($s) {
  return str_replace('g', 'ng', $s);
}
function ton($s) {
  return str_replace('ng', 'g', $s);
}

$mydialect = 'm';	// 一個人一種方言

$pdo = new PDO("sqlite:dict-amis.sq3");

$query = isset($_GET['w']) ? trim($_GET['w']) : '';
$sql = "SELECT * FROM amis WHERE title=:q";
$st = $pdo->prepare($sql);
$st->execute(array(':q' => $query));
$result = $st->setFetchMode(PDO::FETCH_NUM);
$rows = $st->fetchAll();
?>

<div class="container">
  <div class="row" style="background-color:#FFF">
    <div class="col-md-3">
    北部阿美
    </div>
    <div class="col-md-9">
Lorem ipsum dolor sit amet, an sed scripta hendrerit efficiantur. Diceret laboramus id has, an habemus forensibus vim. Id quo nominavi accusamus voluptatibus. Eu semper evertitur eam. Velit facilis conclusionemque et sea, porro elitr repudiare vix id. Ea qui enim platonem adversarium.
    </div>
  </div>
  <div class="row" style="background-color:#DDD">
    <div class="col-md-3">
    中部阿美
    </div>
    <div class="col-md-9">
      <div class="row"><div class="col-md-12">
      <input class="col-md-12" type="text" value="<?=htmlentities(tong($query))?>" name="amis-m"/>
      </div></div>
      <div class="row"><div class="col-md-12">
<?php
foreach($rows as $r) {
  if(empty($r[1])) {
    echo "$r[2]<br/>$r[3]\n";
  }
}
?>
      </div></div>
<?php
foreach($rows as $r) {
  if(!empty($r[1])) {
      echo '<div class="row"><div class="col-md-12">';
      echo '<input class="col-md-12" type="text" value="'.htmlentities(tong($r[1])).'" name="ex-m-1"/>';
      echo '</div></div>';
      echo '<div class="row"><div class="col-md-12">';
      echo "$r[2]<br/>$r[3]";
      echo '</div></div>';
  }
}
?>
    </div>
  </div>
  <div class="row" style="background-color:#FFF">
    <div class="col-md-3">
    海岸阿美
    </div>
    <div class="col-md-9">
Lorem ipsum dolor sit amet, an sed scripta hendrerit efficiantur. Diceret laboramus id has, an habemus forensibus vim. Id quo nominavi accusamus voluptatibus. Eu semper evertitur eam. Velit facilis conclusionemque et sea, porro elitr repudiare vix id. Ea qui enim platonem adversarium.
    </div>
  </div>
  <div class="row" style="background-color:#DDD">
    <div class="col-md-3">
    馬蘭阿美
    </div>
    <div class="col-md-9">
Lorem ipsum dolor sit amet, an sed scripta hendrerit efficiantur. Diceret laboramus id has, an habemus forensibus vim. Id quo nominavi accusamus voluptatibus. Eu semper evertitur eam. Velit facilis conclusionemque et sea, porro elitr repudiare vix id. Ea qui enim platonem adversarium.
    </div>
  </div>
  <div class="row" style="background-color:#FFF">
    <div class="col-md-3">
    恆春阿美
    </div>
    <div class="col-md-9">
Lorem ipsum dolor sit amet, an sed scripta hendrerit efficiantur. Diceret laboramus id has, an habemus forensibus vim. Id quo nominavi accusamus voluptatibus. Eu semper evertitur eam. Velit facilis conclusionemque et sea, porro elitr repudiare vix id. Ea qui enim platonem adversarium.
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 col-md-offset-5">
      <button type="submit" class="btn btn-default">送出修改</button>
    </div>
  </div>
</div>
</body>
</html>
