<?php
// 导入数据库连接
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
// require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php'
// $uploadDir = __DIR__ . '/upload/';
$uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/seller/upload/';
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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // 获取用户输入
                $name = $_POST['name'] ?? '';
                $company_name = $_POST['company_name'] ?? '';
                $email = $_POST['email'] ?? '';
                $address = $_POST['address'] ?? '';
                $introduction = $_POST['introduction'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $business_hours_start = $_POST['business_hours_start'] ?? '';
                $business_hours_end = $_POST['business_hours_end'] ?? '';

                $startTime = empty($business_hours_start) ? null : $business_hours_start . ':00';
                $endTime = empty($business_hours_end) ? null : $business_hours_end . ':00';

                // 添加賣家到数据库
                $sql = "INSERT INTO sellers (name, company_name, email, address, image_url, introduction, phone, business_hours_start, business_hours_end, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $pdo->prepare($sql);
                try {
                    $stmt->execute([
                        $name,
                        $company_name,
                        $email,
                        $address,
                        $fileName, // Use the file name here
                        $introduction,
                        $phone,
                        $startTime,
                        $endTime,
                    ]);

                    $response['success'] = boolval($stmt->rowCount());

                    if ($response['success']) {
                        $response['message'] = '新增成功';
                        $response['redirect'] = 'list.php'; // 添加重定向信息
                    } else {
                        $response['error'] = 'Failed to add seller to database.';
                    }
                } catch (PDOException $e) {
                    $response['error'] = 'SQL 有東西出錯了' . $e->getMessage();
                    $response['success'] = false;
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
?>
