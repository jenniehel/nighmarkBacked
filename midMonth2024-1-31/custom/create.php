<?php
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// require __DIR__ . '/../com-parts/db_connect.php';
// require __DIR__ . '/../com-parts/html-head.php';
?>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <div class="body-wrapper">

        <div class="container-fluid">
            <button type="submit" class="btn btn-primary mb-3" onclick="window.location.href='read.php'">回上一頁</button>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">註冊</h5>
                    <div class="card">
                        <div class="card-body">
                            <!-- /*onsubmit="sendForm(event)"*/ -->
                            <form name="form1" class="needs-validation" id="form1" method="post" onsubmit="sendForm(event)">
                                <input type="text" class="doing" name="doing" value="create" style="display: none;">

                                <div class="mb-3">
                                    <label for="customName" class="form-label">姓名</label>
                                    <input type="text" name="customName" onblur="isName()" value="" required class="form-control" id="customName" aria-describedby="customNameHelp" placeholder="請輸入姓名">
                                    <div id="customNameHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="inputId" class="form-label">帳號/暱稱(請輸入英文)</label>
                                    <input type="text" name="inputId" onblur="isId()" class="form-control" value="" required id="InputId" aria-describedby="idHelp" placeholder="請輸入帳號">
                                    <div id="idHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">信箱</label>
                                    <input type="email" onblur="isEmail()" name="email" class="form-control" value="" required id="email" aria-describedby="emailHelp" placeholder="請輸入信箱">
                                    <div id="emailHelp" class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">密碼</label>
                                    <input type="text" onblur="ispassword1()" name="password" class="form-control" value="" required id="password" placeholder="請輸入密碼">
                                    <div id="passwordHelp" class="form-text"></div>

                                </div>
                                <div class="mb-3">
                                    <label for="password2" class="form-label">確認密碼</label>
                                    <input type="text" onblur="ispassword2()" name="password2" class="form-control" value="" id="InputPassword2" required placeholder="請再次輸入密碼">
                                    <div id="passwordHelp2" class="form-text"></div>

                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">大頭貼</label>
                                    <input type="file" id="inputImage" name="myImage" class="form-control mb-1" accept="image/*" />
                                    <input type="text" id="reaultImg" name="reaultImg" style="display: none;" ;>
                                    <img id="img" height="150">
                                </div>


                                <button type="submit" class="btn btn-primary">確定新增</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- include __DIR__ . '/parts/script.php' -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script> -->
<!-- <script src="./assets/libs/jquery/dist/jquery.min.js"></script> -->
<!-- <script src="./assets/js/sidebarmenu.js"></script>
<script src="./assets/js/app.min.js"></script>
<script src="./assets/libs/simplebar/dist/simplebar.js"></script>
<script src="./validate/email.js"></script>
<script src="./validate/id.js"></script>
<script src="./validate/nameAccount.js"></script>
<script src="./validate/password2.js"></script>
<script src="./validate/reset.js"></script> -->
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
  
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/comform.php';


// include  __DIR__ . '/../com-parts/script.php'

?>


