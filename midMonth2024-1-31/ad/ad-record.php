<?php 
//  include "parts/html-head.php" 
//  include "parts/navbar.php" 
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';

$pageName = "adRecord";
$title = "廣告紀錄表";

$perPage = 5;
$totalPage = 0;
$rows = [];
$sort = "";

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
    header("Location: ?page=1");
    exit;
};

$t_count = "SELECT COUNT(1) FROM ad_record";
$t_rows = $pdo->query($t_count)->fetch(PDO::FETCH_NUM);

$totalRows = $t_rows[0];

if ($totalRows > 0) {
    $totalPage = ceil($totalRows / $perPage);

    if ($page > $totalPage) {
        header("Location: ?page=" . $totalPage);
        exit;
    };

    $toggle = isset($_GET["toggle"]) ? intval($_GET["toggle"]) : 0;
    if ($toggle == 0) {
        $sort = 'desc';
    } else if ($toggle == 1) {
        $sort = '';
    }

    $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

    if (empty($keyword)) {
        $sql = sprintf("SELECT * FROM ad_record ORDER BY record_id $sort LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll();
    } else {
        $sql = sprintf("SELECT * FROM ad_record WHERE state LIKE :keyword ORDER BY record_id %s", $sort);

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll();
    }
};
?>



<link rel="stylesheet" href="./public/css/ad-record.css">

<div class="container mt-5">
    <div class="row">
        <div class="col-8 d-flex">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($page <= $totalPage) : ?>
                        <li class="page-item <?= $page == 1 ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= 1 ?>">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < $totalPage) : ?>
                        <li class="page-item <?= $page == 1 ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $page - 1; $i <= $page + 1; $i++) :
                        if ($i >= 1 && $i <= $totalPage) : ?>
                            <li class="page-item <?= $i == $page ? "active" : "" ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>

                    <?php if ($page < $totalPage) : ?>
                        <li class="page-item <?= $page == $totalPage ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page <= $totalPage) : ?>
                        <li class="page-item <?= $page == $totalPage ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= $totalPage ?>">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <form class="ms-3">
                <input type="text" name="page" class="form-control w-50" placeholder="跳轉" autocomplete="off">
            </form>
        </div>

        <div class="col-4">
            <form>
                <input type="text" name="keyword" class="form-control" placeholder="輸入關鍵字" autocomplete="off">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th class="text-center bg-light p-3 no"><i class="fa-solid fa-trash"></i></th>
                        <th class="text-center bg-light p-3">
                            #
                            <?php for ($i = $page; $i <= $page; $i++) :
                                if ($i >= 1 && $i <= $totalPage) : ?>
                                    <a href="?toggle=<?= $toggle == 0 ? 1 : 0 ?>&page=<?= $i ?>">
                                        <?php if ($toggle == 0) : ?>
                                            <i class="fa-solid fa-arrow-up-wide-short"></i>
                                        <?php else : ?>
                                            <i class="fa-solid fa-arrow-down-short-wide"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                    </a>
                        </th>
                        <th class="text-center bg-light p-3">廣告位#</th>
                        <th class="text-center bg-light p-3">商家#</th>
                        <th class="text-center bg-light p-3">圖片</th>
                        <th class="text-center bg-light p-3">開始日起</th>
                        <th class="text-center bg-light p-3">點擊率</th>
                        <th class="text-center bg-light p-3">狀態</th>
                        <th class="text-center bg-light p-3"><i class="fa-solid fa-file-pen"></i></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td class="text-center p-3">
                                <a href="del.php?record_id=<?= $r["record_id"] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                            <td class="text-center p-3"><?= $r["record_id"] ?></td>
                            <td class="text-center p-3"><?= $r["ad_id"] ?></td>
                            <td class="text-center p-3"><?= $r["merchant_Id"] ?></td>
                            <td class="text-center p-3 img-td">
                                <img style="height: 100px;" src="public/images/<?= $r["ad_image"] ?>" alt="">
                            </td>
                            <td class="text-center p-3"><?= $r["start_date"] ?></td>
                            <td class="text-center p-3"><?= $r["clicks"] ?></td>
                            <td class="text-center p-3"><?= $r["state"] ?></td>
                            <td class="text-center p-3">
                                <a href="edit-ad.php?record_id=<?= $r["record_id"] ?>">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include "parts/scripts.php";
// include "parts/html-end.php"

?>