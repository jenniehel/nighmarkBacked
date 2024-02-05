<?php
// include "parts/html-head.php" 
//  include "parts/navbar.php"  
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$pageName = "add-ad";
$title = "新增";
?>



<style>
    .form-text {
        color: red;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增</h5>
                    <form name="form1" method="post" onsubmit="sendForm(event)" enctype="multipart/form-data">
                        <!-- 給前端看用戶的sid -->
                        <div class="mb-4">
                            <label for="record_id" class="form-label">#</label>
                            <input type="text" class="form-control">
                        </div>
                        <!-- 給後端看的sid -->
                        <input type="hidden" name="record_id">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="ad_id" class="form-label">廣告位#</label>
                                    <input type="text" class="form-control" id="ad_id" name="ad_id" autocomplete="off">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="merchant_id" class="form-label">商家#</label>
                                    <input type="text" class="form-control" id="merchant_id" name="merchant_id" autocomplete="off">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="start_date" class="form-label">開始日起</label>
                                    <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off" placeholder="預設日期為當下">
                                    <div class="form-text"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="state" class="form-label">狀態</label>
                                    <select class="form-select" name="state" id="state" required aria-label="Default select example">
                                        <option selected disabled>請選擇</option>
                                        <option value="1">上架</option>
                                        <option value="2">下架</option>
                                    </select>
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="ad_image" class="form-label">圖片</label>
                            <input type="file" class="form-control" id="ad_image" name="ad_image" accept="ad_image/*" onchange="uploadFile(this)">
                            <div class="form-text"></div>
                        </div>

                        <div style="width: 300px" class="mb-4">
                            <img src="" alt="" id="myimg" width="100%" />
                        </div>

                        <button type="submit" class="btn btn-primary">送出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    新增成功
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
                <a type="button" class="btn btn-primary" href="ad-record.php">查看列表頁</a>
            </div>
        </div>
    </div>
</div>

<?php
//  include "parts/scripts.php" 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
 ?>
<script>
    let isPass = true;

    function checkNum(num) {
        return !isNaN(num);
    }

    function checkDate(num) {
        var re = /^\d{4}-\d{2}-\d{2}$/;
        return re.test(num);
    }

    $("#ad_id, #merchant_id").blur(function() {
        if (this.value && !checkNum(this.value)) {
            isPass = false;
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "僅能輸入數字";
        } else if (this.value == "") {
            isPass = false;
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "僅能輸入數字";
        } else {
            this.style.border = '';
            this.nextElementSibling.innerHTML = "";
        }
    })

    $("#start_date").blur(function() {
        let dateVal = this.value;

        let parts = dateVal.split('-');
        let year = parseInt(parts[0]);
        let month = parseInt(parts[1]);
        let day = parseInt(parts[2]);
        let newDate = new Date(year, month - 1, day);

        if (this.value && !checkDate(this.value)) {
            isPass = false;
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "輸入格式為YYYY-MM-DD";
        } else if (newDate.getFullYear() === year && newDate.getMonth() === month - 1 && newDate.getDate() === day) {
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "請輸入正確日期";
        } else {
            this.style.border = '';
            this.nextElementSibling.innerHTML = "";
        }
    })

    function uploadFile(input) {
        const fileInput = input;
        const preview = document.getElementById("myimg");
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    const sendForm = e => {
        e.preventDefault();

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch("add-ad-api.php", {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json())
                .then(result => {
                    console.log({
                        result
                    });
                    if (result.success) {
                        myModal.show();
                        document.getElementById("myimg").src = "public/upload/" + result.file;
                    }
                })
                .catch(ex => console.log(ex));
        }
    };

    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
</script>
<?php
//  include "parts/html-end.php"
  ?>