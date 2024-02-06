<?php
// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

$custom_Id = isset($_GET['custom_Id']) ? intval($_GET['custom_Id']) : 0;

$sql = "DELETE FROM custom WHERE custom_Id=$custom_Id ";

$pdo->query($sql);

# $_SERVER['HTTP_REFERER'] # 人從哪裡來
// 使用$_SERVER[‘HTTP_REFERER’] 將很容易得到鏈接到當前頁面的前一頁面的地址
$goto = empty($_SERVER['HTTP_REFERER']) ? 'read.php' : $_SERVER['HTTP_REFERER'];

header('Location: '. $goto);