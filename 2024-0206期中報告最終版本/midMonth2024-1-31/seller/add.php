<?php
// 導入資料庫連線
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$pageName = "add";
$title = "新增";

// include __DIR__ . "/components/head.php";
?>

<style>
    form .mb-3 .form-text {
        color: red;
    }

    .is-invalid {
        border: 1px solid red;
    }

    #timeError {
        color: red;
    }
</style>

<div class="container mt-3 ma-left">
    <h2>新增賣家資料</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">新增資料</h5>
                    <form name="form1" onsubmit="sendForm(event)" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="name" class="form-label">攤位名稱</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="攤位名稱">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">公司名稱</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                placeholder="公司名稱">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="電子信箱">
                            <div class="form-text">該欄位必填，且必須符合正確的電子郵件格式</div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">攤位地址</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="攤位地址">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">上傳圖片</label>
                            <input type="file" class="form-control" id="image_url" name="image_url">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="introduction" class="form-label">攤位簡介</label>
                            <textarea class="form-control" id="introduction" name="introduction" rows="3"
                                placeholder="攤位簡介"></textarea>
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">連絡電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="連絡電話">
                            <div class="form-text">該欄位必填，且必須符合正確的電話號碼格式</div>
                        </div>

                        <div class="business-hours-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="select-container">
                                        <label for="business_hours_start">開始時間：</label>
                                        <select name="business_hours_start" id="business_hours_start">
                                            <?php
                                            // 產生 24 小時的選項
                                            for ($i = 0; $i < 24; $i++) {
                                                $startHour = sprintf("%02d", $i);
                                                echo "<option value='$startHour'>$startHour:00</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="select-container">
                                        <label for="business_hours_end">結束時間：</label>
                                        <select name="business_hours_end" id="business_hours_end">
                                            <?php
                                            // 產生 24 小時的選項
                                            for ($i = 0; $i < 24; $i++) {
                                                $endHour = sprintf("%02d", $i);
                                                echo "<option value='$endHour'>$endHour:00</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="timeError" class="form-text"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">新增資料</button>
                            </div>

                            <div class="mt-1">
                                <a href="list.php">回到產品列表</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 添加 Bootstrap Modal 部分 -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">成功提示</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="successModalBody">
                <!-- 提示框內容 -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="continueEditingButton">繼續編輯</button>
                <button type="button" class="btn btn-primary" id="redirectToButton">回列表</button>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    document.forms.form1.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // 阻止表單提交
        }
    });

    function validateForm() {
        let isValid = true;

        // Reset styles
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid');
        });
        document.querySelectorAll('.form-text').forEach(errorMsg => {
            errorMsg.innerText = '';
        });

        // Validate each field
        if (document.forms.form1.name.value.trim() === '') {
            document.forms.form1.name.classList.add('is-invalid');
            document.forms.form1.name.nextElementSibling.innerText = '該欄位必填';
            isValid = false;
        }

        if (document.forms.form1.company_name.value.trim() === '') {
            document.forms.form1.company_name.classList.add('is-invalid');
            document.forms.form1.company_name.nextElementSibling.innerText = '該欄位必填';
            isValid = false;
        }

        // Validate email using a simple regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(document.forms.form1.email.value.trim())) {
            document.forms.form1.email.classList.add('is-invalid');
            document.forms.form1.email.nextElementSibling.innerText = '該欄位必填，且必須符合正確的電子郵件格式';
            isValid = false;
        }

        if (document.forms.form1.address.value.trim() === '') {
            document.forms.form1.address.classList.add('is-invalid');
            document.forms.form1.address.nextElementSibling.innerText = '該欄位必填';
            isValid = false;
        }

        if (document.forms.form1.image.value.trim() === '') {
            document.forms.form1.image.classList.add('is-invalid');
            document.forms.form1.image.nextElementSibling.innerText = '該欄位必填';
            isValid = false;
        }

        if (document.forms.form1.introduction.value.trim() === '') {
            document.forms.form1.introduction.classList.add('is-invalid');
            document.forms.form1.introduction.nextElementSibling.innerText = '該欄位必填';
            isValid = false;
        }

        // Validate phone using a simple regex
        const phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(document.forms.form1.phone.value.trim())) {
            document.forms.form1.phone.classList.add('is-invalid');
            document.forms.form1.phone.nextElementSibling.innerText = '該欄位必填，且必須符合正確的電話號碼格式';
            isValid = false;
        }

        // Validate business hours
        const startHour = parseInt(document.forms.form1.business_hours_start.value, 10);
        const endHour = parseInt(document.forms.form1.business_hours_end.value, 10);

        if (startHour >= endHour) {
            document.getElementById('timeError').innerText = '開始營業時間必須比結束營業時間早';
            isValid = false;
        }

        return isValid;
    }
