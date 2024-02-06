<?php
// 导入数据库连接
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';


// 获取产品ID
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// 如果没有提供产品ID，返回错误信息
if ($product_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// 查询数据库，获取产品信息
$sql = "SELECT * FROM `products` WHERE `product_id` = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// 如果没有找到产品，返回错误信息
if (!$product) {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    exit;
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取用户输入
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $listing_date = $_POST['listing_date'];

  

    // 更新产品信息
    $updateSql = "UPDATE `products` SET 
        `product_name` = ?,
        `category` = ?,
        `product_description` = ?,
        `image_url` = ?,
        `price` = ?,
        `stock_quantity` = ?,
        `listing_date` = ?
        WHERE `product_id` = ?";

    $updateStmt = $pdo->prepare($updateSql);

    try {
        $updateStmt->execute([
            $product_name,
            $category,
            $product_description,
            $image_url,
            $price,
            $stock_quantity,
            $listing_date,
            $product_id,
        ]);

        // 更新成功，返回成功信息
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);

    } catch (PDOException $e) {
        // SQL 错误，返回错误信息
        echo json_encode(['status' => 'error', 'message' => 'SQL error: ' . $e->getMessage()]);
    }

} else {
    // 如果不是 POST 请求，返回错误信息
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

