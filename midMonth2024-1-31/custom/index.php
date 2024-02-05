<?php
require __DIR__ . '/parts/db_connect.php';
require __DIR__ . '/parts/html-head.php';
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
   include __DIR__ . '/html/header.php';
    include __DIR__ . '/main.php';
  }
  ?> 



<?php include __DIR__ . '/parts/script.php'  ?>
<?php include __DIR__ . '/parts/html-foot.php'  ?>