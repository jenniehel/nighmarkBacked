<?php
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

header('Content-Type: application/json');

$output = [
    "success" => false,
    "code" => 0,
    "message" =>"", 
    "perPage"=>0,
    "postData" => $_POST,
    "error" => '',
];
$data= json_encode($_POST);
$t_sql = "SELECT COUNT(1) FROM custom where custom_email=?";
$stmt = $pdo->prepare($t_sql);
$stmt->execute([$_POST['email']]);
$rows = $stmt->fetch(PDO::FETCH_NUM);
// $row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);

$totalRows = $rows[0]; # 取得總筆數
if ($totalRows > 0) {
    $output['code'] = 502;
    // 沒有資料
    $output['message'] =  "已有註冊過，請填其他的喔!!!";  
    $output["success"] = true;
    echo json_encode($output);
    exit;
}
 







echo json_encode($output, JSON_UNESCAPED_UNICODE);
