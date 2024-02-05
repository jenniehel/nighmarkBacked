<?php

require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
header('Content-Type: application/json');

// $uploadDir = './imgs/'; // 存放上傳圖片的資料夾
// $uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/balloon/imgs/'; // 存放上傳圖片的資料夾
$uploadDir = './imgs/'; // 存放上傳圖片的資料夾

$uploadFile = $uploadDir . basename($_FILES['image']['name']);

$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "postData" => $_POST,
  "errors" => [],
];

// TODO: 資料輸入之前, 要做檢查
# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)

// $imagePath = $uploadDir . $_FILES['image']['name'];
$imagePath = $uploadFile;

// $imagePath = './imgs/Bomb.png';


// $imgPath = '/./imgs/Green_Balloon.png';
if (isset($_FILES['image'])) {
  $imagePath = 'imgs/' . $_FILES['image']['name']; // 計算保存到資料夾的路徑
  move_uploaded_file($_FILES['image']['tmp_name'], $imagePath); // 移動上傳的文件到目標路徑
} else {
  $output['error'] = '沒有接收到圖片數據';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}


$sql = "INSERT INTO `balloon_data`
(`balloon_id`,
 `balloon_type`,
 `broken_score`,
 `balloon_speed`,
  `image`) VALUES(?, ?, ?, ?, ? )"; //NOW()取得現在時間

$stmt = $pdo->prepare($sql);

try {
  $stmt->execute([
    $_POST['balloon_id'],
    $_POST['balloon_type'],
    $_POST['broken_score'],
    $_POST['balloon_speed'],
    $imagePath,
  ]);
} catch (PDOException $e) {
  $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
}



// $stmt->rowCount(); # 新增幾筆
$output['success'] = boolval($stmt->rowCount());
$output['lastInsertId'] = $pdo->lastInsertId();

header('Content-Type: application/json');

echo json_encode($output, JSON_UNESCAPED_UNICODE);
