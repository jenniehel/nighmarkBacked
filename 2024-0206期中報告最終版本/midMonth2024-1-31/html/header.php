<?php require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php'; ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php'; ?>
<style>
  a {
  color: rgba(var(--bs-link-color-rgb),var(--bs-link-opacity, 1));
  text-decoration: none !important;
}
</style>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <!-- Sidebar Start -->
  <aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
          <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav" class="px-0">
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">顧客會員</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../custom/read.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">客戶資訊</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">賣家資料</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../seller/list.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">賣家資料</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">產品資料</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../product/list.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">產品資料</span>
            </a>
          </li>
         
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">訂單管理</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../order/list.php" aria-expanded="false">
              <span>
              <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">訂單管理</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../order/add.php" aria-expanded="false">
              <span>
              <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">新增訂單</span>
            </a>
          </li>
          
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">廣告管理</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../ad/ad-record.php" aria-expanded="false">
              <span>
              <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">廣告管理</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../ad/add-ad.php" aria-expanded="false">
              <span>
              <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">廣告新增</span>
            </a>
          </li>
        
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">評論區</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../comment/comment.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">評論管理</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../comment/add.php" aria-expanded="false">
              <span>
              <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">評論區新增</span>
            </a>
          </li>
        
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">遊戲區</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../game/game_data.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">遊戲資料</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../game/add-game_data.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">遊戲新增</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../clear/clear_data.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">通關資料</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../balloon/balloon_data.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">氣球資料</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="../balloon/add-balloon_data.php" aria-expanded="false">
              <span>
                <i class="ti ti-article"></i>
              </span>
              <span class="hide-menu">氣球新增</span>
            </a>
          </li>
        
        </ul>
        <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
          <div class="d-flex">
            <div class="unlimited-access-title me-3">
              <h6 class="fw-semibold fs-4 mb-6 text-dark w-85"></h6>
              <a href="../custom/logout.php" target="_blank" class="btn btn-primary fs-5 fw-semibold lh-sm">登出</a>
            </div>
            <div class="unlimited-access-img">
              <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
  <!--  Sidebar End -->
  <!--  Main wrapper -->
  <div class="body-wrapper">
    <!--  Header Start -->
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
              <i class="ti ti-bell-ringing"></i>
              <div class="notification bg-primary rounded-circle"></div>
            </a>
          </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <!-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a> -->
            <li class="nav-item dropdown">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">My Profile</p>
                  </a>
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-mail fs-6"></i>
                    <p class="mb-0 fs-3">My Account</p>
                  </a>
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-list-check fs-6"></i>
                    <p class="mb-0 fs-3">My Task</p>
                  </a>
                  <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!--  Header End -->
    <div class="container-fluid" style="margin-left: 270px;">

    </div>
  </div>
</div>

</div>
</div>