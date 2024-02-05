<?php
require __DIR__ . '/parts/db_connect.php';

header('Content-Type: application/json');

$output = [
    "success" => false,
    "code" => 0,
    "count" => 0,
    "page"=>0,
    "perPage"=>0,
    "postData" => $_POST,
    "error" => '',
];


$searchColumn = $_POST['txt_class'];
$t_sql = "SELECT COUNT(1) FROM `custom` WHERE $searchColumn=?";

// $row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);

$t_sql = "SELECT COUNT(1) FROM custom where custom_name=?";
$txt_value=$_POST["txt_value"];
$stmt = $pdo->prepare($t_sql);
$stmt->execute([$_POST['txt_value']]);
$rows = $stmt->fetch(PDO::FETCH_NUM);
// $row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);

$totalRows = $rows[0]; # 取得總筆數
if ($totalRows == 0) {
    $output['code'] = 502;
    // 沒有資料
    $output['count'] = 0;  
    $output["success"] = true;
    echo json_encode($output);
    exit;
}
else{
    $output['count'] = $rows[0];  
}

if (empty($_POST['txt_value'] or $_POST['txt_class'])) {
    # 欄位資料不足
    $output['code'] = 401;
    echo json_encode($output);
    exit;
}




$searchColumn = $_POST['txt_class'];
$sql = sprintf("SELECT * FROM custom  where $searchColumn = ? ORDER BY custom_name DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$txt_value=$_POST["txt_value"];
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['txt_value']]);
$rows2 = $stmt->fetchAll();
 

if (empty($rows2)) {
    # 帳號是錯的
    $output['code'] = 403;
    $output['postData'] = $rows2;
    echo json_encode($output);
    exit;
} else {
    $output['success'] = true;
    $output['postData'] = $rows2;
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
