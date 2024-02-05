<?php 
// require __DIR__ . '/parts/db connect2.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';


$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0; //不會有side為0的情況所以不會刪到資料

$sql_o = "DELETE FROM  orders WHERE order_id=$order_id";
$pdo->query($sql_o);

$sql_od = "DELETE FROM order_details WHERE order_id = $order_id";
$pdo->query($sql_od);


# $_SERVER['HTTP_REFERER'] # 人從哪裡來

$goto = empty($_SERVER['HTTP_REFERER']) ? "list.php" : $_SERVER['HTTP_REFERER']; //如果此為空(沒有上一頁的紀錄)那就是到第一頁 如果有 就是繼續在這頁

header('Location: ' . $goto);
//header(Location: list.php) header語法在冒號後一定要空格