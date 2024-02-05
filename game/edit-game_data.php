<?php 


// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$pageName = 'edit';
$title = '編輯';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT * FROM game_data WHERE level_id=$sid";

$row = $pdo->query($sql)->fetch();

// empty($row)
 if (empty($row)) {  
  header('Location: game_data.php');
  exit; # 結束 php 程式
}
 

?>
 <?php
 require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
 require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
//  include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/game/parts/navbar-game_data.php';
 
//  include __DIR__ . '/parts/html-head.php'  ?>
<?php 

// include __DIR__ . '/parts/navbar-game_data.php'  ?> 
<style>
  form .mb-3 .form-text {
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">編輯資料</h5>
          <form name="form1" method="post" onsubmit="sendForm(event)">
            <div class="mb-3">
              <label class="form-label">關卡難度</label>
              <input type="text" class="form-control" id="level_id" name="level_id" disabled value="<?= $row['level_id'] ?>">
            </div>
            <input type="hidden" name="level_id" value="<?= $row['level_id'] ?>">
            <div class="mb-3">
              <label for="time_limit" class="form-label">時間限制</label>
              <input type="text" class="form-control" id="time_limit" name="time_limit" value="<?= $row['time_limit'] ?>">
              <!-- htmlentities() 將特殊字串轉換為html字串-->
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="get_point" class="form-label">可獲得點數</label>
              <input type="text" class="form-control" id="get_point" name="get_point" value="<?= $row['get_point'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="require_score" class="form-label">通關需求分數</label>
              <input type="text" class="form-control" id="require_score" name="require_score" value="<?= $row['require_score'] ?>">
              <div class="form-text"></div>
            </div>
            
            <button type="submit" class="btn btn-primary">修改</button>
          </form>

        </div>
      </div>
    </div>
  </div>


</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">編輯結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          編輯成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        <a type="button" class="btn btn-primary" href="game_data.php">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php
 include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include __DIR__ . '/parts/scripts.php'  ?>
<script>
  const {
    level_id: level,
    time_limit: limit,
    get_point: point,
    require_score: score,
  } = document.form1;
// const level = document.querySelector('[name="level_id"]');
// const limit = document.querySelector('[name="time_limit"]');
// const point = document.querySelector('[name="get_point"]');
// const score = document.querySelector('[name="require_score"]');

  


  const sendForm = e => {
    e.preventDefault();
    
    limit.style.border = '1px solid #CCC';
    limit.nextElementSibling.innerHTML = "";
    

    let isPass = true;

    

    if (limit.value < 10 ) {
      // alert("請填寫正確的姓名");
      isPass = false;
      limit.style.border = '1px solid red';
      limit.nextElementSibling.innerHTML = "時間限制太短了";
    }

   



    

    if (isPass) {
      // "沒有外觀" 的表單
      const fd = new FormData(document.form1);

      fetch('edit-game_data-api.php', {
          method: 'POST',
          body: fd, // content-type: multipart/form-data
        }).then(r => r.json())
        .then(result => {
          console.log({
            result
          });
          if (result.success) {
            myModal.show();
          }
        })
        .catch(ex => console.log(ex))
    }


  }

  const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
</script>
<?php 
// include __DIR__ . '/parts/html-foot.php'  ?>