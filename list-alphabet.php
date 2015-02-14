<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
<?php
$query = isset($_GET['w']) ? trim($_GET['w']) : '';

// 必須分列字母，因為有些老師主張與英文不同的排列
$ord = array('a', 'c', 'd', 'f', 'h', 'i', 'k', 'l', 'm', 'n', 'ng', 'o', 'p', "'", 'r', 's', 't', 'w', 'y');
foreach($ord as $o) {
  $b = ($o === $q) ? 'alpha-chosen' : '';
  print "<a href=\"index.php?query=__$o\" class=\"$b\">".strtoupper($o)."</a>&nbsp;&nbsp;\n";
}
?>
    </div>
  </div>
</div>
