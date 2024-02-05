<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$records_per_page = 10;
$pageName = "list";
$title = "列表";

// 獲取當前頁碼
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

// 處理搜尋
$search_name = '';
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = $_GET['search_name'];
    $sql = "SELECT * FROM products WHERE product_name LIKE :search_name";
} else {
    $sql = "SELECT * FROM products";
}

// 处理类别过滤
$category_filter = '';
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $category_filter = $_GET['category'];
    $sql .= " WHERE category_id = :category";
}

// 獲取總數據數
$total_records = $pdo->prepare($sql);
if (!empty($search_name)) {
    $search_name = '%' . $search_name . '%';
    $total_records->bindParam(':search_name', $search_name, PDO::PARAM_STR);
}
if (!empty($category_filter)) {
    $total_records->bindParam(':category', $category_filter, PDO::PARAM_INT);
}
$total_records->execute();
$total_records = $total_records->rowCount();

// 計算總頁數
$total_pages = ceil($total_records / $records_per_page);

// 計算 OFFSET
$offset = ($current_page - 1) * $records_per_page;

$sql .= " ORDER BY product_id DESC";
$sql .= " LIMIT :offset, :records_per_page";


// 執行查詢
$stmt = $pdo->prepare($sql);
if (!empty($search_name)) {
    $stmt->bindParam(':search_name', $search_name, PDO::PARAM_STR);
}
if (!empty($category_filter)) {
    $stmt->bindParam(':category', $category_filter, PDO::PARAM_INT);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// 獲取結果
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 獲取產品種類
$category_sql = "SELECT * FROM product_categories";
$categories = $pdo->query($category_sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include __DIR__ . "/components/head.php" ?>

<div class="container mt-3">
    <!-- Bootstrap 表格 -->
    <div class="container">
        <h2>產品資料</h2>


        <form method="get" class="mb-3" onsubmit="return validateSearch()">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-sm" id="search_name" name="search_name"
                            value="<?php echo htmlspecialchars(trim($search_name, '%')); ?>">
                        <button type="submit" class="btn btn-primary btn-sm">搜尋產品</button>
                        <div class="text-md-end">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="resetSearch()">
                            重製搜尋
                        </button>
                        </div>
                        <div class="text-md-end">
                            <a href="add.php" class="btn btn-primary btn-sm">新增資料</a>
                        </div>
                    </div>
                    <small id="searchError" class="form-text text-danger"></small>
                </div>
                <div class="col-md-6">
                    <!-- 類別下拉選單 -->
                    <select class="form-select form-select-sm" id="category_filter" name="category"
                        onchange="filterByCategory()">
                        <option value="" selected>選擇類別</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']; ?>" <?php echo ($category_filter == $category['category_id']) ? 'selected' : ''; ?>>
                                <?php echo $category['category_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- 分頁 -->
        <ul class="pagination mt-5 mb-5 ">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=1">
                        <i class="fa-solid fa-angles-left"></i> 第一頁
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                        <i class="fa-solid fa-angle-left"></i> 上一頁
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-angles-left"></i> 第一頁</span>
                </li>
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-angle-left"></i> 上一頁</span>
                </li>
            <?php endif; ?>

            <?php for ($i = max(1, $current_page - 2); $i <= min($current_page + 2, $total_pages); $i++): ?>
                <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                        下一頁 <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $total_pages; ?>">
                        最後一頁 <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">下一頁 <i class="fa-solid fa-angle-right"></i></span>
                </li>
                <li class="page-item disabled">
                    <span class="page-link">最後一頁 <i class="fa-solid fa-angles-right"></i></span>
                </li>
            <?php endif; ?>
        </ul>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>刪除</th>
                    <th>產品ID</th>
                    <th>產品名稱</th>
                    <th>產品類別</th>
                    <th>產品敘述</th>
                    <th>產品圖片</th>
                    <th>販售日期</th>
                    <th>產品價格</th>
                    <th>總數量</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <a href="delete-api.php?product_id=<?php echo $row['product_id']; ?>"
                                onclick="return confirm('確定要刪除這條資料嗎？');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            <?php echo $row['product_id']; ?>
                        </td>
                        <td>
                            <?php echo $row['product_name']; ?>
                        </td>
                        <td>
                            <?php echo $row['category']; ?>
                        </td>
                        <td>
                            <?php echo $row['product_description']; ?>
                        </td>
                        <td>
                            <img src="upload/<?php echo $row['image_url']; ?>" alt="Product Image"
                                style="max-width: 100px;">
                        </td>
                        <!-- 圖片的src需要資料夾 -->
                        <td>
                            <?php echo $row['listing_date'] ?>
                        </td>
                        <td>
                            <?php echo $row['price']; ?>
                        </td>
                        <td>
                            <?php echo $row['stock_quantity']; ?>
                        </td>
                        <td>
                            <a href="edit.php?product_id=<?= $row['product_id'] ?>">
                                <i class="fa-solid fa-file-pen"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>



    </div>
</div>

<script>
        function resetSearch() {
        document.getElementById('search_name').value = '';
        document.getElementById('searchError').innerText = '';
        // 這裡可以加上其他重製邏輯，例如重置類別下拉選單等
        // 重新提交表單
        document.forms[0].submit();
    }

    function validateSearch() {
        var searchName = document.getElementById('search_name').value.trim();
        var errorField = document.getElementById('searchError');

        if (searchName === '') {
            errorField.innerText = '請輸入搜尋欄位';
            return false;
        } else {
            errorField.innerText = '';
            return true;
        }
    }

    function filterByCategory() {
        var categoryFilter = document.getElementById('category_filter').value;
        window.location.href = 'list.php?category=' + categoryFilter;
    }
</script>

<?php 
// include __DIR__ . '/components/scripts.php'
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
 ?>