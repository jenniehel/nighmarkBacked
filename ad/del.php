<?php 
// include "parts/db-content.php";
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$comment_id = isset($_GET["comment_id"]) ? intval($_GET["comment_id"]) : 0;
$record_id = isset($_GET["record_id"]) ? intval($_GET["record_id"]) : 0;

$sql = "DELETE FROM comment WHERE comment_id=$comment_id";
$sql2 = "DELETE FROM ad_record WHERE record_id=$record_id";

$pdo->query($sql);
$pdo->query($sql2);

$goto = empty($_SERVER['HTTP_REFERER']) ? 'comment.php' : $_SERVER['HTTP_REFERER'];
$goto2 = empty($_SERVER['HTTP_REFERER']) ? 'ad_record.php' : $_SERVER['HTTP_REFERER'];

header('Location: '. $goto);