<?php
require __DIR__ . '/com-parts/db_connect.php';

header('Content-Type: application/json');

$output = [
  "success" => false,
  "code" => 0,
  "postData" => $_POST,
  "error" => '',
];


if (empty($_POST['bg_email']) or empty($_POST['bg_password'])) {
  # 欄位資料不足
  $output['code'] = 401;
  echo json_encode($output);
  exit;
}

# 先由帳號找到該筆
$sql = "SELECT * FROM `custom_bg` WHERE bg_email=? or bg_name=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['bg_email'],$_POST['bg_email']]);
$row = $stmt->fetch();

if (empty($row)) {
  # 帳號是錯的
  $output['code'] = 403;
  echo json_encode($output);
  exit;
}
// $totalRows = $row[0]; # 取得總筆數
 
$output['success'] = password_verify($_POST['bg_password'], $row['bg_password']);
if ($output['success']) {
  $_SESSION['admin'] = [
    'bg_email' => $row['bg_email'],
    'bg_id' => $row['bg_id'],
  ];
} else {
  # 密碼是錯的
  $output['code'] = 405;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
