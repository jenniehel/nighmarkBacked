<?php
// 导入数据库连接
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

// 获取要删除的产品ID
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);

if ($product_id === false || $product_id === null) {
    // 非法的参数，这里可以进行错误处理
    echo "Invalid product ID";
    exit;
}

// 构建 SQL 查询
$sql = "DELETE FROM products WHERE product_id = :product_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

// 执行删除操作
if ($stmt->execute()) {
    // 删除成功，重定向回产品列表页
    header("Location: list.php");
    exit;
} else {
    // 删除失败，这里可以进行错误处理
    echo "Delete operation failed";
    exit;
}
?>
