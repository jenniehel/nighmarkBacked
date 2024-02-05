<?php
// 資料庫連線 PDO

$db_host = 'localhost';
$db_name = 'night_snack';
$db_user = 'root';
$db_pass = '';

// header("Content-Type: application/json");

$pdo_options = [ //這裡是拿取資料的選擇方式  是一個陣列存放
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //屬性_預設_fetch_mode => 是使用關聯式,

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //屬性_錯誤模式 =>是使用錯誤闡述,
  ];

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

// $pdo = new PDO($dsn, $db_user, $db_pass,$pdo_options);

// $stmt = $pdo->query("SELECT * FROM address_book LIMIT 2");

try{
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
  // 
  }
  
  catch(PDOException $ex){
    //PDO內建的錯誤函式 當錯誤會把值放進來 
    
    echo $ex->getMessage();
    //返回錯誤消息
  }
