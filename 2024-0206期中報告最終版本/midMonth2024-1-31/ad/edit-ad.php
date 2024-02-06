<?php
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$title = "修改";

$record_id = isset($_GET["record_id"]) ? intval($_GET["record_id"]) : 0;
$sql = "SELECT * FROM ad_record WHERE record_id=$record_id";

$row = $pdo->query($sql)->fetch();

if (empty($row)) {
    header("Location: ad-record.php");
    exit();
}
?>

<?php 

// include "parts/html-head.php"
// include "parts/navbar.php" 

?>

<style>
    .form-text {
        color: red;
    }
</style>

<div class="container my-5 ma-left">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改</h5>
                    <form name="form1" method="post" onsubmit="sendForm(event)">
                        <!-- 給前端看用戶的sid -->
                        <div class="mb-4">
                            <label for="record_id" class="form-label">#</label>
                            <input type="text" class="form-control" disabled value="<?= $row["record_id"] ?>">
                        </div>
                        <!-- 給後端看的sid -->
                        <input type="hidden" name="record_id" value="<?= $row["record_id"] ?>">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="ad_id" class="form-label">廣告位#</label>
                                    <input type="text" class="form-control" id="ad_id" name="ad_id" value="<?= $row["ad_id"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="merchant_Id" class="form-label">商家#</label>
                                    <input type="text" class="form-control" id="merchant_Id" name="merchant_Id" value="<?= $row["merchant_Id"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="start_date" class="form-label">開始日起</label>
                                    <input type="text" class="form-control" id="start_date" name="start_date" value="<?= $row["start_date"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="clicks" class="form-label">點擊率</label>
                                    <input type="text" class="form-control" id="clicks" name="clicks" disabled value="<?= $row["clicks"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="state" class="form-label">狀態</label>
                            <input type="text" class="form-control" id="state" name="state" value="<?= $row["state"] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-4">
                            <p for="ad_image" class="form-label">圖片</p>
                            <img src="public/images/<?= $row["ad_image"] ?>" alt="" id="ad_image" name="ad_image">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">修改</button>
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
                    修改成功
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
                <a type="button" class="btn btn-primary" href="ad-record.php">查看列表頁</a>
            </div>
        </div>
    </div>
</div>

<?php 
// include "parts/scripts.php"
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

    const sendForm = e => {
        e.preventDefault();

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch("edit-ad-api.php", {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json())
                .then(result => {
                    console.log({
                        result
                    });
                    if (result.success) {
                        myModal.show();
                    }
                })
                .catch(ex => console.log(ex));
        }
    };

    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
</script>
<?php 
// include "parts/html-end.php" ?>