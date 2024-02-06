
 <?php
  header('Content-Type: application/json');
  // require __DIR__ . '/admin-required.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

  $output = [
    "success" => false,
    "error" => "",
    "code" => 0,
    "postData" => $_POST,
    "errors" => [],
    "doing" => ""
  ];

  // 判斷是否有圖
  $output['doing'] = strval($_POST["doing"]);
  if (isset($_FILES["myImage"]) && $_FILES["myImage"]["error"] == 0) {
    $image = $_FILES['myImage']['tmp_name'];
    $myImage = file_get_contents($image); 
  } else {
    $myImage = "";
  }

  // 判斷update Or create
  if ($output['doing'] == "update") {
    $custom_Id = isset($_POST['custom_Id']) ? intval($_POST['custom_Id']) : 0;
    if (empty($custom_Id)) {
      $output['error'] = '沒有資料編號';
      $output['code'] = 401;
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    // 更新
    $sql = "UPDATE `custom` SET 
    `custom_account`=?,
    `custom_name`=?,
    `custom_email`=?,
    `custom_password`=?,
    `custom_date`=NOW(),
    `custom_authorId`=?,
    `custom_image`=?
    WHERE `custom_Id`=? ";
  } else if ($output['doing'] == "create") {
    //     記得拿掉//
        // 新曾
    $sql = "INSERT INTO `custom`(`custom_account`, `custom_name`, `custom_email`, `custom_password`,`custom_date`,`custom_authorId`,`custom_image`) VALUES (?, ?, ?, ?, NOW(),?,?)";
    // $sql = "INSERT INTO `custom`(`custom_account`, `custom_name`, `custom_email`, `custom_password`,`custom_date`,`custom_authorId`) VALUES (?, ?, ?, ?, NOW(),?)";
  }






  $stmt = $pdo->prepare($sql);
  try {

    // 判斷update Or create 
    if ($output['doing'] == "update") {
      $stmt->execute([
        $_POST['inputId'],
        $_POST['customName'],
        $_POST['email'],
        $_POST['password'],
        $_POST['custom_authorId'],
        $myImage,
        $_POST['custom_Id']
      ]);
    } else if ($output['doing'] == "create") {
      $stmt->execute([
        $_POST['inputId'],
        $_POST['customName'],
        $_POST['email'],
        $_POST['password'],
        // base64_encode($_POST['reaultImg']),
        1,
        $myImage
      ]);
    }
  } catch (PDOException $e) {
    $output['error'] = 'SQL有東西出錯了' . $e->getMessage();
    $output['postData'] = 'SQL有東西出錯了' .    $_POST['custom_Id'];
  }

  // $stmt->rowCount(); # 新增幾筆
  $output['success'] = boolval($stmt->rowCount());
  if ($output['doing'] == "create") {
    $output['lastInsertId'] = $pdo->lastInsertId();  // 取得最新建立資料的 PK
  }


  header('Content-Type: application/json');
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
