<?php
$user = null;
if ($customer->checkLogin()) {
    $user = $customer->getCustomer(getSession("customer_sdt"));
} else if ($employee->checkLogin()) {
    $user = $employee->getEmployee(getSession("employee_sdt"));
} else if ($admin->checkLogin()) {
    $user = $admin->getAdmin(getSession("admin_sdt"));
}

$dsSPTrongGH = array();
if (isset($user)) {
    $dsSPTrongGH = $gioHang->getAllByCusID($user['ma']);
}

$id = getIndex("id");

if (isset($_POST["btnAddToCart"]) && $id != '') {
    $quantity = postIndex("quantityField");
    $userId = $user['ma'];
    $countProductInCart = $gioHang->isProductInCart($userId, $id);
    if ($countProductInCart) {
        $gioHang->updateQuantity($quantity, $userId, $id);
    } else {
        $gioHang->insertProductIntoCart($userId, $id, $quantity);
    }
    unset($_POST["btnAddToCart"]);
    $dsSPTrongGH = $gioHang->getAllByCusID($user['ma']);
}
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light sticky-top px-lg-5">
    <div class="container-fluid">
        <a class="navbar-brand text-success fw-bold" href="./index.php?action=home">TM_House</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if (getIndex("action") == "home") {
                        echo "text-success";
                    } ?>" aria-current="page" href="./index.php?action=home">Trang chủ</a>
                </li>
            </ul>
            <?php if (!$admin->checkLogin()) { ?>
                <form action="./index.php?action=search" class="d-flex" method="post" role="search">
                    <input class="form-control" name="search" type="search" placeholder="Tìm khóa học" aria-label="Search">
                    <button class="btn btn-outline-success" name="btnSearchSubmit" type="submit">
                        <svg style='font-size:20px' xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg></button>
                </form>
            <?php } ?>
        </div>
    </div>
    <?php if ($user != null) { ?>
        <!-- Menu người dùng -->
        <div class="user_menu dropdown mx-3">
            <div id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./media/image/user/<?php if ($user != null) {
                    if ($user["hinh"] != null) {
                        echo $user["hinh"];
                    } else {
                        echo "default.png";
                    }
                } ?>" width="40px" height="40px" class="rounded-circle" alt="...">
            </div>
            <ul class="dropdown-menu" style="left: unset; right: 0px;" aria-labelledby="dropdownMenuButton2">
                <li class="mx-2 text-center">
                    <img src="./media/image/user/<?php if ($user != null) {
                        if ($user["hinh"] != null) {
                            echo $user["hinh"];
                        } else {
                            echo "default.png";
                        }
                    } ?>" class="img-thumbnail" alt="...">
                    <h5 class="">
                        <?php echo $user["ten"]; ?>
                    </h5>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item  me-5" href="?action=account_infomation">Thông tin tài khoản</a></li>
                <?php if ($customer->checkLogin()) { ?>
                    <li><a class="dropdown-item" href="?action=cus_purchasedCourse">Khóa học đã mua</a></li>
                <?php } ?>
                <li><a class="dropdown-item" onclick="getCLick()" href="?action=dangxuat">Đăng xuất</a></li>
            </ul>
        </div>
    <?php } else { ?>
        <a href="./?action=login&mod=login" class="btn btn-success text-white m-3 navbar-brand" type="button"><b>Đăng
                nhập</b></a>
    <?php } ?>
    <div class="m-3">
        <?php
        include(ROOT . "/include/cart.php");
        ?>
    </div>

</nav>
<!-- end navbar -->

<!-- banner -->
<?php if (getIndex("action") == "home") { ?>
    <div>
        <img src="media/image/slide/8.jpg" class="banner d-block w-100" alt="...">
    </div>
<?php } ?>
<!-- end banner -->