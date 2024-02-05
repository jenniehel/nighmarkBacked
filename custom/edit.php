<?php
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// $pageName = 'edit';
// $title = '編輯';

$custom_Id = isset($_GET['custom_Id']) ? intval($_GET['custom_Id']) : 0;
$sql = "SELECT * FROM custom WHERE custom_Id=$custom_Id";

$row = $pdo->query($sql)->fetch();
$imageData = $row['custom_image'];

if (empty($row)) {
    header('Location: list.php');
    exit; # 結束 php 程式
}


?>
<style>
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-fluid,
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-lg,
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-md,
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-sm,
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-xl,
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper>.container-xxl {
        padding-top: 2rem;
    }
</style>

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->

    <!--  Sidebar End -->
    <div class="body-wrapper">
        <div class="container-fluid">
            <button type="submit" class="btn btn-primary mb-3" onclick="window.location.href='read.php'">回上一頁</button>
            <!--  Main wrapper -->

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">修改</h5>
                    <div class="card">
                        <div class="card-body">
                            <!-- /*onsubmit="sendForm(event)"*/ -->
                            <form name="form1" class="needs-validation" id="form1" method="post" onsubmit="sendForm(event)" enctype="multipart/form-data">
                                <input type="text" class="doing" name="doing" value="update" style="display: none;">
                                <input type="text" class="custom_Id" name="custom_Id" value="<?= htmlentities($row['custom_Id']) ?>" style="display: none;">

                                <div class="mb-3">
                                    <label for="customName" class="form-label">姓名</label>
                                    <input type="text" onblur="isName()" value="<?= htmlentities($row['custom_name']) ?>" name="customName" class="form-control" id="customName" aria-describedby="customNameHelp" placeholder="請輸入姓名">
                                    <div id="customNameHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="inputId" class="form-label">帳號/暱稱(請輸入英文)</label>
                                    <input type="text" onblur="isId()" value="<?= htmlentities($row['custom_account']) ?>" name="inputId" class="form-control" id="InputId" aria-describedby="idHelp" placeholder="請輸入帳號">
                                    <div id="idHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">信箱</label>
                                    <input type="email" onblur="isEmail()" value="<?= htmlentities($row['custom_email']) ?>" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="請輸入信箱">
                                    <div id="emailHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">密碼</label>
                                    <input type="password" onblur="ispassword1()" value="<?= htmlentities($row['custom_password']) ?>" name="password" class="form-control" id="password" placeholder="請輸入密碼">
                                    <div id="passwordHelp" class="form-text"></div>

                                </div>
                                <div class="mb-3">
                                    <label for="password2" class="form-label">確認密碼</label>
                                    <input type="text" onblur="ispassword2()" name="password2" class="form-control" value="<?= htmlentities($row['custom_password']) ?>" id="InputPassword2" required placeholder="請再次輸入密碼">
                                    <div id="passwordHelp2" class="form-text"></div>

                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-3">
                                    <label for="authorId" class="form-label mb-0">是否黑名單</label>
                                    <!--  -->
                                    <div>
                                          <input type="radio" id="authBadYes" name="custom_authorId" value="0" <?php echo htmlentities($row['custom_authorId']) == "0" ? "checked" : "" ?>>
                                          <label for="authBadYes">是的</label><br>

                                    </div>
                                    <div>
                                          <input type="radio" id="authBadNO" name="custom_authorId" value="1" <?php echo htmlentities($row['custom_authorId']) == "1" ? "checked" : "" ?>>
                                          <label for="authBadNO">不是</label>
                                        <div id="authorIdHelp" class="form-text"></div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">大頭貼</label>

                                    <input type="file" name="myImage" id="myImage" class="form-control" accept="image/png, image/gif, image/jpeg" />
                                    <input type="text" id="reaultImg" name="reaultImg" style="display: none">
                                    <!-- <input type="text" id="disabledTextInput" class="form-control" placeholder="請"> -->
                                    <?php

                                    if ($imageData != "") {
                                        echo '<img id="img" src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Uploaded Image" style="max-width: 150px;">';
                                    } else {
                                        echo "  <img id='img' style='max-width: 150px;'>";
                                    } ?>

                                </div>


                                <button type="submit" class="btn btn-primary submit" disabled>確定修改</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


</div>


<?php
// include  __DIR__ . '/assets/js/script.php'
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/comform.php';

