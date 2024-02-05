<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/seller/upload/';

$pageName = "edit";
$title = "編輯";

// include __DIR__ . "/components/head.php";


// 確認是否有收到 seller_id
if (!empty($_GET['seller_id'])) {
    $seller_id = intval($_GET['seller_id']);

    // 準備 SQL 查詢
    $sql = "SELECT * FROM sellers WHERE seller_id = :seller_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->execute();

    // 確認是否有找到對應的資料
    if ($stmt->rowCount() > 0) {
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // 如果找不到對應資料，可以進行適當的處理（例如轉向錯誤頁面）
        echo "找不到對應的商家資料";
        exit;
    }
} else {
    // 如果沒有收到 seller_id，可以進行適當的處理（例如轉向錯誤頁面）
    echo "未提供商家 ID";
    exit;
}
// 先定義變量，避免未定義的錯誤
$name = isset($_POST['name']) ? $_POST['name'] : '';
$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$introduction = isset($_POST['introduction']) ? $_POST['introduction'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$business_hours_start = isset($_POST['business_hours_start']) ? $_POST['business_hours_start'] : '';
$business_hours_end = isset($_POST['business_hours_end']) ? $_POST['business_hours_end'] : '';
$image_url = isset($_POST['current_image']) ? $_POST['current_image'] : '';


// 編輯成功的提示訊息
$editMessage = '';

// 提交表單後的處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 檢查是否有變更
    $isDataChanged = false;

    // 判斷是否有任何欄位被編輯
    foreach ($seller as $key => $value) {
        if (isset($_POST[$key]) && $_POST[$key] !== $value) {
            $isDataChanged = true;
            break;
        }
    }

    if ($isDataChanged) {
        // 有變更，執行更新

        // 檢查是否有選擇新圖片
        if (!empty($_FILES['image_url']['name'])) {
            // 如果有選擇新圖片，先處理上傳
            // $uploadDir = __DIR__ . '/upload/';
            $uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/seller/upload/';

            $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);

            // 移動上傳的檔案
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                // 上傳成功，更新 image_url
                $image_url = basename($_FILES['image_url']['name']);
            } else {
                // 上傳失敗，這裡可以進行錯誤處理
                $editMessage = '圖片上傳失敗';
            }
        } else {
            // 如果沒有選擇新圖片，保留原有的圖片
            $image_url = $seller['image_url'];
        }

        // 更新其他資料
        $sql = "UPDATE sellers SET 
            name = :name,
            company_name = :company_name,
            email = :email,
            address = :address,
            image_url = :image_url,
            introduction = :introduction,
            phone = :phone,
            business_hours_start = :business_hours_start,
            business_hours_end = :business_hours_end
            WHERE seller_id = :seller_id";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':name' => $_POST['name'],
                ':company_name' => $_POST['company_name'],
                ':email' => $_POST['email'],
                ':address' => $_POST['address'],
                ':image_url' => $image_url,
                ':introduction' => $_POST['introduction'],
                ':phone' => $_POST['phone'],
                ':business_hours_start' => $_POST['business_hours_start'],
                ':business_hours_end' => $_POST['business_hours_end'],
                ':seller_id' => $seller_id,
            ]);

            // 更新成功，設定編輯成功的提示訊息
            $editMessage = '編輯成功';

        } catch (PDOException $e) {
            // SQL 錯誤
            $editMessage = 'SQL 有東西出錯了' . $e->getMessage();
        }
    } else {
        // 沒有變更
        $editMessage = '資料未變更';
    }
}

?>
<style>
    form .mb-3 .form-text {
        color: red;
    }

    .is-invalid {
        border: 1px solid red;
    }
</style>


<div class="container mt-3">
    <h2>編輯商家資料</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">編輯資料</h5>
                    <?php if (!empty($editMessage)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $editMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form name="form1" method="post" action="edit.php?seller_id=<?php echo $seller_id; ?>"
                        enctype="multipart/form-data">

                        <!-- 攤位名稱 -->
                        <div class="mb-3">
                            <label for="name" class="form-label">攤位名稱</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($_POST['name']) ? $_POST['name'] : $seller['name']; ?>">
                            <div class="form-text"></div>
                        </div>

                        <!-- 公司名稱 -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">公司名稱</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="<?php echo isset($_POST['company_name']) ? $_POST['company_name'] : $seller['company_name']; ?>">
                            <div class="form-text"></div>
                        </div>

                        <!-- 電子信箱 -->
                        <div class="mb-3">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?php echo isset($_POST['email']) ? $_POST['email'] : $seller['email']; ?>">
                            <div class="form-text"></div>
                        </div>

                        <!-- 攤位地址 -->
                        <div class="mb-3">
                            <label for="address" class="form-label">攤位地址</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="<?php echo isset($_POST['address']) ? $_POST['address'] : $seller['address']; ?>">
                            <div class="form-text"></div>
                        </div>

                        <!-- 賣家圖片 -->
                        <div class="mb-3">
                            <label for="image" class="form-label">賣家圖片</label>
                            <input type="file" class="form-control" id="image" name="image_url">
                            <div class="form-text"></div>
                        </div>

                        <!-- 目前圖片 -->
                        <div class="mb-3">
                            <label for="current_image" class="form-label">目前圖片</label>
                            <img src="upload/<?php echo $seller['image_url']; ?>" alt="Current Image"
                                style="max-width: 100px;">
                            <input type="hidden" name="current_image" value="<?php echo $seller['image_url']; ?>">
                        </div>

                        <!-- 攤位簡介 -->
                        <div class="mb-3">
                            <label for="introduction" class="form-label">攤位簡介</label>
                            <textarea class="form-control" id="introduction" name="introduction"
                                rows="3"><?php echo isset($_POST['introduction']) ? $_POST['introduction'] : $seller['introduction']; ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <!-- 連絡電話 -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">連絡電話</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $seller['phone']; ?>">
                            <div class="form-text"></div>
                        </div>


                        <div class="business-hours-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="select-container">
                                        <label for="business_hours_start">開始時間：</label>
                                        <select name="business_hours_start" id="business_hours_start">
                                            <?php
                                            // 產生 24 小時的選項
                                            for ($i = 0; $i < 24; $i++) {
                                                $startHour = sprintf("%02d:00", $i);
                                                echo "<option value='$startHour' " . ($startHour == $business_hours_start ? 'selected' : '') . ">$startHour:00</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="select-container">
                                        <label for="business_hours_end">結束時間：</label>
                                        <select name="business_hours_end" id="business_hours_end">
                                            <?php
                                            // 產生 24 小時的選項
                                            for ($i = 0; $i < 24; $i++) {
                                                $endHour = sprintf("%02d:00", $i);
                                                echo "<option value='$endHour' " . ($endHour == $business_hours_end ? 'selected' : '') . ">$endHour:00</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">更新数据</button>
                            </div>

                            <div class="mt-1">
                                <a href="list.php">回到賣家列表</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
//  include __DIR__ . "/components/scripts.php"
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
  ?>