<script>

    const {
        doing: doing,
        customName: customName_f,
        inputId: inputId,
        email: email_f,
        password: InputPassword1_f,
        password2: InputPassword2,
        reaultImg: reaultImg,
    } = document.form1;

    let isPass = true;
    let m = {
        isEmail: isPass,
        isName: isPass,
        isId: isPass,
        ispassword1: isPass,
        ispassword2: isPass
    };

    function isEmail() {
        m["isEmail"] = isSetEmail(document.querySelector("#email"))
    };


    function isName() {

        m["isName"] = isSetName(document.querySelector("#customName"));

    }

    function isId() {
        m["isId"] = isSetId(document.querySelector("#InputId"))
    }

    function checkPassword() {

        if (document.querySelector("#InputPassword2").value != document.querySelector("#password").value) {
            document.querySelector("#password").value = null;
            document.querySelector("#InputPassword2").value = null;
            m[ispassword1] = false;
            m[ispassword2] = false;
            return false;

        } else {
            return true;
        }

    }
    let i = 0;
    //  let istrue=true;

    function ispassword1() {
        m["ispassword1"] = true;
        feature.resetData(document.querySelector("#password"));
        m["ispassword1"] = issetPassword(document.querySelector("#password"))


    }



    function ispassword2() {
        m["ispassword2"] = true;
        feature.resetData(document.querySelector("#InputPassword2"));
        m["ispassword2"] = issetPassword(document.querySelector("#InputPassword2"))
    }

    function formReset() {
        // $('#form1')[0].reset();
        //沒用?
        document.getElementsByName("customName")[0].value = null;
        document.getElementsByName("inputId")[0].value = null;
        document.getElementsByName("email")[0].value = null;
        document.getElementsByName("password")[0].value = null;
        document.getElementsByName("password2")[0].value = null;
        document.getElementsByName("myImage")[0].value = null;
        document.querySelector("#img").src = "";
    }

    function blurSet() {
        // $('#form1')[0].reset();
        //沒用?
        document.getElementsByName("customName")[0].blur();
        document.getElementsByName("inputId")[0].blur();
        document.getElementsByName("email")[0].blur();
        document.getElementsByName("password")[0].blur();
        document.getElementsByName("password2")[0].blur();
    }
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        var nsub = true;
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    blurSet();
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    if (nsub) {
                        nsub = checkPassword();
                        isPass = nsub;

                    }
                    isEmail();
                    isName();
                    isId();
                    ispassword1();
                    ispassword2();
                    for (const key of Object.keys(m)) {
                        if (!m[key]) {
                            nsub = false;
                            isPass = false;
                        }
                    }


                    if (nsub) {

                        form.classList.add('was-validated')
                    }

                }, false)
            })

    })()
    let hastxt = true;
    // 判斷是否已有帳戶
    function hasnumber() {
        const fd = new FormData(document.form1);
        fetch('isnumber-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(result => {
                if (result.success) {
                    changeEmail(document.querySelector("#email"));
                    m[isEmail] = false;
                    hastxt = false
                } else {
                    resetEmail(document.querySelector("#email"));
                    m[isEmail] = true;
                    hastxt = true;

                }

            })
            .catch(ex => console.log(ex))
    }
    document.getElementById('email').addEventListener('blur', function(event) {

        if (m["isEmail"]) {
            hasnumber();
        }
    });
    // 圖片顯示
    document.getElementById('inputImage').addEventListener('change', function(event) {
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

    let sendForm = e => {


        // clear();  
        e.preventDefault();
        hasnumber();
        if (isPass & hastxt) {
            isPass = checkPassword();
            if (isPass) {
                // 處理圖片
                const fd = new FormData(document.form1);
                // fetch('create-api.php', {
                fetch('cu-api.php', {
                        method: 'POST',
                        body: fd, // content-type: multipart/form-data
                    }).then(r => r.json())
                    .then(result => {
                        if (result.success) {
                            // location.href = './index_.php';
                            // document.getElementById("form1").reset();
                            formReset();
                            resetEmail(document.querySelector("#email"));
                            isSusccess("新增成功");
                            window.location.href = 'read.php';
                            isPass = false;
                            hastxt = false;
                        } else {
                            // myModal.show();
                            isSusccess("請重新輸入，帳號密碼有誤");

                            document.getElementsByName("password").value = "";
                            document.getElementsByName("password2").value = "";

                        }
                        // isSusccess("50!請重新輸入，帳號密碼有誤");

                    })
                    .catch(ex => console.log(ex))
            } else {
                isSusccess("請檢查輸入欄位內容 ，密碼不一致");
                document.getElementsByName("password")[0].value = "";
                document.getElementsByName("password2")[0].value = "";

            }
        } else {
            isSusccess("請檢查輸入欄位內容");
        }


    }
</script>