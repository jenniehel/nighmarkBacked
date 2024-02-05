<?php
if (empty($pageName)) {
    $pageName = "";
}
?>
<style>
    .navbar-nav .nav-link.active {
        background-color: rgb(13, 110, 253);
        border-radius: 10px;
        font-weight: 800;
        color: white;
    }
</style>



<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index_php">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'list' ? 'active' : '' ?>" href="./list3.php">列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?= $pageName == 'add' ? 'active' : '' ?>" href="./add.php">Link</a>
                    </li>

                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'list' ? 'active' : '' ?>" href="./list3.php"><?=$_SESSION["admin"]["nickname"]?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= $pageName == 'logout' ? 'active' : '' ?>" href="./logout.php">登出</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="./login.php">登入</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= $pageName == 'register' ? 'active' : '' ?>" href="./register.php">註冊</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

</div>