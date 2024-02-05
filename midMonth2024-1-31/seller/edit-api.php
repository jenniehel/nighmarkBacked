<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/seller/upload/';


// 獲取商家ID
$seller_id = isset($_GET['seller_id']) ? intval($_GET['seller_id']) : 0;

// 如果沒有提供商家ID，返回錯誤信息
if ($seller_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid seller ID']);
    exit;
}

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 直接使用 $_POST 中的資料進行更新
    $updateSql = "UPDATE `sellers` SET 
        `name` = ?,
        `company_name` = ?,
        `email` = ?,
        `address` = ?,
        `introduction` = ?,
        `phone` = ?,
        `business_hours_start` = ?,
        `business_hours_end` = ?
        WHERE `seller_id` = ?";

    $updateStmt = $pdo->prepare($updateSql);

    try {
        $updateStmt->execute([
            $_POST['name'],
            $_POST['company_name'],
            $_POST['email'],
            $_POST['address'],
            $_POST['introduction'],
            $_POST['phone'],
            $_POST['business_hours_start'],
            $_POST['business_hours_end'],
            $seller_id,
        ]);

        // 更新成功，返回成功信息
        echo json_encode(['status' => 'success', 'message' => 'Seller updated successfully', 'updated_fields' => [
            'name', 'company_name', 'email', 'address', 'introduction', 'phone', 'business_hours_start', 'business_hours_end'
        ]]);

    } catch (PDOException $e) {
        // SQL 錯誤，返回錯誤信息
        echo json_encode(['status' => 'error', 'message' => 'Error updating seller: ' . $e->getMessage()]);
    }

} else {
    // 如果不是 POST 請求，返回錯誤信息
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
