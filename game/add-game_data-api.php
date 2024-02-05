<?php

// require __DIR__ .'/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$output = [
    "success" => false,
    "error" => "",
    "code" => 0,
    "postData" => $_POST,
    "errors" => [],
];

// TODO: 資料輸入之前, 要做檢查
# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)

# 如果沒有值就設定為空值 null


$sql = "INSERT INTO `game_data`
(`level_id`,
 `time_limit`,
 `get_point`,
 `require_score` ) VALUES(?, ?, ?, ? )"; //NOW()取得現在時間

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
      $_POST['level_id'],
      $_POST['time_limit'],
      $_POST['get_point'],
      $_POST['require_score'],
    ]);
  } catch(PDOException $e) {
    $output['error'] = 'SQL有東西出錯了'. $e->getMessage();
  }



// $stmt->rowCount(); # 新增幾筆
$output['success'] = boolval($stmt->rowCount());
$output['lastInsertId'] = $pdo-> lastInsertId();

header('Content-Type: application/json');

    echo json_encode($output, JSON_UNESCAPED_UNICODE);
