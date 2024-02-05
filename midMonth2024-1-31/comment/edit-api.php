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
$comment_id = isset($_POST["comment_id"]) ? intval($_POST["comment_id"]) : 0;
if (empty($comment_id)) {
    $output["error"] = "沒有資料編號";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "UPDATE `comment` SET 
`custom_id`=?,
`merchant_id`=?,
`service_rating`=?,
`product_ratings`=?,
`content`=?,
`recommend_food`=?,
`parking`=?,
`date`=?
WHERE comment_id=?";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['custom_id'],
        $_POST['merchant_id'],
        $_POST['service_rating'],
        $_POST['product_ratings'],
        $_POST['content'],
        $_POST['recommend_food'],
        $_POST['parking'],
        $_POST['date'],
        $comment_id
    ]);
} catch (PDOException $e) {
    $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
}

// $stmt->rowCount();  //資料變更了幾筆
$output["success"] = boolval($stmt->rowCount());

echo json_encode($output, JSON_UNESCAPED_UNICODE);
