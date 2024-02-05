<?php
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
header("Content-Type: application/json");

$output = [
    "success" => false,
    "error" => "",
    "code" => 0,
    "postData" => $_POST,
    "errors" => [],
];

//資料輸入之前, 要做檢查
//......

//
$record_id = isset($_POST["record_id"]) ? intval($_POST["record_id"]) : 0;
if (empty($record_id)) {
    $output["error"] = "沒有資料編號";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "UPDATE `ad_record` SET 
`ad_id`=?,
`merchant_Id`=?,
`start_date`=?,
`state`=?
WHERE record_id=?";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['ad_id'],
        $_POST['merchant_Id'],
        $_POST['start_date'],
        $_POST['state'],
        $record_id
    ]);
} catch (PDOException $e) {
    $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
}

// $stmt->rowCount();  //資料變更了幾筆
$output["success"] = boolval($stmt->rowCount());

echo json_encode($output, JSON_UNESCAPED_UNICODE);
