<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
// require __DIR__ . '/parts/db_connect.php';
$pageName = 'list';
$title = '列表';

$perPage = 6;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  // redirect
  header('Location: ?page=1');
  exit;
}

// $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$t_sql = "SELECT COUNT(1) FROM game_data";
// $t_stmt = $pdo->query($t_sql);
// $row = $t_stmt->fetch(PDO::FETCH_NUM);
$row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);
// print_r($row); exit;  # 直接離開程式
$totalRows = $row[0]; # 取得總筆數
$totalPages = 0; # 預設值
$rows = []; # 預設值

if ($totalRows > 0) {
  $totalPages = ceil($totalRows / $perPage); # 計算總頁數
  if ($page > $totalPages) {
    // redirect
    header('Location: ?page=' . $totalPages);
    exit;
  }
  
  $sql = sprintf("SELECT * FROM game_data ORDER BY level_id ASC
    LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $stmt = $pdo->query($sql);
  $rows = $stmt->fetchAll();
}
?>
<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/game/parts/navbar-game_data.php';
// include __DIR__ . '/parts/html-head.php'  ?>
<?php 

// include __DIR__ . '/parts/navbar-game_data.php'  ?>


<style>
  .table {
    --bs-table-striped-bg: rgba(221, 235, 255, 0.5) !important;
  }
</style>

<div class="container ma-left" >
<h2>遊戲資料</h2>
  <div class="row ">
    <div class="col ">
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
          <li class="page-item ">
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
  <!-- 搜索欄 start -->
    <!-- <div class="row">
          <div class="col">
          <form action="" method="get">
            <label for="search">搜索:</label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit">提交</button>
          </form>
          </div>
    </div>  -->
  <!-- 搜索欄 end-->

   <div class="row ">
    <div class="col ">
      <table class="table table-bordered table-striped ">
        <thead >
          <tr >
            <th><i class="fa-solid fa-trash"></i></th>
            <th>關卡難度</th>
            <th>時限</th>
            <th>通關可獲得點數</th>
            <th>通關需求分數</th>
            
            <th><i class="fa-solid fa-file-pen"></i></th>
          </tr>
        </thead>
        <tbody >
          <?php foreach ($rows as $key =>$r) : ?>
            <tr >
              <td >
                <a href="javascript: delete_one(<?= $r['level_id'] ?>)">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
              <td><?=  $r['level_id'] ?></td>
              <td ><?= $r['time_limit'] ?></td>
              <td ><?= $r['get_point'] ?></td>
              <td ><?= $r['require_score'] ?></td>
            

              <td ><a href="edit-game_data.php?sid=<?= $r['level_id'] ?>">
                  <i class="fa-solid fa-file-pen"></i>
                </a></td>
            </tr>
          <?php endforeach ?>
          
        </tbody>
        
      </table>
      
    </div>

  </div>
  
</div> 


<?php
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
//  include __DIR__ . '/parts/scripts.php'  ?>
<script>
  function delete_one(sid) {
    if (confirm(`是否要刪除關卡難度為 ${sid} 的資料?`)) {
      location.href = `delete-game_data.php?sid=${sid}`;
    }
  }
</script>

<?php
//  include __DIR__ . '/parts/html-foot.php'  ?>