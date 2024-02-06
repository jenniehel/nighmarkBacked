<?php

$db_host = 'localhost';
// $db_user = 'root';
// $db_pass = '';
$db_user = 'root';
$db_pass = 'root';
$db_name = 'nightmarket';

# data source name

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
$pdo_options=[
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try{

    $pdo = new PDO($dsn, $db_user, $db_pass,$pdo_options);  
}catch(PDOException $ex){
    echo $ex->getMessage();
} 
// if(!isset($_SESSION)) {
//     session_start();
//   }