?>
<script>
    const {
        custom_Id: custom_Id,
        doing: doing,
        customName: customName_f,
        inputId: inputId,
        email: email_f,
        password: InputPassword1_f,
        custom_authorId: custom_authorId,
        myImage: myImage,
    } = document.form1;

    let isPass = true;
    let ischange = false;
    let m = {
        isEmail: isPass,
        isName: isPass,
        isId: isPass,
        custom_authorId: isPass,
        ispassword1: isPass,
        ispassword2: isPass,
        myImage: isPass
    };
    // 把第一次資料都存起來
    let formElement = document.getElementById('form1');
    // 2 姓名  customName  console.log(formElement[2].value);
    // 3 帳號/暱稱(請輸入英文) inputId  console.log(formElement[3].value);
    // 4 信箱 email console.log(formElement[4].value);
    // 5 密碼 password console.log(formElement[5].value);
    // 6 確認密碼 password2 console.log(formElement[6].value);
    // 7 是否黑名單 console.log(formElement[7].value);
    // 8 大頭貼 myImage console.log(formElement[10].value);


    let formValue = {
        customName: formElement[2].value,
        inputId: formElement[3].value,
        email: formElement[4].value,
        password: formElement[5].value,
        password2: formElement[6].value,
        custom_authorId: formElement[7].value,
        account: formElement[8].value,
        myImage: formElement[10].value,

    };
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        let issub = true;
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    for (const key of Object.keys(m)) {
                        if (!m[key]) {
                            console.log(key)
                            issub = false;
                        }
                    }

                    if (issub) {
                        form.classList.add('was-validated')
                    }


                }, false)
            })

    })()

    document.getElementById('myImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            const base64 = reader.result;
            // document.getElementById('outputBase64').value = base64;
            document.querySelector("#img").src = base64;
            document.querySelector("#reaultImg").value = base64;

        };

        reader.readAsDataURL(file);
    });

    function isEmail() {
        if (document.querySelector("#email") == formValue.email) {
            m["isEmail"] = false;
        }
        if (m["isEmail"]) {
            m["isEmail"] = isSetEmail(document.querySelector("#email"))
        }
    };


    function isName() {
        if (document.querySelector("#customName") == formValue.email) {
            m["isName"] = false;
        }
        if (m["isName"]) {
            m["isName"] = isSetName(document.querySelector("#customName"))
        }
        // m["isName"] = isSetName(document.querySelector("#customName"));

    }

    function isId() {
        m["isId"] = isSetId(document.querySelector("#InputId"))
    }

    function ispassword1() {
        m["ispassword1"] = true;
        feature.resetData(document.querySelector("#password"));
        m["ispassword1"] = issetPassword(document.querySelector("#password"))
        if (document.querySelector("#password").value != document.querySelector("#InputPassword2").value) {
            document.querySelector("#password").style.border = '1px solid red';
            document.querySelector("#password").nextElementSibling.innerHTML = "請密碼不一致";
            m["ispassword1"] = false;
        } else {
            m["ispassword1"] = true;
            m["ispassword2"] = true;
            feature.resetData(document.querySelector("#InputPassword2"));
            feature.resetData(document.querySelector("#password"));

        }

    }

    function ispassword2() {
        m["ispassword2"] = true;
        feature.resetData(document.querySelector("#InputPassword2"));
        m["ispassword2"] = issetPassword(document.querySelector("#InputPassword2"))
        if (document.querySelector("#password").value != document.querySelector("#InputPassword2").value) {
            document.querySelector("#InputPassword2").style.border = '1px solid red';
            document.querySelector("#InputPassword2").nextElementSibling.innerHTML = "請密碼不一致";
            m["ispassword2"] = false;

        } else {
            m["ispassword1"] = true;
            m["ispassword2"] = true;
            feature.resetData(document.querySelector("#InputPassword2"));
            feature.resetData(document.querySelector("#password"));

        }
    }

    function formReset() {
        // $('#form1')[0].reset();
        //沒用?
        document.getElementsByName("customName").value = null;
        document.getElementsByName("inputId").value = null;
        document.getElementsByName("email").value = null;
        document.getElementsByName("password").value = null;
        document.getElementsByName("password2").value = null;
        document.getElementsByName("myImage").value = null;
    }
    $("#form1 :input").change(function() {
        ischange = true;
        $('.submit').prop('disabled', false);
    })

    let sendForm = e => {
        // clear(); 
        // formReset();
        e.preventDefault();

        isPass = true;

        for (const key of Object.keys(m)) {
            if (!m[key]) {
                console.log(key)
                isPass = false;
            }
        }

        if (isPass && ischange) {
            // form.classList.add('was-validated');
            // "沒有外觀" 的表單
            const fd = new FormData(document.form1);
            // fetch('create-api.php', {
            fetch('cu-api.php', {
                    method: 'POST',
                    body: fd, // content-type: multipart/form-data
                }).then(r => r.json())
                .then(result => {
                    console.log({
                        result
                    });
                    if (result.success) {
                        // location.href = './index_.php';
                        // document.getElementById("form1").reset();
                        // window.location.href = 'read.php';
                        isSusccess("修改成功!!");

                    } else {
                        // myModal.show();
                        isSusccess("請重新輸入，內容有誤");

                    }

                    formReset();
                })
            // .catch(ex => console.log(ex))
        } else {
            isSusccess("請檢查輸入欄位內容");

        }


    }
</script>