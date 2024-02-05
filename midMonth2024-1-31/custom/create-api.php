console.log("ddd");
<?php 
// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';


$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "postData" => $_POST,
  "errors" => [],
];


# 如果沒有值就設定為空值 null
// $myImage = empty($_POST['myImage']) ? null : $_POST['myImage']; 

// $output['success'] = password_verify($_POST['password'], $_POST['password2']);
// if(!$output['success']){

// }
$sql = "INSERT INTO `custom`(`custom_account`, `custom_name`, `custom_email`, `custom_password`,`custom_date`,`custom_authorId`) VALUES (?, ?, ?, ?,    NOW(),?)";

$stmt = $pdo->prepare($sql);
// customName: "aa", inputId: "2", email: "ming@gg.com", password: "1", password2: "1"}
try {
  $stmt->execute([
    $_POST['inputId'],
    $_POST['customName'],
    $_POST['email'],
    $_POST['password'],
    1
    // $myImage
  ]);
} catch (PDOException $e) {
  $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
  $output['postData'] = 'SQL有東西出錯了' . $_POST['inputId'] .
    $_POST['customName'] .
    $_POST['email'] .
    $_POST['password'];
}

// $stmt->rowCount(); # 新增幾筆
$output['success'] = boolval($stmt->rowCount());
$output['lastInsertId'] = $pdo->lastInsertId();  // 取得最新建立資料的 PK

header('Content-Type: application/json');

echo json_encode($output, JSON_UNESCAPED_UNICODE);
