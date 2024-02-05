<?php
require __DIR__ . '/com-parts-m/db_connect.php';
require __DIR__ . '/com-parts-m/html-head.php';
// require __DIR__ . '/html/header.php';
// require __DIR__ . '/parts/is_login.php';

$pageName = "add";
$title = "新增";
?>

<body>


  <?php

  if (!isset($_SESSION["admin"])) {
    include __DIR__ . '/login.php';
  } else {
    include __DIR__ . '/html/main.php';
  }
  ?> 



 
<?php include __DIR__ . '/com-parts-m/html-foot.php'  ?>