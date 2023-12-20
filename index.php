<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    
    <script type="text/javascript" src="js/javascript.js"></script>
    <title>Document</title>
</head>
<body>
    <?php
        include("config/config.php");
        include("classes/Db.class.php");
        include("classes/Admin.class.php");
        include("classes/KhoaHoc.class.php");
        include("classes/GioHang.class.php");
        include("classes/SanPham.class.php");
        include("classes/MuaKhoaHoc.class.php");
        include("classes/NhanVien.class.php");
        include("classes/KhachHang.class.php");
        include("classes/BaiHoc.class.php");
        include("include/function.php");

        $db = new Db();
        $admin = new Admin();
        $sanPham = new SanPham();
        $course = new KhoaHoc();
        $gioHang = new GioHang();
        $purchasedCourse = new MuaKhoaHoc();
        $customer = new KhachHang();
        $employee = new NhanVien();
        $lession = new BaiHoc();

        $action = "home_ql";
        if(getIndex("action") != ''){
        $action = getIndex("action");
        }

        // Giao dien quan ly
        if ($admin->checkLogin()){ 
            if ($action == 'dangxuat'){
                $admin->logOut();
            }?>
    <div class="container" style="max-width: 100%; padding-left: 0px; padding-right: 0px;">
        <div class="row justify-content-center bg-light border-top border-bottom border-2"
            style="width: 100%; margin-left: 0px;">
            <?php include("include/header.php"); ?>
        </div>
        <div class="row" style="width: 100%; margin-left: 0px;">
            <div class="col-lg-3 col-md-3 pdm-No text-center" style="background-color: rgb(0 0 0 / 13%);">
                <ul class="list-group my-2 fw-bolder">
                    <li class="list-group-item list-group-item-action <?php if ($action == "course_manager")
            echo "border-end border-success border-5"; ?>"><a href="?action=course_manager" class="text-black">Quản lý
                            khóa học</a></li>
                    <li class="list-group-item list-group-item-action <?php if ($action == "customer_manager")
            echo "border-end border-success border-5"; ?>"><a href="?action=customer_manager" class="text-black">Quản
                            lý khách hàng</a></li>
                    <li class="list-group-item list-group-item-action <?php if ($action == "employee_manager")
            echo "border-end border-success border-5"; ?>"><a href="?action=employee_manager" class="text-black">Quản
                            lý nhân viên</a></li>
                </ul>
            </div>
            <div id="div_gdql" class="col-lg-9 col-md-9 pdm-No text-center bg-success">
                <script>
                var div_lession = document.getElementById("div_gdql");
                var length = document.documentElement.clientHeight - 90;
                div_lession.style.height = length + "px";
                </script>
                <?php
                    if($action == "home"){
                        $action = "home_ql";
                        }
                    switch($action){
                        case "home_ql":
                            break;
                        case "account_infomation":
                            include("module/CustomerInfomation/showInfomation.php");
                            break;
                        case "customer_manager":
                            include("module/CustomerManager/index.php");
                            break;
                        case "course_manager":
                            include("module/CourseManager/index.php");
                            break;
                        case "employee_manager":
                            include("module/CourseManager/index.php");
                            break;
                    default:
                        echo '<meta http-equiv="refresh" content="0,url=index.php?index.php?action=home_ql">';
                        break;
                    }
                ?>
            </div>
        </div>
    </div>
    <?php } else {
        $action = "home";
        if(getIndex("action") != ''){
        $action = getIndex("action");
        }
        // Giao dien khach hang
        switch ($action) {
            case "home":
                echo "<div>";
                include("include/header.php");
                include_once("module/Home/index.php");
                echo "</div>";
                include("include/footer.php");
                break;
            case "login":
                include("module/Login/index.php");
                break;
            case "search":
                echo "<div>";
                include("include/header.php");
                include("module/Search/index.php");
                echo "</div>";
                include("include/footer.php");
                break;
            case "product_detail":
                echo "<div>";
                include("include/header.php");
                echo "</div>";
                include("module/ProductDetail/index.php");
                include("include/footer.php");
                break;
            case "cus_purchasedCourse":
                echo "<div>";
                include("include/header.php");
                echo "</div>";
                include("module/PurchasedCourse/index.php");
                include("include/footer.php");
                break;
            case "account_infomation":
                echo "<div>";
                include("include/header.php");
                echo "</div>";
                include("module/CustomerInfomation/index.php");
                include("include/footer.php");
                break;
            default:
                if ($action == 'dangxuat') {
                    $customer->logOut();
                    $employee->logOut();
                }
                header("location:index.php?action=home");
                break;
        }
    }
    ?>
    <!-- <iframe name="moiTrang" width="100%" height="700px"></iframe> -->

</body>

</html>