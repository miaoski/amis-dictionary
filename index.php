<?php
require_once 'config.php';
if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  die();
}
?>
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

<?php 
$oauth2Service = new Google_Service_Oauth2($client);
$userinfo = $oauth2Service->userinfo;
echo "Userinfo = ";
$avatar = $userinfo->get()['picture'];
$given_name = $userinfo->get()['given_name'];

include('header.php');
if(isset($_GET['query'])) {
  $query = trim($_GET['query']);
  $q = substr($query, 2);
} else {
  $query = '';
  $q     = '';
}
include('list-alphabet.php');
?>


<?php
// $path = "http://localhost:8888/";
$path = "word.php";
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
      $ret[] = "<a href=\"$path?w=$row[0]\">".str_replace('g', 'ng', $row[0])."</a>";
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