</script> -->
<script>

    function sendForm(event) {
        event.preventDefault(); // 阻止表單提交
        let formData = new FormData(document.forms.form1);
        // 獲取表單數據
        function validateForm() {
            let isValid = true;

            // Reset styles
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });
            document.querySelectorAll('.form-text').forEach(errorMsg => {
                errorMsg.innerText = '';
            });

            // Validate each field
            if (document.forms.form1.name.value.trim() === '') {
                document.forms.form1.name.classList.add('is-invalid');
                document.forms.form1.name.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }

            if (document.forms.form1.company_name.value.trim() === '') {
                document.forms.form1.company_name.classList.add('is-invalid');
                document.forms.form1.company_name.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }

            // Validate email using a simple regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(document.forms.form1.email.value.trim())) {
                document.forms.form1.email.classList.add('is-invalid');
                document.forms.form1.email.nextElementSibling.innerText = '該欄位必填，且必須符合正確的電子郵件格式';
                isValid = false;
            }

            if (document.forms.form1.address.value.trim() === '') {
                document.forms.form1.address.classList.add('is-invalid');
                document.forms.form1.address.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }

            if (document.forms.form1.introduction.value.trim() === '') {
                document.forms.form1.introduction.classList.add('is-invalid');
                document.forms.form1.introduction.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }

            // Validate phone using a simple regex
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(document.forms.form1.phone.value.trim())) {
                document.forms.form1.phone.classList.add('is-invalid');
                document.forms.form1.phone.nextElementSibling.innerText = '該欄位必填，且必須符合正確的電話號碼格式';
                isValid = false;
            }

            // Validate business hours
            const startHour = parseInt(document.forms.form1.business_hours_start.value, 10);
            const endHour = parseInt(document.forms.form1.business_hours_end.value, 10);

            if (startHour >= endHour) {
                document.getElementById('timeError').innerText = '開始營業時間必須比結束營業時間早';
                isValid = false;
            }

            return isValid;
        }
        // 添加 fetch 到 validateForm 內
        if (validateForm()) {
            // 使用 fetch 進行提交
            fetch('add-api.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // 處理伺服器返回的數據
                    if (data.success) {
                        // 添加成功，顯示提示框
                        showAlert('新增成功', function () {
                            // 繼續編輯，清除表單
                            document.forms.form1.reset();
                        }, function () {
                            // 跳轉回列表
                            window.location.href = data.redirect;
                        });
                    } else {
                        // 添加失敗，處理錯誤信息
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error during fetch:', error);
                });
        }

        function showAlert(message, continueEditingCallback, redirectToCallback) {
            // 使用 Bootstrap 的 Modal 顯示提示框
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            var modalBody = document.getElementById('successModalBody');
            var continueEditingButton = document.getElementById('continueEditingButton');
            var redirectToButton = document.getElementById('redirectToButton');

            modalBody.innerText = message;

            continueEditingButton.addEventListener('click', function () {
                modal.hide();
                continueEditingCallback();
            });

            redirectToButton.addEventListener('click', function () {
                modal.hide();
                redirectToCallback();
            });

            modal.show();
        }
    }
</script>


<?php
//  include __DIR__ . "/components/scripts.php"
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
  ?>