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

if (isset($_FILES['ad_image']) && $_FILES['ad_image']['error'] == UPLOAD_ERR_OK) {
    // $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
    // $targetDir = "public/images/";
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/ad/public/images/';
    $targetFile = $targetDir . basename($_FILES['ad_image']['name']);

    if (move_uploaded_file($_FILES['ad_image']['tmp_name'], $targetFile)) {
        $output["success"] = true;
        $output["file"] = basename($_FILES['ad_image']['name']);

        $sql = "INSERT INTO `ad_record`(`ad_id`, `merchant_id`, `start_date`, `state`, `ad_image`) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['ad_id'],
            $_POST['merchant_id'],
            $_POST['state'],
            $output["file"],
        ]);

        $output["success"] = boolval($stmt->rowCount());
        $output["lastInsertId"] = $pdo->lastInsertId();
    } else {
        $output["error"] = "檔案上傳失敗";
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
