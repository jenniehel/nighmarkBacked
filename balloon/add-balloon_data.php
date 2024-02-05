<?php 

// require __DIR__ . '/parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$pageName = 'add';
$title = '新增';

?>
<?php 
 require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
 require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include __DIR__ . '/parts/html-head.php'  ?>
<?php 

// include __DIR__ . '/parts/navbar-balloon_data.php'  ?>
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
          <h5 class="card-title">新增資料</h5>
          <form name="form1" method="post" onsubmit="sendForm(event)" id="form1">
            <div class="mb-3">
              <label for="balloon_id" class="form-label">氣球id</label>
              <input type="text" class="form-control" id="balloon_id" name="balloon_id">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="balloon_type" class="form-label">氣球類型</label>
              <input type="text" class="form-control" id="balloon_type" name="balloon_type">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="broken_score" class="form-label">擊破可獲得分數</label>
              <input type="text" class="form-control" id="broken_score" name="broken_score">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="balloon_speed" class="form-label">移動速度</label>
              <input type="text" class="form-control" id="balloon_speed" name="balloon_speed">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">

              <label for="image" class="form-label">使用圖片</label>

             
                  <input type="file" name="image" id="image" accept="image/*" >
                  <br>
                  <!-- <button type="button" class="btn btn-warning my-2 my-sm-0 text-nowrap" onclick="uploadFile()">上傳</button> 
               </div> -->

            
            
            <button type="submit" class="btn btn-primary" onclick="uploadFile()">新增</button>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Button trigger modal -->
  <!--
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>
-->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a type="button" class="btn btn-primary" href="balloon_data.php">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include __DIR__ . '/parts/scripts.php'  ?>
<script>
  
function uploadFile(){    //上傳圖片
  const fileInput = document.querySelector('input[name="image"]');
    const file = fileInput.files[0];

    if (file) {
      const fd = new FormData();  // 使用 FormData 來構建要上傳的數據

      fd.append('avatar', file);

      fetch('./upload-avatar.php', {
        method: 'POST',
        body: fd,
      })
      .then(response => response.json())
      .then(data => {
        // 處理伺服器的回應，這裡可以根據你的需求進行相應的處理
        console.log(data);
      })
      .catch(error => {
        // 處理錯誤
        console.error('Error:', error);
      });
    } else {
      console.error('No file selected');
    }
}

  const {
    balloon_id: id,
    balloon_type: type,
    broken_score: score,
    balloon_speed: speed,
    image: balloon,
  } = document.form1;

  


  const sendForm = e => {
    e.preventDefault();
    
    speed.style.border = '1px solid #CCC';
    speed.nextElementSibling.innerHTML = "";


    // TODO: 資料送出之前, 要做檢查 (有沒有填寫, 格式對不對)
    let isPass = true; // 表單有沒有通過檢查

    if (balloon_speed.value < 0.1) {
      
      isPass = false;
      speed.style.border = '1px solid red';
      speed.nextElementSibling.innerHTML = "無法設定此速度";
    }


    


    if (isPass) {
      // "沒有外觀" 的表單
      const fd = new FormData(document.form1);

      fetch('add-balloon_data-api.php', {
          method: 'POST',
          body: fd, // content-type: multipart/form-data
        }).then(r => r.json())
        .then(result => {
          console.log({
            result
          });
          if(result.success){
            myModal.show();
          }
        })
        .catch(ex => console.log(ex))
    }


  }

 
  const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
</script>
<?php
//  include __DIR__ . '/parts/html-foot.php'  ?>