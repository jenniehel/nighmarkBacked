<?php
// require __DIR__ . '/admin-required.php';
// require __DIR__ . "/parts/db connect2.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';


header('Content-Type: application/json'); //宣告json格式

$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "postData" => $_POST,
  "errors" => [],
];

$order_id = isset($_POST["order_id"]) ? intval($_POST["order_id"]) : 0;
if (empty($order_id)) {
  $output['error'] = '沒有資料編號';
  $output['code'] = 401;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}


//去admin生成
$sql_od = "UPDATE `order_details` SET 
`order_quantity`=?
WHERE detail_id=?";
$sql_o = "UPDATE `orders` SET 
`order_amount`=?,
`total_amount`=?
WHERE order_id=?";

//準備資料格式
$stmt_od = $pdo->prepare($sql_od);
$stmt_o = $pdo->prepare($sql_o);

//輸出資料
try {
  //多筆資料輸入foreach
  for($i=0; $i<count($_POST['detail_id']); $i++){
    $stmt_od->execute([
      $_POST['order_quantity'][$i],
      $_POST['detail_id'][$i],
    ]);
  }
  // 判斷成功後就執行 $stmt_o
  // if(boolval($_POST[''][$i])){
  $stmt_o->execute([
    $_POST['total_amount'],
    $_POST['total_amount'],
    $order_id
  ]);
} catch (PDOException $e) {
  $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
}

// $stmt->rowCount(); # 資料變更(影響)幾筆
// $output['success'] = boolval($stmt_od->rowCount());
$output['success'] = boolval($stmt_o->rowCount());
//$output['lastInsertId'] = $pdo->lastInsertId(); //取得最新建立資料的PK #因為是修改所以不需要
// $output['rowCount']=$stmt_od->rowCount();


//改為直接接紹變數
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>