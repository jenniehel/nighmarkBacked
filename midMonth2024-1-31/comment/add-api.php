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

$sql = "INSERT INTO `comment`(`custom_id`, `merchant_id`, `service_rating`, `product_ratings`, `content`, `recommend_food`, `parking`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['custom_id'],
    $_POST['merchant_id'],
    $_POST['service_rating'],
    $_POST['product_ratings'],
    $_POST['content'],
    $_POST['recommend_food'],
    $_POST['parking'],
]);

$output["success"] = boolval($stmt->rowCount());
$output["lastInsertId"] = $pdo->lastInsertId();

echo json_encode($output, JSON_UNESCAPED_UNICODE);
