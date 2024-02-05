<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$pageName = 'list';
$title = '列表';

$perPage = 20;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  // redirect
  header('Location: ?page=1');
  exit;
}


$t_sql = "SELECT COUNT(1) FROM clear_data";
// $t_stmt = $pdo->query($t_sql);
// $row = $t_stmt->fetch(PDO::FETCH_NUM);
$row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);
// print_r($row); exit;  # 直接離開程式
$totalRows = $row[0]; # 取得總筆數
$totalPages = 0; # 預設值
$rows = []; # 預設值
$performSearch=[];


if ($totalRows > 0) {
  $totalPages = ceil($totalRows / $perPage); # 計算總頁數
  if ($page > $totalPages) {
    // redirect
    header('Location: ?page=' . $totalPages);
    exit();
  }
    // if ($totalRows > 0) {
    //   $totalPages = ceil($totalRows / $perPage); # 計算總頁數
    //   if ($page > $totalPages) {
    //     // redirect
    //     header('Location: ?page=' . $totalPages);
    //     exit;
  
  $searchKeyword = isset($_POST['search']) ? trim($_POST['search']) : '' ;

  if(!empty($searchKeyword)){
    $performSearch=true;
  }

  if($performSearch){
    $sql = sprintf("SELECT * FROM clear_data WHERE user_id= $searchKeyword ");
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
  

  }else{
  $sql = sprintf("SELECT * FROM clear_data ORDER BY clear_id ASC
    LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $stmt = $pdo->query($sql);
  $rows = $stmt->fetchAll();
       }

}
?>
<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include __DIR__ . '/parts/html-head.php'  ?>
<?php 
// include __DIR__ . '/parts/navbar-clear_data.php'  ?>


<style>
  .table {
    --bs-table-striped-bg: rgba(221, 235, 255, 0.5) !important;
  }
</style>

<div class="container">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) : ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>
        </ul>
      </nav>

      
    </div>
  </div>

<div class="col-12 col-md-6 mt-3 mb-3">
      <form class="d-flex" method="post" action="clear_data.php">
          <input type="search" class="form-control me-2" name="search" placeholder="查詢顧客id" aria-label="Search"  >

          <button class="btn btn-primary" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
          </button>
      </form>

</div>
  
      

 <br>

  <!-- <input type="text" class="form-control" id="image" name="image" > -->

  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            
            <th>通關id</th>
            <th>關卡難度</th>
            <th>顧客id</th>
            <th>遊玩日期</th>
            
           
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              
              <td class="alert alert-info"><?= $r['clear_id'] ?></td>
              <td><?= $r['level_id'] ?></td>
              <td><?= $r['user_id'] ?></td>
              <td><?= $r['play_date'] ?></td>
            
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

      

    </div>
  </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include __DIR__ . '/parts/scripts.php'  ?>
<script>
  function delete_one(sid) {
    if (confirm(`是否要刪除通關id為 ${sid} 的資料?`)) {
      location.href = `delete.php?sid=${sid}`;
    }
  }
</script>
<?php 
// include __DIR__ . '/parts/html-foot.php'  ?>