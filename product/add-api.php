<?php
// 导入数据库连接
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/product/upload/';

$allowedExtensions = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/webp' => '.webp',
];

$response = ['success' => false, 'files' => []];

if (!empty($_FILES) && !empty($_FILES['image_url'])) {
    $file = $_FILES['image_url'];

    if (!empty($allowedExtensions[$file['type']]) && $file['error'] == 0) {
        $extension = $allowedExtensions[$file['type']];
        $fileName = sha1($file['name'] . uniqid() . rand()) . $extension;

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            $response['files'][] = $fileName;
            $response['success'] = true;

            // 处理表单提交
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['product_name'])) {
                // 获取用户输入
                $product_name = $_POST['product_name'];
                $category = $_POST['category'];
                $product_description = $_POST['product_description'];
                $price = $_POST['price'];
                $stock_quantity = $_POST['stock_quantity'];
                $listing_date = $_POST['listing_date'];

                // 添加产品到数据库
                $sql = "INSERT INTO products (product_name, category, product_description, image_url, price, stock_quantity, listing_date)
                        VALUES (:product_name, :category, :description, :image_url, :price, :stock_quantity, :listing_date)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
                $stmt->bindParam(':description', $product_description, PDO::PARAM_STR);
                $stmt->bindParam(':image_url', $fileName, PDO::PARAM_STR); // Use the file name here
                $stmt->bindParam(':price', $price, PDO::PARAM_INT);
                $stmt->bindParam(':listing_date', $listing_date, PDO::PARAM_STR);
                $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
                $stmt->bindParam(':listing_date', $listing_date, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    // 添加成功，重定向回产品列表页
                    $response['redirect'] = 'list.php';
                } else {
                    // 添加失败
                    $response['error'] = 'Failed to add product to database.';
                }
            }
        } else {
            // 添加日誌
            error_log('Failed to move uploaded file');

            // 或者使用 var_dump
            var_dump('Failed to move uploaded file');
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
