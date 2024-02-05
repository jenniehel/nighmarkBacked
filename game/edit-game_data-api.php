<?php
// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
header('Content-Type: application/json');

$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "postData" => $_POST,
  "errors" => [],
];

// TODO: 資料輸入之前, 要做檢查
# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)

$sid = isset($_POST['level_id']) ? intval($_POST['level_id']) : 0;
if(empty($sid)){
  $output['error'] = '沒有資料編號';
  $output['code'] = 401;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

# 如果沒有值就設定為空值 null
// $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];
// $birthday = strtotime($birthday); # 轉換為 timestamp
// if($birthday===false){
//   $birthday = null;
// } else {
//   $birthday = date('Y-m-d', $birthday);
// }

$sql = "UPDATE `game_data` SET 
  `level_id`=?,
  `time_limit`=?,
  `get_point`=?,
  `require_score`=?
  WHERE level_id=? ";

$stmt = $pdo->prepare($sql);

try {
  $stmt->execute([
    $_POST['level_id'],
    $_POST['time_limit'],
    $_POST['get_point'],
    $_POST['require_score'],
    $sid
  ]);
} catch(PDOException $e) {
  $output['error'] = 'SQL有東西出錯了'. $e->getMessage();
}

// $stmt->rowCount(); # 資料變更了幾筆
$output['success'] = boolval($stmt->rowCount());


echo json_encode($output, JSON_UNESCAPED_UNICODE);