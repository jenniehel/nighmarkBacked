<?php 
// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM game_data WHERE level_id=$sid ";

$pdo->query($sql);

#$_SERVER['HTTP_REFERER']#

$goto = empty($_SERVER['HTTP_REFERER']) ? 'game_data.php' :$_SERVER['HTTP_REFERER'];

header('Location: '. $goto);

