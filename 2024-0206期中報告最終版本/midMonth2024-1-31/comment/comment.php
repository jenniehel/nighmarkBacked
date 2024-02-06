<?php 
// include "parts/db-content.php";
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
$pageName = "comment";
$title = "評論文章列表";

$perPage = 5;
$totalPage = 0;
$rows = [];
$sort = "";

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
    header("Location: ?page=1");
    exit;
};

$t_count = "SELECT COUNT(1) FROM comment";
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
        $sql = sprintf("SELECT * FROM comment ORDER BY comment_id $sort LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll();
    } else {
        $sql = sprintf("SELECT * FROM comment WHERE comment_id LIKE :keyword OR content LIKE :keyword OR recommend_food LIKE :keyword OR parking LIKE :keyword  OR date LIKE :keyword ORDER BY comment_id %s", $sort);

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll();
    }
};
?>

<?php

// include "parts/html-head.php" ?>
<?php

// include "parts/navbar.php" ?>

<link rel="stylesheet" href="./css/comment.css">
<style>


</style>

<div class="container mt-5 ma-left">
<h2>評論管理</h2>
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
                <input type="text" name="keyword" class="form-control" placeholder="可搜尋id日期及輸入關鍵字" autocomplete="off">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-borderless table-striped ">
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
                        <th class="custom_id text-center bg-light p-3">會員#</th>
                        <th class="merchant_id text-center bg-light p-3">商家#</th>
                        <th class="service_rating text-center bg-light p-3">服務評分</th>
                        <th class="product_ratings text-center bg-light p-3">商品評分</th>
                        <th class="content bg-light p-3">評論內容</th>
                        <th class="recommend_food text-center bg-light p-3">推薦餐點</th>
                        <th class="parking text-center bg-light p-3">停車</th>
                        <th class="date text-center bg-light p-3">發表日期</th>
                        <th class="text-center bg-light p-3"><i class="fa-solid fa-file-pen"></i></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td class="text-center p-3">
                                <a href="del.php?comment_id=<?= $r["comment_id"] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                            <td class="text-center p-3"><?= $r["comment_id"] ?></td>
                            <td class="custom_id text-center p-3"><?= $r["custom_id"] ?></td>
                            <td class="merchant_id text-center p-3"><?= $r["merchant_id"] ?></td>
                            <td class="service_rating text-center p-3"><?= $r["service_rating"] ?></td>
                            <td class="product_ratings text-center p-3"><?= $r["product_ratings"] ?></td>
                            <td class="content p-3"><?= $r["content"] ?></td>
                            <td class="recommend_food p-3"><?= $r["recommend_food"] ?></td>
                            <td class="parking p-3"><?= $r["parking"] ?></td>
                            <td class="date text-center p-3"><?= $r["date"] ?></td>
                            <td class="text-center p-3">
                                <a href="edit.php?comment_id=<?= $r["comment_id"] ?>">
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
// include "parts/scripts.php" ?>
<?php 
// include "parts/html-end.php" ?>