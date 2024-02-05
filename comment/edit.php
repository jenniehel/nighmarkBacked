<?php
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$title = "修改";

$comment_id = isset($_GET["comment_id"]) ? intval($_GET["comment_id"]) : 0;
$sql = "SELECT * FROM comment WHERE comment_id=$comment_id";
$subSql = "SELECT sub_comment.content AS sub_content FROM `comment` LEFT JOIN sub_comment ON sub_comment.comment_id = comment.comment_id WHERE comment.comment_id = $comment_id";


$row = $pdo->query($sql)->fetch();
$subSqlRow = $pdo->query($subSql)->fetch();
$subValue = isset($subSqlRow["sub_content"]) ? $subSqlRow["sub_content"] : "";

if (empty($row)) {
    header("Location: comment.php");
    exit();
}
?>

<?php 
// include "parts/html-head.php" ?>
<?php 
// include "parts/navbar.php" ?>

<style>
    textarea {
        text-align: justify;
    }

    .form-text {
        color: red;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改</h5>
                    <form name="form1" method="post" onsubmit="sendForm(event)">
                        <!-- 給前端看用戶的sid -->
                        <div class="mb-4">
                            <label for="comment_id" class="form-label">#</label>
                            <input type="text" class="form-control" disabled value="<?= $row["comment_id"] ?>">
                        </div>
                        <!-- 給後端看的sid -->
                        <input type="hidden" name="comment_id" value="<?= $row["comment_id"] ?>">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="custom_id" class="form-label">會員#</label>
                                    <input type="text" class="form-control" id="custom_id" name="custom_id" value="<?= $row["custom_id"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="merchant_id" class="form-label">商家#</label>
                                    <input type="text" class="form-control" id="merchant_id" name="merchant_id" value="<?= $row["merchant_id"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="service_rating" class="form-label">服務評分</label>
                                    <input type="text" class="form-control" id="service_rating" name="service_rating" value="<?= $row["service_rating"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="product_ratings" class="form-label">商品評分</label>
                                    <input type="text" class="form-control" id="product_ratings" name="product_ratings" value="<?= $row["product_ratings"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">評論內容</label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?= $row["content"] ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-4">
                            <label for="subContent" class="form-label">店家回覆</label>
                            <textarea class="form-control" name="subContent" id="subContent" cols="30" rows="4" disabled><?= is_null($subValue) ? 'NULL' : $subValue ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="recommend_food" class="form-label">推薦餐點</label>
                            <input type="text" class="form-control" id="recommend_food" name="recommend_food" value="<?= $row["recommend_food"] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="parking" class="form-label">停車</label>
                                    <input type="text" class="form-control" id="parking" name="parking" value="<?= $row["parking"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-4">
                                    <label for="date" class="form-label">發表日期</label>
                                    <input type="text" class="form-control" id="date" name="date" value="<?= $row["date"] ?>">
                                    <div class="form-text"></div>
                                </div>
                            </div>
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
                <a type="button" class="btn btn-primary" href="comment.php">查看列表頁</a>
            </div>
        </div>
    </div>
</div>

<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include "parts/scripts.php" ?>
<script>
    let isPass = true;

    function checkNum(num) {
        return !isNaN(num);
    }

    function checkRatings(num) {
        var re = /^[1-5]$/;
        return re.test(num);
    }

    function checkDate(num) {
        var re = /^\d{4}-\d{2}-\d{2}$/;
        return re.test(num);
    }

    $("#custom_id, #merchant_id").blur(function() {
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

    $("#service_rating, #product_ratings").blur(function() {
        if (this.value && !checkRatings(this.value)) {
            isPass = false;
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "僅能輸入 1 到 5 之間的數字";
        } else if (this.value == "") {
            isPass = false;
            this.style.border = '1px solid red';
            this.nextElementSibling.innerHTML = "僅能輸入 1 到 5 之間的數字";
        } else {
            this.style.border = '';
            this.nextElementSibling.innerHTML = "";
        }
    })

    $("#date").blur(function() {
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

            fetch("edit-api.php", {
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