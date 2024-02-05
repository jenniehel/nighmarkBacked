<?php
// require __DIR__ . '/admin-required.php';
// require __DIR__ . "/parts/db connect2.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';





$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "postData" => $_POST,
  "errors" => [],
];
// TODO: 資料輸入之前, 要做檢查
# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)


# 如果沒有值就設定為空值 null #因為widos允許日期不輸入所以不顯示catch錯誤(老師那台跟mac才會)

$sql_o = "INSERT INTO `orders`(`custom_Id`, `order_date`, `order_amount`, `discount`, `point_redeemed`, `total_amount`, `payment_method`, `refund_status`) VALUES (?, NOW(), ?, 0, 0, ?, ?, Null)";


$sql_od ="INSERT INTO `order_details`(`order_id`, `product_id`, `order_price`, `order_quantity`) VALUES (?, ?, ?, ?)";

$stmt_o = $pdo->prepare($sql_o);
$stmt_od = $pdo->prepare($sql_od);



//輸出資料

try {
  $stmt_o->execute([
    $_POST['custom_Id'],
    $_POST['total_amount'],
    $_POST['total_amount'],
    $_POST['payment_method']
  ]);

  $order_id = $pdo->lastInsertId();

  for($i=0; $i<count($_POST['product_id']); $i++){
    $stmt_od->execute([
      $order_id,
      $_POST['product_id'][$i],
      $_POST['price'][$i],
      $_POST['order_quantity'][$i],
    ]);
  }
} catch (PDOException $e) {
  $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
}

// $stmt->rowCount(); # 新增(影響)幾筆
$output['success'] = boolval($stmt_o->rowCount());
//$output['lastInsertId'] = $pdo->lastInsertId(); //取得最新建立資料的PK

header('Content-Type: application/json'); //宣告json格式

//改為直接接收變數
echo json_encode($output, JSON_UNESCAPED_UNICODE);
