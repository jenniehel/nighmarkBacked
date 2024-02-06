<?php
require __DIR__ . "/parts/db connect2.php";

header('Content-Type: application/json'); //宣告json格式





$output = [
  "success" => false,
  "code" => 0,
  "postData" => $_POST,
  "error" => '',
];

if (empty($_POST['email']) or empty($_POST['password'])) {
  #欄位資料不足
  $output['code'] = 401;
  echo json_encode($output);
  exit;
}

#由帳號找到該筆
$sql = "SELECT * FROM members WHERE email=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['email']]);
$row = $stmt->fetch();

if (empty($row)) {
  # 帳號是錯的
  $output['code'] = 403;
  echo json_encode($output);
  exit;
}

$output['success'] = password_verify($_POST['password'], $row['password']);#請看password-verify那支

if ($output['success']) {
  $_SESSION['admin'] = [
    'id' => $row['id'],
    'email' => $row['email'],
    'nickname' => $row['nickname'],
  ];
} else {
  # 密碼是錯的
  $output['code'] = 405;
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
