<?php

if (isset($_POST["btnSubmitLg"])) {
    $sdt = postIndex("txtPhone");
    $mk = postIndex("txtPassW");
    $ckbLuu = postIndex("ckbRemember");

    //Admin đăng nhập
    $data = $admin->getAccount($mk, $sdt);
    if ($data != null && $data[0]["passWord"] == $mk) {
        //Có dữ liệu admin
        $_SESSION["admin_sdt"] = $sdt;
        if ($ckbLuu == 1) {
            setcookie("admin_sdt", $sdt, time() + (86400 * 30), "/");
        }
        header("location:index.php?action=home_ql");
    } else {
        setcookie("err", "Tên đăng nhập hoặc mật khẩu không chính xác!", time() + 1, "/");
        setcookie("sdt", $sdt, time() + 1, "/");
        header("location:index.php?action=login&mod=login");
    }

    //Khách hàng đăng nhập
    $data = $customer->getAccount($mk, $sdt);
    if ($data != null && $data[0]["passWord"] == $mk) {
        //Có dữ liệu người dùng
        $_SESSION["customer_sdt"] = $sdt;
        if ($ckbLuu == 1) {
            setcookie("customer_sdt", $sdt, time() + (86400 * 30), "/");
        }
        header("location:index.php?action=home");
    } else {
        //Không có dữ liệu người dùng
        setcookie("err", "Tên đăng nhập hoặc mật khẩu không chính xác!", time() + 1, "/");
        setcookie("sdt", $sdt, time() + 1, "/");
        header("location:index.php?action=login&mod=login");

    }
}

//Đăng ký tài khoản cho khách hàng
if (isset($_POST["btnSubmitRG"])) {
    $ten = postIndex("txtName");
    $sdt = postIndex("txtPhone");
    $mk = postIndex("txtPassW");
    $ckmk = postIndex("txtCKPassW");

    validate($sdt, $mk, $ckmk, $ten);
    $flag = false;
    $errString = "";
    if ($customer->checkAccountExistence($sdt) == false) {
        //Tài khoản không tồn tại
        if ($mk === $ckmk) {
            $data = $customer->addCustomer($ten, $mk, $sdt);
            if ($data > 0) {
                //Dữ liệu đã được thêm
                setcookie("sdt", $sdt, time() + 1, "/");
                header("location:index.php?action=login&mod=login");
            } else {
                //Dữ liệu chưa được thêm
                $flag = true;
                $errString = "Đăng ký tài khoản không thành công!";
            }
        } else {
            //So sánh mật khẩu
            $flag = true;
            $errString = "Mật khẩu nhập lại không giống";
        }
    } else {
        //Tài khoản đã tồn tại
        $flag = true;
        $errString = "Số điện thoại này đã được đăng ký";
    }
    if ($flag) {
        setcookie("err", $errString, time() + 1, "/");
        setcookie("ten", $ten, time() + 1, "/");
        setcookie("sdt", $sdt, time() + 1, "/");
        header("location:index.php?action=login&mod=register");
    }
}
?>