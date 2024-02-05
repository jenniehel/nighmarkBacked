<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$pageName = "edit";
$title = "編輯";

// include __DIR__ . "/components/head.php";

// 取得要編輯的資料
if (!empty($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $sql = "SELECT * FROM `products` WHERE `product_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        // 找不到要編輯的資料，轉向至列表頁
        header('Location: list.php');
        exit;
    }
} else {
    // 沒有提供 product_id，轉向至列表頁
    header('Location: list.php');
    exit;
}

// 編輯成功的提示訊息
$editMessage = '';

// 提交表單後的處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 檢查是否有變更
    $isDataChanged = false;

    // 判斷是否有任何欄位被編輯
    foreach ($row as $key => $value) {
        if (isset($_POST[$key]) && $_POST[$key] !== $value) {
            $isDataChanged = true;
            break;
        }
    }

    if ($isDataChanged) {
        // 有變更，執行更新

        // 檢查是否有選擇新圖片
        if ($_FILES['image_url']['name'] !== '') {
            // 如果有選擇新圖片，先處理上傳
            // $uploadDir = __DIR__ . '/upload/';
            $uploadDir =  $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/product/upload/';
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
            $image_url = $_POST['current_image'];
        }

        // 更新其他資料
        $sql = "UPDATE `products` SET 
            `product_name` = ?,
            `category` = ?,
            `product_description` = ?,
            `image_url` = ?,
            `price` = ?,
            `stock_quantity` = ?,
            `listing_date` = ?
            WHERE `product_id` = ?";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                $_POST['product_name'],
                $_POST['category'],
                $_POST['product_description'],
                $image_url,
                $_POST['price'],
                $_POST['stock_quantity'],
                $_POST['listing_date'],
                $product_id,
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
} else {
    // 表單未提交，使用 $row 中的資料預設顯示
    $_POST = $row;
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
    <h2>編輯產品資料</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">編輯資料</h5>
                    <?php if (isset($editMessage)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $editMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form name="form1" method="post" action="edit.php?product_id=<?php echo $product_id; ?>" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">產品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="<?php echo htmlspecialchars(isset($_POST['product_name']) ? $_POST['product_name'] : $row['product_name']); ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">產品類別</label>
                            <input type="text" class="form-control" id="category" name="category"
                                value="<?php echo htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : $row['category']); ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_description" class="form-label">產品描述</label>
                            <textarea class="form-control" id="product_description" name="product_description"
                                rows="3"><?php echo htmlspecialchars(isset($_POST['product_description']) ? $_POST['product_description'] : $row['product_description']); ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">產品圖片</label>
                            <input type="file" class="form-control" id="image_url" name="image_url">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="current_image" class="form-label">目前圖片</label>
                            <img src="upload/<?php echo $row['image_url']; ?>" alt="Current Image" style="max-width: 100px;">
                            <input type="hidden" name="current_image" value="<?php echo $row['image_url']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="price" name="price"
                                value="<?php echo htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : $row['price']); ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">庫存數量</label>
                            <input type="text" class="form-control" id="stock_quantity" name="stock_quantity"
                                value="<?php echo htmlspecialchars(isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : $row['stock_quantity']); ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="listing_date" class="form-label">上架日期</label>
                            <input type="date" class="form-control" id="listing_date" name="listing_date"
                                value="<?php echo htmlspecialchars(isset($_POST['listing_date']) ? $_POST['listing_date'] : $row['listing_date']); ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">更新資料</button>
                            </div>

                            <div class="mt-1">
                                <a href="list.php">回到產品列表</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// include __DIR__ . '/components/scripts.php'
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
 ?>