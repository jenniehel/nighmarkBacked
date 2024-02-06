<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php'; 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';

$records_per_page = 3;
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
    $sql = "SELECT * FROM sellers WHERE name LIKE :search_name";
} else {
    $sql = "SELECT * FROM sellers";
}

// 獲取總數據數
$total_records = $pdo->prepare($sql);
if (!empty($search_name)) {
    $search_name = '%' . $search_name . '%';
    $total_records->bindParam(':search_name', $search_name, PDO::PARAM_STR);
}
$total_records->execute();
$total_records = $total_records->rowCount();

// 計算總頁數
$total_pages = ceil($total_records / $records_per_page);

// 計算 OFFSET
$offset = ($current_page - 1) * $records_per_page;

$sql .= " ORDER BY seller_id DESC";
$sql .= " LIMIT :offset, :records_per_page";

// 執行查詢
$stmt = $pdo->prepare($sql);
if (!empty($search_name)) {
    $stmt->bindParam(':search_name', $search_name, PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// 獲取結果
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  <!-- require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/components/head.php'; -->
<?php
//  include __DIR__ . "/components/head.php"
 ?>

<div class="container mt-3 ma-left">
    <h2>商家資料</h2>

    <form method="get" class="mb-3" onsubmit="return validateSearch()" name="searchForm" action="list.php">
        <div class="row mt-3">
            <div class="col-12">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm" id="search_name" name="search_name"
                        value="<?php echo htmlspecialchars(trim($search_name, '%')); ?>">
                    <button type="submit" class="btn btn-primary btn-sm">搜尋攤位</button>

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
        </div>
    </form>


    <!-- 分頁 -->
    <ul class="pagination mt-5 mb-5">
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
    <!-- Bootstrap 表格 -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>刪除資料</th>
                <th>賣家ID</th>
                <th>攤位名子</th>
                <th>公司名稱</th>
                <th>電子信箱</th>
                <th>攤位地址</th>
                <th>圖片</th>
                <th>攤位簡介</th>
                <th>連絡電話</th>
                <th>開始的營業時間</th>
                <th>結束的營業時間</th>
                <th>編輯資料</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td>
                        <a href="delete-api.php?seller_id=<?php echo $row['seller_id']; ?>"
                            onclick="return confirm('確定要刪除這條資料嗎？');">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    <td>
                        <?php echo $row['seller_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['name']; ?>
                    </td>
                    <td>
                        <?php echo $row['company_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['email']; ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['address']) ?>
                    </td>

                    <td>
                        <img src="upload/<?php echo $row['image_url']; ?>" alt="profile_picture" style="max-width: 100px;">
                    </td>

                    <td>
                        <?php echo $row['introduction']; ?>
                    </td>
                    <td>
                        <?php echo $row['phone']; ?>
                    </td>
                    <td>
                        <?php echo date("H:i", strtotime($row['business_hours_start'])); ?>
                    </td>
                    <td>
                        <?php echo date("H:i", strtotime($row['business_hours_end'])); ?>
                    </td>
                    <td>
                        <a href="edit.php?seller_id=<?= $row['seller_id'] ?>">
                            <i class="fa-solid fa-file-pen"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



</div>

<script>
    function validateSearch() {
        var searchName = document.getElementById('search_name').value.trim();
        var errorField = document.getElementById('searchError');

        if (searchName === '') {
            errorField.innerText = '請輸入搜尋欄位';
            return false; // 阻止表單提交
        } else {
            errorField.innerText = ''; // 清空錯誤訊息
            return true; // 允許表單提交
        }
    }
    function resetSearch() {
        document.getElementById('search_name').value = ''; // 清空搜尋欄
        document.getElementById('searchError').innerText = ''; // 清空錯誤訊息
        document.forms['searchForm'].submit(); // 提交表單
    }
</script>
<?php 
// include __DIR__ . '/components/scripts.php' 

include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
?>