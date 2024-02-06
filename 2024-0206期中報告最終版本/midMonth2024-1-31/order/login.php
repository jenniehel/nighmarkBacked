<?php require __DIR__ . '/parts/db connect2.php';
$pageName = "login";
$title = "登入";


if(isset($_SESSION['admin'])){
  header('Location: ./index_.php');
  exit;
  
}

?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
  /* 新增 */
  form .mb-3 .form-text {
    color: red;
  }
</style>
<div class="container ma-left">
  <div class="row">
    <div class="clo-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">會員登入</h5>
          <!-- 表單 -->
          <form name="form1" method="post" onsubmit="sendForm(event)">
            <!-- 新增五欄 -->

            <div class="mb-3">
              <label for="email" class="form-label">Email帳號</label>
              <input type="text" class="form-control" id="email" name="email">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="password">
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">登入</button>
          </form>
        </div><!-- class card-body -->
      </div><!-- class card -->

    </div><!-- class clo6 -->
  </div><!-- class row -->

  <!-- modal的按鈕 -->
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> -->

</div> <!-- container END -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">登入結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          帳號或密碼錯誤
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div><!-- Modal  END-->

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        新增失敗
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a type="button" class="btn btn-primary" href="./list.php">回到列表</a>
      </div>
    </div>
  </div>
</div>Modal  END -->

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const {
    name: name_f,
    email: email_f,
    mobile: mobile_f,
  } = document.form1; //抓到他們三個欄位 賦值

  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }


  const sendForm = e => {
    e.preventDefault();

    //警示恢復預設模樣

    email_f.style.border = "1px solid #CCC";
    email_f.nextElementSibling.innerHTML = "";


    //TODO: 資料送出之前, 要做檢查 (有沒有填寫, 格式對不對)

    let isPass = true;

    //姓名長度

    //如果email欄位有值 且這個值不符合validateEmail的條件
    // if (email_f.value && !validateEmail(email_f.value)) {
    //   isPass = false;
    //   email_f.style.border = "1px solid red";
    //   email_f.nextElementSibling.innerHTML = "請填寫Email正確格式";
    // }




    //如果isPass為true 則送出表單
    if (isPass) {
      // "沒有外觀"的表單
      const fd = new FormData(document.form1);

      fetch('login-api.php', {
          method: 'POST',
          body: fd, //表單會自動是content-type: multipart/form-data
        }).then(r => r.json()) //改為json
        .then(result => {
          console.log({
            result
          });
          if (result.success) {
            location.href = './index_.php';
          }else{
            myModal1.show();
          }
        }).catch(ex => console.log(ex)) //除錯用
    }
    // myModal2.show();
  }

  // bootstrap modal Via JavaScript
  const myModal1 = new bootstrap.Modal(document.getElementById('exampleModal'));

</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>