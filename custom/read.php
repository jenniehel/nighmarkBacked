<?php
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
// require __DIR__ . '/../com-parts/db_connect.php';
// require __DIR__ . '/../com-parts/html-head.php';
?>
<link rel="stylesheet" href="./read.css">
<style>
    .page-link {
        height: 40px;
    }

    ul li i {
        transform: translate(0px, 5px);
    }

    .fa-airbnb {
        color: blue;
        font-weight: 500;
    }

    button a {
        text-decoration: none !important;
        color: white;

    }

    .bg-title {
        background-color: rgb(40, 40, 197);
    }

    .bg-add {
        background-color: rgb(65, 7, 173);
    }

    table th,
    table td {
        padding: 2px;

    }

    .password {
        max-width: 3rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: start;
        padding: 0;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
    }
    .left-270{
        margin-left: 270px;
    }
</style>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/comform.php';
// include __DIR__ . '/../parts/comform.php'; 
?>

<?php
$pageName = 'list';
$title = '列表';

$perPage = 5;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// $name = isset($_GET['name']) ? intval($_GET['name']) : ;
if ($page < 1) {
    // redirect
    header('Location: ?page=1');
    exit;
}

if (isset($_GET['name']) and isset($_GET["value"])) {
    $totalPages = 1; # 預設值
    $nameV = $_GET['name'];
    $value="%".$_GET["value"]."%";
    $t_sql = "SELECT COUNT(1) FROM `custom` WHERE  $nameV like ?";
    $stmt = $pdo->prepare($t_sql);
    $stmt->execute([$value]);
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $totalRows = $row[0]; # 取得總筆數 
    echo "<div style='margin-left:270px'> <button type='submit' class='btn btn-primary mb-3 mt-3 ms-2' onclick='window.location.href=`read.php`'>回上一頁</button> </div>";

    if ($totalRows == 0) {
        $rows = [];
        echo "<div style='margin-left:270px'>請回到上一頁，沒有查到資料喔!</div>";
        exit;
    } else {


        $sql = sprintf("SELECT * FROM custom WHERE  $nameV like ?  ORDER BY custom_Id DESC
    LIMIT %s, %s", ($page - 1) * $perPage, $perPage);


        $stmt = $pdo->prepare($sql);
        // echo $_GET['value'] . " " . $_GET['name'];
        $stmt->execute([ $value]);
        $rows = $stmt->fetchAll();
        $page = 1;

        if (empty($rows)) {
?>
            <script>
                isSusccess("請重新輸入");
            </script>
        <?php
            exit;
        } else { ?>
            <script>
                isSusccess("查詢成功");
            </script>
<?php
        }
    }
    //  ===========================================================================================================
} else {


    $t_sql = "SELECT COUNT(1) FROM custom";


    $row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);

    $totalRows = $row[0]; # 取得總筆數
    $totalPages = 0; # 預設值
    $rows = []; # 預設值
    if ($totalRows > 0) {
        $totalPages = ceil($totalRows / $perPage); # 計算總頁數

        if ($page > $totalPages) {
            // redirect
            header('Location: ?page=' . $totalPages);
            exit;
        }

        $sql = sprintf("SELECT * FROM custom ORDER BY custom_Id DESC
LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll();
    }
}
?>
<div class="left-270">

    <div class="read mt-4">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="d-flex">

                    <button type="button" class="btn btn-primary m-1"> <a href="./create.php" class="me-2">我要新增</a></button>
                    <button type="button" class="btn btn-primary m-1"> <a href="./phpCsv.php" class="me-2">我要新增csv(圖片請手動)</a></button>
                    <!-- -->
                </div>
                <button type="button" class="btn btn-danger m-1 "><a href="./logout.php" class="me-2">我1要登出</a></button>
                <!--  -->

            </div>

            <div class="row ">
                <div class="col-12 my-3">
                    <div class="bg-title text-white d-flex  align-items-center py-4 justify-content-center">
                        <h3 class="my-0">我要搜尋</h3>


                        <h4 class="my-0 "><?= isset($_GET["name"]) ? "" : "目前" ?></h4>


                        <h4 class="my-0"><?= isset($_GET["value"]) ? "-" . $_GET["value"] : "-全部" ?></h4>

                    </div>

                </div>

                <form method="post" name="form1" onsubmit="searchData(event)" class="needs-validation d-flex">
                    <div class="col-6 d-flex">
                        <select class="form-select txt_class me-3" aria-label="Default select example" id="txt_class" name="txt_class">
                            <option selected value="false">請選擇欄位</option>
                            <option value="custom_name">姓名</option>
                            <option value="custom_account">帳號</option>
                            <option value="custom_email">電郵</option>
                            <option value="custom_authorId">黑名單</option>
                        </select>

                        <input type="text" class="form-control txt_value me-3" id="txt_value" name="txt_value" placeholder="請輸入搜尋訊息">
                    </div>
                    <div class="col-3 me-3">
                        <button type="button" class="btn btn-primary" onclick="searchData(event)">送出</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col mb-5">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th><i class="fa-brands fa-airbnb"></i>編號</th>
                                <th><i class="fa-brands fa-airbnb"></i>姓名</th>
                                <th><i class="fa-brands fa-airbnb"></i>帳號</th>
                                <th><i class="fa-brands fa-airbnb"></i>電郵</th>
                                <th><i class="fa-brands fa-airbnb"></i>黑名單</th>
                                <th><i class="fa-brands fa-airbnb"></i>註冊日/修改日</th>
                                <th>密碼</th>
                                <th>修改</th>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <div id="databox">
                            <?php foreach ($rows as $r) : ?>
                                <tr>
                                    <td><?= $r['custom_Id'] ?></td>
                                    <td><?= $r['custom_name'] ?></td>
                                    <td><?= $r['custom_account'] ?></td>
                                    <td><?= $r['custom_email'] ?></td>
                                    <td><?= $r['custom_authorId'] == 1 ? "好人" : "黑名單" ?></td>
                                    <td><?= $r['custom_date'] ?></td>
                                    <td class="">
                                        <div class="text password"><?= $r['custom_password'] ?></div>
                                    </td>

                                    <td><a href="edit.php?custom_Id=<?= $r['custom_Id'] ?>">
                                            <i class="fa-solid fa-file-pen"></i>
                                        </a></td>
                                    <td>
                                        <a href="javascript: delete_one(<?= $r['custom_Id'] ?>)">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </div>
                    </table>

                </div>
            </div>
            <div class="row  ">
                <div class="col ">
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination pt-3 d-flex justify-content-center" id="setpagination">


                            <li class="page-item">
                                <a class="page-link <?= $page == 1 ? "disabled" : ""  ?>" href="?page=1">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class='page-link <?= $page == 1 ? "disabled" : ""  ?>' href='?page=<?= $page - 1 > 0 ? $page - 1 : 1 ?>'>
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>
                            <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                                if ($i >= 1 and $i <= $totalPages) : ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                            <?php endif;
                            endfor; ?>

                            <li class="page-item">
                                <a class="page-link <?= $page == $totalPages ? "disabled" : ""  ?>" href="?page=<?= $page + 1 < $totalPages ? $page + 1 : $totalPages ?>">
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link <?= $page == $totalPages ? "disabled" : ""  ?>" href="?page=<?= $totalPages ?>">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
</div>
<?php

// include  __DIR__ . '/../com-parts/script.php'
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';

?>

<script>
    let page = 1;

    function patedata(i) {
        page = i;
    }


    function searchData(e) {
        e.preventDefault();
        dataTotal = "";
        let name = document.querySelector("#txt_class").value;
        let value = document.querySelector("#txt_value").value;
        window.location.href = `read.php?name=${name}&value=${document.querySelector(".txt_value").value}`;

    }


    function delete_one(custom_Id) {
        if (confirm(`是否要刪除編號為 ${custom_Id} 的資料?`)) {
            location.href = `delete.php?custom_Id=${custom_Id}`;
        }
    }
</script>
<?php
// include __DIR__ . '/../parts/html-foot.php'

include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-foot.php';


?>