<style>
    .page-link {
        height: 40px;
    }

    ul li i {
        transform: translate(0px, 5px);
    }
</style>
<?php include __DIR__ . '/parts/comform.php'; ?>

<?php
require __DIR__ . '/parts/db_connect.php';
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

    $totalPages = 0; # 預設值
    if ($_GET['name'] == "custom_name") {
        $t_sql = "SELECT COUNT(1) FROM `custom` WHERE custom_name=?";
    } else if ($_GET['name'] == "custom_Id") {
        $t_sql = "SELECT COUNT(1) FROM `custom` WHERE custom_Id=?";
    } else if ($_GET['name'] == "custom_email") {
        $t_sql = "SELECT COUNT(1) FROM `custom` WHERE custom_email=?";
    } else if ($_GET['name'] == "custom_authorId") {
        $t_sql = "SELECT COUNT(1) FROM `custom` WHERE custom_authorId=?";
    }
    $stmt = $pdo->prepare($t_sql);
    $stmt->execute([$_GET['value']]);
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $totalRows = $row[0]; # 取得總筆數
 
    if ($totalRows == 0) {
        $rows = [];
        echo "請回到上一頁，沒有查到資料喔!";
        exit;
    } else {
        if ($_GET['name'] == "custom_name") {
            $sql = sprintf("SELECT * FROM custom WHERE custom_name=?  ORDER BY custom_Id DESC
    LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        } else if ($_GET['name'] == "custom_Id") {
            $sql = sprintf("SELECT * FROM custom WHERE custom_Id=? ORDER BY custom_Id DESC
        LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        } else if ($_GET['name'] == "custom_email") {
            $sql = sprintf("SELECT * FROM custom WHERE custom_email=? ORDER BY custom_Id DESC
        LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        } else if ($_GET['name'] == "custom_authorId") {
            $sql = sprintf("SELECT * FROM custom WHERE custom_authorId=? ORDER BY custom_Id DESC
        LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        }

        $stmt = $pdo->prepare($sql);
        echo $_GET['value'] . " " . $_GET['name'];
        $stmt->execute([$_GET['value']]);
        $rows = $stmt->fetchAll();


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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="container">
    <div class="d-flex justify-content-center">
        <a href="./create.php" class="me-2">我要新增</a>
        <a href="./create.php" class="me-2">我要登出</a>

    </div>
    <div class="row  ">
        <div class="col ">
            <nav aria-label="Page navigation example ">
                <ul class="pagination pt-3 d-flex justify-content-center" id="setpagination">
                    <li class="page-item">
                        <a class='page-link <?= $page == 1 ? "disabled" : ""  ?>' href='?page=<?= $page - 1 > 0 ? $page - 1 : 1 ?>'>
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link <?= $page == 1 ? "disabled" : ""  ?>" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i>
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
    <div class="row">
        <div class="col-3">
            <h3>我要搜尋</h3>
            <h3><?=isset($_GET["name"])?$_GET["name"]:""?><?=isset($_GET["value"])?"-".$_GET["value"]:""?></h3>
            <h3></h3>
        </div>
        <form method="post" name="form1" onsubmit="searchData(event)" class="needs-validation">
            <div class="col-3 d-flex">
                <select class="form-select txt_class" aria-label="Default select example" id="txt_class" name="txt_class">
                    <option selected value="false">請選擇欄位</option>
                    <option value="custom_name">姓名</option>
                    <option value="custom_Id">帳號</option>
                    <option value="custom_email">電郵</option>
                    <option value="custom_authorId">黑名單</option>
                </select>

                <input type="text" class="form-control txt_value" id="txt_value" name="txt_value">
            </div>
            <div class="col-3 d-flex">
                <button type="button" class="btn btn-primary" onclick="searchData(event)">送出</button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#編號</th>
                        <th>姓名</th>
                        <th>帳號</th>
                        <th>電郵</th>
                        <th>黑名單</th>
                        <th>註冊日/修改日</th>
                        <th>密碼</th>
                        <th>修改</th>
                        <th>刪除</th>
                    </tr>
                </thead>
                <tbody id="databox">
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['custom_Id'] ?></td>
                            <td><?= $r['custom_name'] ?></td>
                            <td><?= $r['custom_account'] ?></td>
                            <td><?= $r['custom_email'] ?></td>
                            <td><?= $r['custom_authorId'] ?></td>
                            <td><?= $r['custom_date'] ?></td>
                            <td><?= $r['custom_password'] ?></td>

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
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php include  __DIR__ . '/assets/js/script.php' ?>

<script>
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        // var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        //     Array.prototype.slice.call(forms)
        //         .forEach(function(form) {
        //             form.addEventListener('submit', function(event) {
        //                 if (!form.checkValidity()) {
        //                     event.preventDefault()
        //                     event.stopPropagation()
        //                 }

        //                 form.classList.add('was-validated')
        //             }, false)
        //         })
    })()
    let page = 1;

    function patedata(i) {
        page = i;
    }

    $('.form1').submit(function(e) {

        return true;
    });

    function searchData(e) {
        e.preventDefault();
        console.log("Aaa");
        dataTotal = "";
        let name = document.querySelector("#txt_class").value;
        console.log(name)
        let value = document.querySelector("#txt_value").value; 
        window.location.href = `read.php?name=${name}&value=${document.querySelector(".txt_value").value}`;
        // form1.submit();

    }


    function delete_one(custom_Id) {
        if (confirm(`是否要刪除編號為 ${custom_Id} 的資料?`)) {
            location.href = `delete.php?custom_Id=${custom_Id}`;
        }
    }
</script>