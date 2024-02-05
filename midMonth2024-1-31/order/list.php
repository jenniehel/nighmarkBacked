<?php 
// require __DIR__ . '/parts/db connect2.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$pageName = "list";
$title = "列表";


$perPage = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if ($page < 1) {
  // redirect
  header('Location: ?page=1');
  exit();
}

$t_sql = "SELECT COUNT(*) FROM orders";

$row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);

$totalRows = $row[0]; #總筆數

#處理超過總頁數時跳轉到最後一頁
$totalPages = 0; #因為塞進if裡所以設預設值
$rows = []; #一樣是預設值

// 定義是否進行搜尋的變數
$performSearch = false;

if ($totalRows > 0) {
  $totalPages = ceil($totalRows / $perPage);

  if ($page > $totalPages) {
    // redirect
    header('Location: ?page=' . $totalPages);
    exit();
  } #當選擇頁數大於總頁數時

  //處理排序 //預設為遞減排序
  $sort = isset($_GET['sort']) ? $_GET['sort'] : 'desc'; 
  $currentSort = (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'asc' : 'desc';
  
  // 處理搜尋
  $searchKeyword = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : ''; 
  // $searchKeyword = isset($_POST['search']) ? trim($_POST['search']) : '';


  //session處理
  // if (!empty($searchKeyword)) {
  //   $_SESSION['searchKeyword'] = $searchKeyword;
  // } else {
  //   // 如果沒有搜尋條件，清除 Session
  //   unset($_SESSION['searchKeyword']);
  // }

  

  if (!empty($searchKeyword)) {
    $performSearch = true;

    $countSql = sprintf(
      "SELECT COUNT(*) as count FROM orders AS o JOIN custom AS cus ON o.custom_Id = cus.custom_Id
                    WHERE cus.custom_name LIKE '%%%s%%' OR o.order_id LIKE '%%%s%%' OR CONCAT(DATE_FORMAT(o.order_date, '%%Y%%m%%d'), o.order_id) LIKE '%%%s%%'",
      $searchKeyword,
      $searchKeyword,
      $searchKeyword
    );

    $countStmt = $pdo->query($countSql);
    $countResult = $countStmt->fetch(PDO::FETCH_NUM);
    $totalRows = $countResult[0];

    $totalPages = ceil($totalRows / $perPage);

    $sql = sprintf(
      "SELECT o.order_date, o.order_id, cus.custom_name, o.payment_method, o.total_amount 
                FROM orders AS o 
                JOIN custom AS cus ON o.custom_Id = cus.custom_Id
                WHERE cus.custom_name LIKE '%%%s%%' OR o.order_id LIKE '%%%s%%' OR CONCAT(DATE_FORMAT(o.order_date, '%%Y%%m%%d'), o.order_id) LIKE '%%%s%%'
                ORDER BY o.order_id $currentSort LIMIT %s, %s",
      $searchKeyword,
      $searchKeyword,
      $searchKeyword,
      ($page - 1) * $perPage,
      $perPage
    );

    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
  } else {

    $sql = sprintf("SELECT o.order_date, o.order_id, cus.custom_name, o.payment_method, o.total_amount 
                  FROM orders AS o 
                  JOIN custom AS cus ON o.custom_Id = cus.custom_Id
                  ORDER BY o.order_id $sort LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
  }
}

?>

<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include __DIR__ . '/parts/html-head.php'; 
// include __DIR__ . '/parts/navbar.php'
 ?>
<style>
  /* 新增 */
  .table {
    --bs-table-striped-bg: rgba(221, 235, 255, 0.5) !important;
    /* --bs-table-striped-bg: rgba(93, 135, 255, 0.1) !important; */
    --bs-table-hover-bg: rgba(93, 135, 255, 0.25) !important;
  }

  .tz {
    font-size: 12px;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col mt-5">

      <nav aria-label="Page navigation example">
        <ul class="pagination">

          <li class="page-item <?= $page == 1  ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1&sort=<?= $sort ?>&search=<?= urlencode($searchKeyword) ?>"><i class="fa-solid fa-angles-left"></i></a>
          </li>

          <li class="page-item <?= $page == 1  ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>&sort=<?= $sort ?>&search=<?= urlencode($searchKeyword) ?>"><i class="fa-solid fa-angle-left"></i></a>
          </li>

          <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
            if ($i >= 1 and $i <= $totalPages) : ?>
              <!-- 當i大於1 小於等於總頁數時才呈現下面  -->
              <li class="page-item  <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort ?>&search=<?= urlencode($searchKeyword) ?>"><?php echo $i ?></a>
              </li>
          <?php endif;
          endfor; ?>

          <li class="page-item <?= $page == $totalPages  ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>&sort=<?= $sort ?>&search=<?= urlencode($searchKeyword) ?>"><i class="fa-solid fa-angle-right"></i></a>
          </li>

          <li class="page-item <?= $page == $totalPages  ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>&sort=<?= $sort ?>&search=<?= urlencode($searchKeyword) ?>"><i class="fa-solid fa-angles-right"></i></a>
          </li>

        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 mt-3 mb-3">
      <form class="d-flex" method="post" action="list.php?page=<?= $page ?>&sort=<?= ($currentSort === 'asc') ? 'asc' : 'desc' ?>&search=<?= urlencode($searchKeyword) ?>">
        <input class="form-control me-2" type="search" name="search" autocomplete="off" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" placeholder="輸入顧客姓名或訂單編號" aria-label="Search">
        

        <button class="btn btn-primary" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
    <div class="col-12">
      <table class="table table-bordered table-striped table-hover text-center">
        <thead>
          <tr>
            <!-- 追加刪除與新增 -->
            <th>刪除資料 <i class="fa-solid fa-trash-can "></i></th>
            <th class=>#
              <?php
              
              $sortIcon = (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'fa-arrow-up' : 'fa-arrow-down';
              ?>
              <a href="list.php?page=<?= $page ?>&sort=<?= ($currentSort === 'asc') ? 'desc' : 'asc' ?>&search=<?= urlencode($searchKeyword) ?>">
                <i class="fa-solid <?php echo $sortIcon; ?> tz"></i>
              </a>
            </th>
            <th>訂單日期</th>
            <th>訂單編號</th>
            <th>顧客姓名</th>
            <th>付款方式</th>
            <th>訂單總金額</th>
            <th>編輯資料 <i class="fa-solid fa-pen-to-square"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <?php
            // 組合流水編號和日期生成訂單編號
            $orderIDString = strval($r['order_id']);
            $currentDate = date("Ymd", strtotime($r['order_date']));
            $orderNumber = $currentDate . $orderIDString;
            ?>
            <tr>
              <td>
                <!-- 呼叫JS的function -->
                <a href="javascript: delete_one(<?= $r['order_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a>
              </td>
              <td><?= $r['order_id'] ?></td>
              <td><?= $r['order_date'] ?></td>
              <td><?= $orderNumber ?></td>
              <td><?= $r['custom_name'] ?></td>
              <td><?= $r['payment_method'] ?></td>
              <td><?= $r['total_amount'] ?></td>


              <td>
                <a class="text-decoration-none" href="edit.php?order_id=<?= $r['order_id'] ?>">
                  查看更多 <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td>

            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php 
// include __DIR__ . '/parts/scripts.php' 
?>
<!-- 提示刪除的JS -->
<script>
  function delete_one(order_id) {
    if (confirm(`是否要刪除編號為${order_id}的資料`)) {
      location.href = `delete.php?order_id=${order_id}`;
    }
  }
</script>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include __DIR__ . '/parts/html-foot.php'

?>