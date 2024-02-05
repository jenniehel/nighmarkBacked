<?php require __DIR__ . '/com-parts/db_connect.php';

$pageName = "login";
$title = "登入";
if (isset($_SESSION["admin"])) {
  header("location: ./read.php");
  exit;
}
?>


</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- CSS only -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <style>
    form .mb-3 .form-text {
      color: red;
    }

    body {
      width: 100vw;
      height: 100vh;
    }
  </style>
</head>

<body class="d-flex flex-column  " style="width: 100vw;height: 100vh;">
  <!-- JavaScript Bundle with Popper -->

  <div class="card mx-auto my-auto" style="width: 20rem;height: 25rem; ">
    <div class="card-body">
      <h5 class="card-title color-primary">歡迎來到夜市小吃</h5>
      <p class="card-text">請先登入你的帳戶!!!</p>
      <!-- form -->
      <form name="form1" class="needs-validation" method="post" onsubmit="sendForm(event)">
        <div class="  mb-3 d-grid gap-2">
          <label for="bg_email" class="form-label">帳號/email</label>
          <input type="text" class="form-control" id="bg_email" name="bg_email" onblur="isEmail()" placeholder="請輸入帳號" required>
          <div class="form-text"></div>
        </div>
        <div class="mb-3 d-grid gap-2">
          <label for="bg_password" class="form-label">password</label>
          <input type="text" class="form-control" id="bg_password" name="bg_password" placeholder="請輸入密碼" required>
          <div class="form-text"></div>
        </div>
        <div class="text-end d-grid gap-2">
          <input type="submit" class="btn btn-primary" value="登入">
        </div>
        <!-- <?php echo password_hash("123", PASSWORD_DEFAULT); ?> -->
      </form>
    </div>
  </div>
  </div>
  <?php include __DIR__ . '/com-parts/comform.php'; ?> 
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="./assets/js/dashboard.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./validate/email.js"></script>
  <script src="./validate/id.js"></script>
  <script src="./validate/nameAccount.js"></script>
  <script src="./validate/password2.js"></script>
  <script src="./validate/reset.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }


          }, false)
        })
    })()

    const {
      name: name_f,
      bg_email: email_f,
      bg_password: password_f
    } = document.form1;

    var isPass = true;

    function isEmail() {
      if (document.querySelector("#bg_email").value.indexOf("@") == -1) {
        if (email_f.value.length < 2) {
          isPass = false;
          email_f.style.border = '1px solid red';
          email_f.nextElementSibling.innerHTML = "帳號密碼有誤，請重新輸入";
        } else {
          isPass = true;
          feature.resetData(email_f);
        }
      } else {
        // 使用email登入
        isPass = isSetEmail(document.querySelector("#bg_email"))
      };
    }
    const sendForm = e => {
      e.preventDefault();

      if (isPass) {
        const fd = new FormData(document.form1);

        fetch("login-api.php", {
          method: "POST",
          body: fd,
        }).then(r => r.json()).
        then(result => {
          console.log({
            result
          })

          if (result.success) {
            // isset($_SESSION["admin"];
            location.href = "./html/main.php";
            // isset($_SESSION["admin"];
          } else {
            // myModal.show();
            email_f.style.border = '1px solid red';
            email_f.nextElementSibling.innerHTML = "帳號密碼有誤，請重新輸入";
            isSusccess("請重新輸入，帳號密碼有誤");
          }

        }).catch(ex => {
          console.log(ex)
        })
      }

    }
    // const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
  </script>
 